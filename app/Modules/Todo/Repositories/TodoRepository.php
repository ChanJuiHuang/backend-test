<?php

namespace App\Modules\Todo\Repositories;

use App\Modules\Todo\Models\Todo;

class TodoRepository
{
    public function create(array $attributes): Todo
    {
        return Todo::create($attributes);
    }
}
