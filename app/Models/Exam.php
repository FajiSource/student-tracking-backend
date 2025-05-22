<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    //
    public $table = 'exams';

    protected $fillable = [
        'subject_id',
        'name',
        'done',
        'startTime',
        'endTime',
        'maxScore',
        'passingScore',
      
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    // public function getSubjectNameAttribute()
    // {
    //     return $this->subject->name;
    // }
    // public function getScoreAttribute()
    // {
    //     return $this->scores->pluck('score')->implode(', ');
    // }
    // public function getStudentNameAttribute()
    // {
    //     return $this->scores->pluck('student.fName')->implode(', ');
    // }
    // public function getStudentCountAttribute()
    // {
    //     return $this->scores->count();
    // }
  
    // public function getStartTimeAttribute()
    // {
    //     return $this->startTime ? $this->startTime->format('Y-m-d H:i:s') : null;
    // }
    // public function getEndTimeAttribute()
    // {
    //     return $this->endTime ? $this->endTime->format('Y-m-d H:i:s') : null;
    // }
    // public function getMaxScoreAttribute()
    // {
    //     return $this->maxScore ? $this->maxScore : null;
    // }
    // public function getPassingScoreAttribute()
    // {
    //     return $this->passingScore ? $this->passingScore : null;
    // }
    
    
}
