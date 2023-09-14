<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubTasks extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * @var string
     * */
    protected $table = 'sub_tasks';
    
    /**
     * @var array
     * */
    protected $fillable = [

        'id', 'sub_task_title', 'task_id', 'sub_task_status'
    ];
}
