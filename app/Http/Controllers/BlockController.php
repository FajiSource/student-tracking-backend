<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    //
     public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $block = Block::create($validated);

        return response()->json([
            'message' => 'Block created successfully',
            'block' => $block
        ], 201);
    }

    public function getByLevelAndCourse($levelId, $courseId)
    {
        $blocks = Block::where('level_id', $levelId)
            ->where('course_id', $courseId)
            ->with(['level', 'course'])
            ->get();

        return response()->json($blocks);
    }
}
