<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
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

        if ($attendance->isEmpty()) {
            $subject = Subject::find($subjectId);

            $students = Student::where('level_id', $subject->level_id)
                ->where('course_id', $subject->course_id)
                ->get();

            foreach ($students as $student) {
                $alreadyExists = Attendance::where('student_id', $student->id)
                    ->where('subject_id', $subjectId)
                    ->where('date', $date)
                    ->exists();
                if (!$alreadyExists) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $subjectId,
                        'date' => $date,
                        'present' => null
                    ]);
                }
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
