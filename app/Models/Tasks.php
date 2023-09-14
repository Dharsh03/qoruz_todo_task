<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tasks extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     * */
    protected $table = 'tasks';
    protected $dates = ['deleted_at'];
    /**
     * @var array
     * */
    protected $fillable = [

        'id', 'task_title', 'task_due_date', 'task_status'
    ];

}
