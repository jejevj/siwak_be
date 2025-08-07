<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTaskSurveyDetail extends Model
{
    use HasFactory;

    protected $table = 't_task_survey_details';

    protected $fillable = [
        'task_id',
        'id_pertanyaan',
        'group_pertanyaan',
        'tipe_pertanyaan',
        'jawaban',
    ];

    public function taskSurvey()
    {
        return $this->belongsTo(TTaskSurvey::class, 'task_id', 'TaskID');
    }
}
