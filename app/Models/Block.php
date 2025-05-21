<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    //

    protected $fillable = [
        'name',
        'level_id',
        'course_id',
    ];
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function getLevelNameAttribute()
    {
        return $this->level->level;
    }
    


    public function getCourseNameAttribute()
    {
        return $this->course->name;
    }
    public function getStudentNameAttribute()
    {
        return $this->students->pluck('fName')->implode(', ');
    }
    public function getSubjectNameAttribute()
    {
        return $this->subjects->pluck('name')->implode(', ');
    }
    public function getExamNameAttribute()
    {
        return $this->exams->pluck('name')->implode(', ');
    }

    public function getStudentCountAttribute()
    {
        return $this->students->count();
    }
    public function getSubjectCountAttribute()
    {
        return $this->subjects->count();
    }
    public function getExamCountAttribute()
    {
        return $this->exams->count();
    }
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->level->level . ' ' . $this->course->name;
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function scopeFilterByLevel($query, $levelId)
    {
        return $query->where('level_id', $levelId);
    }
    public function scopeFilterByCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }
    public function scopeFilterByStudent($query, $studentId)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        });
    }
    public function scopeFilterBySubject($query, $subjectId)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        });
    }
    public function scopeFilterByExam($query, $examId)
    {
        return $query->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        });
    }
    public function scopeFilterByDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndSubject($query, $studentId, $subjectId)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        });
    }
    public function scopeFilterByStudentAndExam($query, $studentId, $examId)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        });
    }
    public function scopeFilterBySubjectAndExam($query, $subjectId, $examId)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        });
    }
    public function scopeFilterByStudentAndDate($query, $studentId, $date)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndDateRange($query, $studentId, $startDate, $endDate)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterBySubjectAndDate($query, $subjectId, $date)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->whereDate('created_at', $date);
    }
    public function scopeFilterBySubjectAndDateRange($query, $subjectId, $startDate, $endDate)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndPresent($query, $studentId, $present)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->where('present', $present);
    }
    public function scopeFilterByStudentAndAbsent($query, $studentId, $absent)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->where('present', $absent);
    }
    public function scopeFilterBySubjectAndPresent($query, $subjectId, $present)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->where('present', $present);
    }
    public function scopeFilterBySubjectAndAbsent($query, $subjectId, $absent)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->where('present', $absent);
    }
    public function scopeFilterByExamAndDate($query, $examId, $date)
    {
        return $query->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        })->whereDate('created_at', $date);
    }
    public function scopeFilterByExamAndDateRange($query, $examId, $startDate, $endDate)
    {
        return $query->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        })->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndExamAndDate($query, $studentId, $examId, $date)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        })->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndExamAndDateRange($query, $studentId, $examId, $startDate, $endDate)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        })->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterBySubjectAndExamAndDate($query, $subjectId, $examId, $date)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        })->whereDate('created_at', $date);
    }
    public function scopeFilterBySubjectAndExamAndDateRange($query, $subjectId, $examId, $startDate, $endDate)
    {
        return $query->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->whereHas('exams', function ($q) use ($examId) {
            $q->where('id', $examId);
        })->whereBetween('created_at', [$startDate, $endDate]);
    }
    public function scopeFilterByStudentAndSubjectAndDate($query, $studentId, $subjectId, $date)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->whereDate('created_at', $date);
    }
    public function scopeFilterByStudentAndSubjectAndDateRange($query, $studentId, $subjectId, $startDate, $endDate)
    {
        return $query->whereHas('students', function ($q) use ($studentId) {
            $q->where('id', $studentId);
        })->whereHas('subjects', function ($q) use ($subjectId) {
            $q->where('id', $subjectId);
        })->whereBetween('created_at', [$startDate, $endDate]);
    }
    
}
