<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //

    public $table = 'attendance';
    
    protected $fillable = ['subject_id', 'student_id', 'present', 'created_at'];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function scopeFilterByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
    public function scopeFilterBySubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }
    public function scopeFilterByDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByPresent($query, $present)
    {
        return $query->where('present', $present);
    }
    public function scopeFilterByAbsent($query, $absent)
    {
        return $query->where('present', $absent);
    }
    public function scopeFilterByStudentAndSubject($query, $studentId, $subjectId)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId);
    }
    public function scopeFilterByStudentAndDate($query, $studentId, $date)
    {
        return $query->where('student_id', $studentId)->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndDateRange($query, $studentId, $startDate, $endDate)
    {
        return $query->where('student_id', $studentId)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterBySubjectAndDate($query, $subjectId, $date)
    {
        return $query->where('subject_id', $subjectId)->whereDate('created_at', $date)->with("student");
    }
    public function scopeFilterBySubjectAndDateRange($query, $subjectId, $startDate, $endDate)
    {
        return $query->where('subject_id', $subjectId)->whereBetween('created_at', [$startDate, $endDate]);
    }
   
    
}
