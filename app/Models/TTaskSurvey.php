<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTaskSurvey extends Model
{
    protected $table = 't_task_survey';
    protected $primaryKey = 'TaskID';
    public $timestamps = false;
}
