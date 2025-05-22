<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $fillable = [
        'name',
        'level_id',
        'course_id',
        'first_schedule',
        'second_schedule',
    ];
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function block()
    {
        return $this->belongsTo(Block::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    public function getStudent(){
        return $this->level;
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
    public function getLevelNameAttribute()
    {
        return $this->level->level;
    }
    public function getCourseNameAttribute()
    {
        return $this->course->name;
    }
    public function getBlockNameAttribute()
    {
        return $this->block->name;
    }
    public function getStudentNameAttribute()
    {
        return $this->students->pluck('fName')->implode(', ');
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
    public function getExamCountAttribute()
    {
        return $this->exams->count();
    }
    public function getStudentScoreAttribute()
    {
        return $this->students->pluck('score')->implode(', ');
    }
    public function getStudentExamAttribute()
    {
        return $this->students->pluck('exam')->implode(', ');
    }
    public function getStudentLevelAttribute()
    {
        return $this->students->pluck('level')->implode(', ');
    }
    public function getStudentCourseAttribute()
    {
        return $this->students->pluck('course')->implode(', ');
    }
    public function getStudentBlockAttribute()
    {
        return $this->students->pluck('block')->implode(', ');
    }
    
}
