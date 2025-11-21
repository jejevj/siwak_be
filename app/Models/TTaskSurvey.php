<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTaskSurvey extends Model
{
    protected $table = 't_task_survey';
    protected $primaryKey = 'TaskID';
    public $timestamps = false;  // because your table uses CreatedDate, not created_at

    protected $fillable = [
        'iduser',
        'identitas_no',
        'nama_surveyor',
        'ID_Dir',
        'StatusTask',
        'StatusTanah',
        'KetSurvey',
        'KetVerify',
        'idkuisoner',
        'verifikator',
        'verified_at',
        'CreatedDate',
    ];

    // relation: one task has many detail rows
    public function details()
    {
        return $this->hasMany(TTaskSurveyDetail::class, 'task_id', 'TaskID');
    }
}
