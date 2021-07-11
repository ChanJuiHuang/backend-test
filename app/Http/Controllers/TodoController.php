<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoCreateRequest;
use App\Http\Requests\TodoDeleteRequest;
use App\Http\Requests\TodoSearchRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Modules\Todo\Services\TodoService;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(
        TodoService $todoService
    ) {
        $this->middleware('accessTokenChecker')
            ->except([
                'search',
                'find',
            ]);
        $this->todoService = $todoService;
    }

    public function create(TodoCreateRequest $request)
    {
        $this->todoService
            ->create($request->validated());
    }

    public function search(TodoSearchRequest $request)
    {
        $queryStrings = $request->validated();
        data_fill($queryStrings, 'where_conditions', []);
        [
            'where_conditions' => $whereConditions,
            'page' => $page,
            'number_per_page' => $numberPerPage
        ] = $queryStrings;

        return $this->todoService
            ->search(
                $whereConditions,
                $page,
                $numberPerPage
            );
    }

    public function find(int $id)
    {
        return $this->todoService
            ->find($id);
    }

    public function update(TodoUpdateRequest $request, int $id)
    {
        $this->todoService
            ->update($id, $request->validated());
    }

    public function delete(TodoDeleteRequest $request)
    {
        $this->todoService
            ->delete($request->validated()['ids']);
    }
}
