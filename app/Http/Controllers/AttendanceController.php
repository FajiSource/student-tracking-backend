<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $subjectId = $request->subject_id;
        $date = $request->date;

        $attendance = Attendance::filterBySubjectAndDate($subjectId, $date)->get();
        $subject = Subject::all();

        foreach($subject as $sub) {
            if($sub->id == $subjectId) {
                $subject = $sub;
                break;
            }
        }
        
        if ($attendance->isEmpty()) {
           
            $students = Student::all();

            foreach ($students as $student) {
                if($student->level_id != $subject->level_id && $student->course_id != $subject->course_id) {
                    continue;
                }
                Attendance::create(
                    [
                        'student_id' => $student->id,
                        'subject_id' => $subjectId,
                        'created_at' => $date,
                    ],
                    [
                        'present' => null
                    ]
                );
            }

            $attendance = Attendance::filterBySubjectAndDate($subjectId, $date)->get();
        }

        return response()->json($attendance);
    }

    public function markAsPresent(Request $request)
    {
        try {
            $attendance = Attendance::find($request->attendance_id);

            if (!$attendance) {
                return response()->json(['error' => 'Attendance record not found'], 404);
            }

            $attendance->present = true;
            $attendance->save();

            return response()->json($attendance);
        } catch (\Exception $e) {
            Log::error('Error marking attendance: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
