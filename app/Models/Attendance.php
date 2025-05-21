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
    public function scopeFilterByStudentAndPresent($query, $studentId, $present)
    {
        return $query->where('student_id', $studentId)->where('present', $present);
    }
    public function scopeFilterByStudentAndAbsent($query, $studentId, $absent)
    {
        return $query->where('student_id', $studentId)->where('present', $absent);
    }
    public function scopeFilterBySubjectAndPresent($query, $subjectId, $present)
    {
        return $query->where('subject_id', $subjectId)->where('present', $present);
    }
    public function scopeFilterBySubjectAndAbsent($query, $subjectId, $absent)
    {
        return $query->where('subject_id', $subjectId)->where('present', $absent);
    }
    public function scopeFilterByStudentAndSubjectAndDate($query, $studentId, $subjectId, $date)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndSubjectAndDateRange($query, $studentId, $subjectId, $startDate, $endDate)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndPresentAndDate($query, $studentId, $present, $date)
    {
        return $query->where('student_id', $studentId)->where('present', $present)->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndAbsentAndDate($query, $studentId, $absent, $date)
    {
        return $query->where('student_id', $studentId)->where('present', $absent)->whereDate('created_at', $date);
    }
    public function scopeFilterBySubjectAndPresentAndDate($query, $subjectId, $present, $date)
    {
        return $query->where('subject_id', $subjectId)->where('present', $present)->whereDate('created_at', $date);
    }
    public function scopeFilterBySubjectAndAbsentAndDate($query, $subjectId, $absent, $date)
    {
        return $query->where('subject_id', $subjectId)->where('present', $absent)->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndPresentAndDateRange($query, $studentId, $present, $startDate, $endDate)
    {
        return $query->where('student_id', $studentId)->where('present', $present)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndAbsentAndDateRange($query, $studentId, $absent, $startDate, $endDate)
    {
        return $query->where('student_id', $studentId)->where('present', $absent)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterBySubjectAndPresentAndDateRange($query, $subjectId, $present, $startDate, $endDate)
    {
        return $query->where('subject_id', $subjectId)->where('present', $present)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterBySubjectAndAbsentAndDateRange($query, $subjectId, $absent, $startDate, $endDate)
    {
        return $query->where('subject_id', $subjectId)->where('present', $absent)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndSubjectAndPresent($query, $studentId, $subjectId, $present)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $present);
    }
    public function scopeFilterByStudentAndSubjectAndAbsent($query, $studentId, $subjectId, $absent)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $absent);
    }
    public function scopeFilterByStudentAndSubjectAndPresentAndDate($query, $studentId, $subjectId, $present, $date)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $present)->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndSubjectAndAbsentAndDate($query, $studentId, $subjectId, $absent, $date)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $absent)->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndSubjectAndPresentAndDateRange($query, $studentId, $subjectId, $present, $startDate, $endDate)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $present)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndSubjectAndAbsentAndDateRange($query, $studentId, $subjectId, $absent, $startDate, $endDate)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $absent)->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndSubjectAndPresentAndAbsent($query, $studentId, $subjectId, $present, $absent)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $present)->where('present', $absent);
    }
    public function scopeFilterByStudentAndSubjectAndPresentAndAbsentAndDate($query, $studentId, $subjectId, $present, $absent, $date)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $present)->where('present', $absent)->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndSubjectAndPresentAndAbsentAndDateRange($query, $studentId, $subjectId, $present, $absent, $startDate, $endDate)
    {
        return $query->where('student_id', $studentId)->where('subject_id', $subjectId)->where('present', $present)->where('present', $absent)->whereBetween('created_at', [$startDate, $endDate]);
    }
    
}
