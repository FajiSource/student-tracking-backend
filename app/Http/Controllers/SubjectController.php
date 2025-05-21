<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //
    public function index()
    {
        $subjects = Subject::with(['level', 'course', 'block'])->get();
        return response()->json($subjects);
    }

    public function getByLevelAndCourse($levelId, $courseId)
    {
        $subjects = Subject::where('level_id', $levelId)
            ->where('course_id', $courseId)
            ->with(['level', 'course'])
            ->get();


        foreach ($subjects as $subject) {
            $subject->first_schedule = json_decode($subject->first_schedule);
            $subject->second_schedule = json_decode($subject->second_schedule);
        }

        return response()->json($subjects);
    }


    public function addSubject(Request $request)
    {
        try {
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->level_id = $request->level_id;
            $subject->course_id = $request->course_id;
            $subject->first_schedule = json_encode($request->first_schedule);
            $subject->second_schedule = json_encode($request->second_schedule);
            $subject->save();

            return response()->json($subject);
        } catch (Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
