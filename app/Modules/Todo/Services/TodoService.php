<?php

namespace App\Modules\Todo\Services;

use App\Modules\Todo\Repositories\TodoRepository;

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
}
