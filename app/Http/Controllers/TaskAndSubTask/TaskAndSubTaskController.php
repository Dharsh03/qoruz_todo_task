<?php

namespace App\Http\Controllers\TaskAndSubTask;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TaskAndSubTask\TaskAndSubTaskService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateSubTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\ListTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskAndSubTaskController extends Controller
{
    /**
     * @var TaskAndSubTaskService
     * */
    private $taskAndSubTaskService;

    public function __construct(TaskAndSubTaskService $taskAndSubTaskService)
    {
        $this->taskAndSubTaskService = $taskAndSubTaskService;
    }

    /**
     * Funtion to Create Task
     * @param CreateTaskRequest $request
     * @return JsonResponse
     */
    public function createTask(CreateTaskRequest $request): JsonResponse
    {
        $this->taskAndSubTaskService->createTask($request->all());
        return response()->json($this->taskAndSubTaskService->setResultData());
    }

    /**
     * Funtion to Create Task
     * @param CreateSubTaskRequest $request
     * @return JsonResponse
     */
    public function createSubTask(CreateSubTaskRequest $request): JsonResponse
    {
        $this->taskAndSubTaskService->createSubTask($request->all());
        return response()->json($this->taskAndSubTaskService->setResultData());
    }

    /**
     * Funtion to Create Task
     * @param DeleteTaskRequest $request
     * @return JsonResponse
     */
    public function deleteTask(DeleteTaskRequest $request): JsonResponse
    {
        $this->taskAndSubTaskService->deleteTask($request->all());
        return response()->json($this->taskAndSubTaskService->setResultData());
    }

    /**
     * Funtion to Create Task
     * @param ListTaskRequest $request
     * @return JsonResponse
     */
    public function listTask(ListTaskRequest $request): JsonResponse
    {
        $this->taskAndSubTaskService->listTask($request->all());
        return response()->json($this->taskAndSubTaskService->setResultData());
    }

    /**
     * Funtion to Create Task
     * @param UpdateTaskRequest $request
     * @return JsonResponse
     */
    public function updateTask(UpdateTaskRequest $request): JsonResponse
    {
        $this->taskAndSubTaskService->updateTask($request->all());
        return response()->json($this->taskAndSubTaskService->setResultData());
    }

}
