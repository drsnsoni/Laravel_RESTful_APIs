<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpadteTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    //
    public function index(Request $request){



        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done')
            ->defaultSort('-created_at')
            ->allowedSorts(['title', 'is_done', 'created_at'])
            ->paginate();
        return new TaskCollection($tasks);
    }

    public function show(Request $request, Task $task){
        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $task = Task::create($validated);
        return new TaskResource($task);
    }

    public function update(UpadteTaskRequest $request, Task $task)
    {
        $validated =  $request->validated();
        $task->update($validated);
        return new TaskResource($task);
    }

    public function destroy(Request $request, Task $task)
    {

        $task->delete();
        return response()->noContent();
    }
}
