<?php

namespace App\Modules\Todo\Services;

use App\Modules\Todo\Models\Todo;
use App\Modules\Todo\Repositories\TodoRepository;
use Illuminate\Support\Facades\Storage;

class TodoService
{
    protected $todoRepository;

    public function __construct(
        TodoRepository $todoRepository
    ) {
        $this->todoRepository = $todoRepository;
    }

    public function create(array $attributes): void
    {
        $attributes['attachment_path'] = $attributes['attachment']
            ->store('attachments', 'public');
        $this->todoRepository
            ->create($attributes);
    }

    protected function getAttachmentUrl(): callable
    {
        return function ($todoList) {
            $todoList['attachment_url'] = Storage::disk('public')
                ->url($todoList['attachment_path']);

            return $todoList;
        };
    }

    public function search(
        array $whereConditions,
        int $page,
        int $numberPerPage
    ): array {
        $data = $this->todoRepository
            ->search(
                $whereConditions,
                $page,
                $numberPerPage
            );
        $data = $data->map($this->getAttachmentUrl());
        $total = $this->todoRepository
            ->getTotal($whereConditions);

        return [
            'data' => $data,
            'page' => $page,
            'number_per_page' => $numberPerPage,
            'total' => $total,
        ];
    }

    public function find(int $id): Todo
    {
        $todoList = $this->todoRepository
            ->find($id);
        $todoList = $this->getAttachmentUrl()($todoList);

        return $todoList;
    }

    public function update(int $id, array $attributes): void
    {
        $todoList = $this->todoRepository
            ->find($id);
        $oldAttachmentPath = $todoList['attachment_path'];

        if (isset($attributes['attachment'])) {
            Storage::disk('public')
                ->delete($oldAttachmentPath);
            $attributes['attachment_path'] = $attributes['attachment']
                ->store('attachments', 'public');
        }
        $this->todoRepository
            ->update($id, $attributes);
    }

    public function delete(array $ids): void
    {
        $todoList = $this->todoRepository
            ->getByIds($ids);
        $this->todoRepository
            ->delete($ids);

        foreach ($todoList as $todo) {
            Storage::disk('public')
                ->delete($todo['attachment_path']);
        }
    }
}
