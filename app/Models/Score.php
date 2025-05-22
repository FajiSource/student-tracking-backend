<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //

    protected $fillable = [
        'student_id',
        'exam_id',
        'score',
        'updated_at'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function getStudentNameAttribute()
    {
        return $this->student->fName;
    }
    public function getExamNameAttribute()
    {
        return $this->exam->name;
    }
    public function getSubjectNameAttribute()
    {
        return $this->subject->name;
    }

    public function getStudentCountAttribute()
    {
        return $this->student->count();
    }
    public function getExamCountAttribute()
    {
        return $this->exam->count();
    }
    public function getSubjectCountAttribute()
    {
        return $this->subject->count();
    }

    public function getUpdatedAtAttribute($value)
{
    return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s') : null;
}

    public function getFullNameAttribute()
    {
        return $this->student->fName . ' ' . $this->student->lName;
    }
    public function getExamFullNameAttribute()
    {
        return $this->exam->name . ' ' . $this->exam->subject->name;
    }
    public function getSubjectFullNameAttribute()
    {
        return $this->subject->name . ' ' . $this->subject->block->name;
    }
    public function getStudentExamAttribute()
    {
        return $this->student->exams->pluck('name')->implode(', ');
    }
    public function getStudentSubjectAttribute()
    {
        return $this->student->subjects->pluck('name')->implode(', ');
    }
    public function getExamSubjectAttribute()
    {
        return $this->exam->subject->name;
    }
    public function getSubjectStudentAttribute()
    {
        return $this->subject->students->pluck('fName')->implode(', ');
    }
    public function getStudentExamCountAttribute()
    {
        return $this->student->exams->count();
    }
    public function getStudentSubjectCountAttribute()
    {
        return $this->student->subjects->count();
    }
    public function getExamSubjectCountAttribute()
    {
        return $this->exam->subject->count();
    }
    public function getSubjectStudentCountAttribute()
    {
        return $this->subject->students->count();
    }
    public function getStudentExamScoreCountAttribute()
    {
        return $this->student->exams->count();
    }
    public function getStudentSubjectScoreCountAttribute()
    {
        return $this->student->subjects->count();
    }
    public function getExamSubjectScoreCountAttribute()
    {
        return $this->exam->subject->count();
    }
    public function getSubjectStudentScoreCountAttribute()
    {
        return $this->subject->students->count();
    }
}
