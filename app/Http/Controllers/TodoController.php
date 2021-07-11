<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoCreateRequest;
use App\Modules\Todo\Services\TodoService;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(
        TodoService $todoService
    ) {
        $this->todoService = $todoService;
    }

    public function create(TodoCreateRequest $request)
    {
        $this->todoService
            ->create($request->validated());
    }
}
