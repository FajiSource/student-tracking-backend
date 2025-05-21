<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    //
    public function getExamsBySubject($subjectID)
    {
        $exams = Exam::where('subject_id', $subjectID)->get();
        return response()->json($exams);
    }
    public function getExamsByLevel($level_id)
    {
        try {
            $subjects = Subject::where('level_id', $level_id)->pluck('id');
            $exams = Exam::whereIn('subject_id', $subjects)->with('subject')->get();
            return response()->json($exams);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addExam(Request $request)
    {
        $exam = Exam::create([
            'subject_id' => $request->subject_id,
            'name' => $request->name,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'maxScore' => $request->maxScore,
            'passingScore' => $request->passingScore,
        ]);

        return response()->json($exam);
    }

    public function addStudentScore(Request $request)
    {
        $score = Score::create([
            'student_id' => $request->student_id,
            'exam_id' => $request->exam_id,
            'score' => $request->score,
        ]);
        return response()->json($score);
    }

    public function getScoresByExamAndLevel($examId, $levelId)
    {
        $students = Student::where('level_id', $levelId)->with('level')->get();
        $scores = Score::where('exam_id', $examId)->get()->keyBy('student_id');

        $data = $students->map(function ($student) use ($scores) {
            return [
                'id' => $student->id,
                'fName' => $student->fName,
                'lName' => $student->lName,
                'nName' => $student->mName,
                'image' => $student->image,
                'level' => $student->level,
                'score' => $scores[$student->id]->score ?? null,
            ];
        });

        return response()->json($data);
    }
}
