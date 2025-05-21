<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //

    public function getByBlock($blockId)
    {
        $students =  Student::where('block_id', $blockId)->with(['level', 'course', 'block'])->get(); //Block::where('id',$blockId)->with('students')->get();
        return response()->json($students);
    }

    public function addStudent(Request $request)
    {
        try {

            $student = Student::create([
                'fName' => $request->fName,
                'lName' => $request->lName,
                'nName' => $request->mName,
                'age' => $request->age,
                'level_id' => $request->level_id,
                'block_id' => $request->block_id,
                'course_id' => $request->course_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birthdate' => $request->birthdate,
                'image' => $request->file('image') ? $request->file('image')->store('profiles', 'public') : null
            ]);

            return response()->json($student);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getStudentByLevel($level)
    {
        $students = Student::where('level_id', $level)->with(['level', 'course', 'block'])->get();
        return response()->json($students);
    }

    public function update(Request $request)
    {
        try {

            $student = Student::find($request->student_id);

            $student->fName = $request->fName;
            $student->lName = $request->lName;
            $student->nName = $request->mName;
            $student->age = $request->age;
            $student->email = $request->email;
            $student->phone = $request->phone;
            // $student->birthdate = $request->birthdate;

            if($request->image){
                $request->file('image') ? $request->file('image')->store('profiles', 'public') : null;
                $student->image = $request->image;
            }
            

            $student->save();
            return response()->json($student);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // return response()->json(['message' => "test api"],200);
    }
}
