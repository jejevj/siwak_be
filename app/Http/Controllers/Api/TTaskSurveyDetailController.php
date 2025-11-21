<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TTaskSurveyDetail;
use Illuminate\Http\Request;

class TTaskSurveyDetailController extends Controller
{
    public function index()
    {
        return TTaskSurveyDetail::all();
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $data = $request->validate([
    //             'task_id' => 'required|exists:t_task_survey,TaskID',
    //             'id_pertanyaan' => 'required|string',
    //             'group_pertanyaan' => 'required|string',
    //             'tipe_pertanyaan' => 'required|string',
    //             'jawaban' => 'nullable', // allow string OR file
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'TaskID not found in t_task_survey.',
    //             'errors' => $e->errors()
    //         ], 422);
    //     }

    //     // Normalize id_pertanyaan
    //     $data['id_pertanyaan'] = preg_replace('/-\d+$/', '', $data['id_pertanyaan']);

    //     // If jawaban is a file, move it and save filename only
    //     if ($request->hasFile('jawaban')) {
    //         $file = $request->file('jawaban');
    //         $filename = time() . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('uploads/answers'), $filename);

    //         $data['jawaban'] = $filename;  // store filename only
    //     }

    //     $detail = TTaskSurveyDetail::create($data);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Success',
    //         'data' => $detail,
    //     ], 201);
    // }
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'task_id' => 'required|exists:t_task_survey,TaskID',
                'id_pertanyaan' => 'required|string',
                'group_pertanyaan' => 'required|string',
                'tipe_pertanyaan' => 'required|string',
                'jawaban' => 'nullable', // allow string OR file
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        // Normalize id_pertanyaan
        $data['id_pertanyaan'] = preg_replace('/-\d+$/', '', $data['id_pertanyaan']);

        // If jawaban is a file, move it and save filename only
        if ($request->hasFile('jawaban')) {
            $file = $request->file('jawaban');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/answers'), $filename);

            $data['jawaban'] = $filename;  // store filename only
        }

        // 🔄 Check if existing record exists for this task_id + id_pertanyaan
        $existing = TTaskSurveyDetail::where('task_id', $data['task_id'])
            ->where('id_pertanyaan', $data['id_pertanyaan'])
            ->first();

        if ($existing) {
            $existing->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Updated existing record',
                'data' => $existing,
            ], 200);
        } else {
            $detail = TTaskSurveyDetail::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Created new record',
                'data' => $detail,
            ], 201);
        }
    }


    public function show($id)
    {
        return TTaskSurveyDetail::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $detail = TTaskSurveyDetail::findOrFail($id);

        $data = $request->validate([
            'task_id' => 'sometimes|required|exists:t_task_survey,TaskID',
            'id_pertanyaan' => 'sometimes|required|string',
            'group_pertanyaan' => 'sometimes|required|string',
            'tipe_pertanyaan' => 'sometimes|required|string',
            'jawaban' => 'nullable|string',
        ]);

        $detail->update($data);

        return response()->json($detail);
    }

    public function destroy($id)
    {
        $detail = TTaskSurveyDetail::findOrFail($id);
        $detail->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
