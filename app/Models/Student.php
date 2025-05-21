<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    public $table = "students";
    protected $fillable = [
        'fName',
        'lName',
        'nName',
        'age',
        'level_id',
        'block_id',
        'course_id',
        'email',
        'phone',
        'gender',
        'birthdate',
        'image'
    ];
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function block()
    {
        return $this->belongsTo(Block::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subjects');
    }
    public function filterBySubject($subjectID){
        return $this->subjects->where("id",$subjectID);
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    public function getLevelNameAttribute()
    {
        return $this->level->level;
    }
    public function getBlockNameAttribute()
    {
        return $this->block->name;
    }
    public function getCourseNameAttribute()
    {
        return $this->course->name;
    }
    public function getSubjectNameAttribute()
    {
        return $this->subjects->pluck('name')->implode(', ');
    }
    public function getScoreAttribute()
    {
        return $this->scores->pluck('score')->implode(', ');
    }
    public function getExamAttribute()
    {
        return $this->exams->pluck('name')->implode(', ');
    }
    public function getStudentCountAttribute()
    {
        return $this->students->count();
    }
    public function getScoreCountAttribute()
    {
        return $this->scores->count();
    }
    public function getSubjectCountAttribute()
    {
        return $this->subjects->count();
    }
    public function getFullNameAttribute()
    {
        return $this->fName . ' ' . $this->lName;
    }
    
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

}
