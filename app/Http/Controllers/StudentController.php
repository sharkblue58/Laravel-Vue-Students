<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{

    /**
     * Store a new student record.
     *
     * @param StudentRequest $request
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        try {
            $students = Student::all();

            return response()->json([
                'status' => 200,
                'data' => StudentResource::collection($students),
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 500,
                'msg' => 'Failed to get the students.',
            ], 500);
        }
    }

    public function store(StudentRequest $request): JsonResponse
    {

        try {
            $data = $request->validated();
            $student = Student::create($data);
            return response()->json([
                'status' => 200,
                'msg' => 'Data is Added Successfully',
                'data' => new StudentResource($student)
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'msg' => 'Validation failed',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 500,
                'msg' => 'Failed to store the data',
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function Edit(int $studentId): JsonResponse
    {
        try {
            $student = Student::findOrFail($studentId);
            return response()->json([
                'status' => 200,
                'student' => new StudentResource($student),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'msg' => 'No student ID found.',
            ], 404);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 500,
                'msg' => 'Failed to show the student.',
            ], 500);
        }
    }

    public function update(StudentRequest $request, $studentId): JsonResponse
    {
        try {

            $student = Student::find($studentId);
            if($student!=null){
                $student->update($request->all());
                return response()->json([
                    'status' => 200,
                    'data' => new StudentResource($student),
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'msg'=>'no students with this id'
                ], 404);
            }
            
        } catch (ValidationException $e) {
            // Return a validation error response.
            return response()->json([
                'status' => 422,
                'msg' => 'Validation failed.',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            // Return a record not found response.
            return response()->json([
                'status' => 404,
                'msg' => 'Student record not found.',
            ], 404);
        } catch (Exception $e) {
            // Log the exception.
            Log::error($e->getMessage());

            // Return an error response.
            return response()->json([
                'status' => 500,
                'msg' => 'Failed to update the student.',
                'expcetion' => $e->getMessage()
            ], 500);
        }
    }

    public function show(int $studentId): JsonResponse
    {
        try {
            $student = Student::findOrFail($studentId);
            return response()->json([
                'status' => 200,
                'data' => new StudentResource($student),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 404,
                'msg' => 'Student record not found.',
            ], 404);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 500,
                'msg' => 'Failed to show the student.',
            ], 500);
        }
    }

    public function destroy(int $studentId): JsonResponse
    {
        try {

            $student = Student::find($studentId);
            if($student!=null){
                $student->delete();
                return response()->json([
                    'status' => 200,
                    'msg' =>'the record deleted successfuly' ,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'msg'=>'no students with this id'
                ], 404);
            }
            
        } catch (ValidationException $e) {
            // Return a validation error response.
            return response()->json([
                'status' => 422,
                'msg' => 'Validation failed.',
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            // Return a record not found response.
            return response()->json([
                'status' => 404,
                'msg' => 'Student record not found.',
            ], 404);
        } catch (Exception $e) {
            // Log the exception.
            Log::error($e->getMessage());

            // Return an error response.
            return response()->json([
                'status' => 500,
                'msg' => 'Failed to update the student.',
                'expcetion' => $e->getMessage()
            ], 500);
        }
    }
}
