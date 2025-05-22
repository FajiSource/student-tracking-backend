<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        try {
            $validator = Validator::make($request->all(), [
                'subject_id' => 'required|exists:subjects,id',
                'name' => 'required|string|max:255',
                'startTime' => 'required|date',
                'endTime' => 'required|date|after:startTime',
                'maxScore' => 'required|integer|min:0',
                'passingScore' => 'required|integer',
                'level_id' => 'required|exists:levels,id'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->messages()], 422);
            }
            $students = Student::where('level_id', $request->level_id)->get();

            // $exam = Exam::create([
            //     'subject_id' => $request->subject_id,
            //     'name' => $request->name,
            //     'startTime' => $request->startTime,
            //     'endTime' => $request->endTime,
            //     'maxScore' => $request->maxScore,
            //     'passingScore' => $request->passingScore,
            // ]);
            $exam = new Exam();
            $exam->subject_id = $request->subject_id;
            $exam->name = $request->name;
            $exam->startTime = $request->startTime;
            $exam->endTime = $request->endTime;
            $exam->done = false;
            $exam->maxScore = $request->maxScore;
            $exam->passingScore = $request->passingScore;
            $exam->save();

            foreach ($students as $student) {
                Score::create([
                    'student_id' => $student->id,
                    'exam_id' => $exam->id,
                    'score' => 0
                ]);
            }
            return response()->json([
                'message' => 'Exam added successfully',
                'exam' => $exam,
            ]);
            // return response()->json($exam);
        } catch (\Exception $e) {
            Log::error('Add Exam Error', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to add exam',
                'error' => $e->getMessage(), 
            ], 500);
        }
    }


    public function addStudentScore(Request $request)
    {
        $score = Score::find($request->score_id);
        $score->score = $request->score;
        $score->save();
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

    public function getScoresByExam($examId)
    {
        try {
            $scores = Score::where('exam_id', $examId)
                ->with('student')
                ->get();

            if ($scores->isEmpty()) {
                return response()->json([
                    'message' => 'No scores found for this exam.',
                ], 404);
            }

            return response()->json($scores);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving scores.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
