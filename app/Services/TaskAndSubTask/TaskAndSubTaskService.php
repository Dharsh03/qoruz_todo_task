<?php
namespace App\Services\TaskAndSubTask;

use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\SubTasks;

class TaskAndSubTaskService
{
    /**
     * @var array
     * */
    private $result;

    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Funtion to Create Task
     * @param $params
     * @return void
     */
    public function createTask($params): void
    {
        try {
            Tasks::create([
                'task_title' => $params['task_title'],
                'task_due_date' => $params['task_due_date'],
                'task_status' => _pending(),
            ]);
            $this->result = $this->getSuccessMessage('Task Created Successfully');
        } catch (\Exception $e) {
            $this->result = $this->getErrorMessage($e);
        }
    }

    /**
     * Funtion to Create sub Task
     * @param $params
     * @return void
     */
    public function createSubTask($params): void
    {
        try {
            SubTasks::create([
                'sub_task_title' => $params['sub_task_title'],
                'task_id' => $params['task_id'],
                'sub_task_status' => _pending(),
            ]);
            $this->result = $this->getSuccessMessage('Sub Task Created Successfully');

        } catch (\Exception $e) {
            $this->result = $this->getErrorMessage($e);
        }
    }

     /**
     * Funtion to delete Task
     * @param $params
     * @return void
     */
    public function deleteTask($params): void
    {
        try {
            SubTasks::where('task_id',$params['task_id'])->delete();
            Tasks::where('id',$params['task_id'])->delete();
            $this->result = $this->getSuccessMessage('Task Deleted Successfully');

        } catch (\Exception $e) {
            $this->result = $this->getErrorMessage($e);
        }
    }

    /**
     * Funtion to list Task and sub task
     * @param $params
     * @return void
     */
    public function listTask($params): void
    {
        try {
            $tasks = Tasks::leftjoin('sub_tasks as st','st.task_id','=','tasks.id')->where('tasks.task_status',_pending())
            ->when(isset($params['search_key']) && !empty($params['search_key']), function ($query) use ($params) {
                    $query->where('tasks.task_title', 'like', $params['search_key'] . '%')
                        ->orWhere('st.sub_task_title', 'like', $params['search_key'] . '%');
            })
            ->when(isset($params['filter']) && !empty($params['filter']), function ($subQuery) use ($params) {
                //filter will today,this_week,next_week,overdue
                $date = $this->getFromAndToDate($params['filter']);
                if($date){
                    $subQuery->where('tasks.task_due_date','>=',$date['from_date'])
                        ->where('tasks.task_due_date','<=',$date['to_date']);
                }
            })
            ->select('tasks.id as task_id','tasks.task_title','tasks.task_due_date')
            ->orderBy('tasks.task_due_date','asc')->groupBy('tasks.id','tasks.task_title','tasks.task_due_date')
            ->get()->toArray();
            
            
            foreach($tasks as $key => $task){
                $tasks[$key]['sub_tasks'] = SubTasks::where(['task_id' => $task['task_id'],'sub_task_status' =>_pending()])->select('id as sub_task_id','sub_task_title')->get()->toArray();
            }
            
            $this->result = array_merge($this->getSuccessMessage('Task Listed Successfully'),['pending_tasks' => $tasks]);
        } catch (\Exception $e) {
            $this->result = $this->getErrorMessage($e);
        }
    }

    /**
     * Funtion to get the from and to date
     * @param $filter
     * @return array
     */
    public function getFromAndToDate($filter): array
    {
        $currentDate = Carbon::now();
        switch ($filter){
            case 'today':
                $fromDate = $toDate = date("Y-m-d");
                break;
            case 'this_week':
                $fromDate = $currentDate->startOfWeek()->toDateString();
                $toDate = $currentDate->endOfWeek()->toDateString();
                break;
            case 'next_week':
                $fromDate = $currentDate->startOfWeek()->addWeek()->toDateString();
                $toDate = $currentDate->endOfWeek()->toDateString();
                break;
            case 'overdue':
                $fromDate = '';
                $toDate = $currentDate->subDay()->toDateString();
                break;
            default:
                return [];
        }
        return ['from_date' => $fromDate, 'to_date' => $toDate];
    }

    /**
     * Funtion to update Task
     * @param $params
     * @return void
     */
    public function updateTask($params): void
    {
        try {
            Tasks::where('id',$params['task_id'])->update(['task_status' => $params['update_staus']]);
            SubTasks::where('task_id',$params['task_id'])->update(['sub_task_status' => $params['update_staus']]);
            $this->result = $this->getSuccessMessage('Task Updated Successfully');

        } catch (\Exception $e) {
            $this->result = $this->getErrorMessage($e);
        }
    }

    /**
     * Function to get success message
     * @param $message
     * @return array
     */
    public function getSuccessMessage($message): array
    {
        return [
            'status' => 'Y',
            'message' => $message
        ];
    }

    /**
     * Function to get error message
     * @param $e
     * @return array
     */
    public function getErrorMessage($e): array
    {
        return [
            'status' => 'N',
            'message' => $e->getMessage(),
        ];
    }

    
    /**
     * Funtion to set result data
     * @return  array
     */
    public function setResultData(): array
    {
        return array('result' => $this->result);
    }
}