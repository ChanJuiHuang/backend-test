<?php

namespace App\Modules\Todo\Repositories;

use App\Modules\Todo\Models\Todo;
use Illuminate\Support\Collection;

class TodoRepository
{
    public function create(array $attributes): Todo
    {
        return Todo::create($attributes);
    }

    public function getTotal(array $whereConditions): int
    {
        return Todo::where($whereConditions)
            ->count();
    }

    public function search(
        array $whereConditions,
        int $page,
        int $numberPerPage
    ): Collection {
        return Todo::where($whereConditions)
            ->orderBy('created_at', 'asc')
            ->offset(($page - 1) * $numberPerPage)
            ->limit($numberPerPage)
            ->get();
    }

    public function find(int $id): Todo
    {
        return Todo::find($id);
    }

    public function update(int $id, array $attributes): int
    {
        return Todo::find($id)
            ->fill($attributes)
            ->save();
    }

    public function delete(array $ids): int
    {
        return Todo::whereIn('id', $ids)
            ->delete();
    }

    public function getByIds(array $ids): Collection
    {
        return Todo::whereIn('id', $ids)
            ->get();
    }
}
