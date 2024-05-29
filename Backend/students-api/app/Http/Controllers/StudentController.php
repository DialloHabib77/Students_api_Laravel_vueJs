<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = Student::all();
            return response()->json([
                'status' => 200,
                'message' => 'List des students',
                'students' => $students
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'=>$e->getcode(),
                'message' => "Une erreur s'est produite lors de la récupération des étudiants",
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function getStudent($id){
        $students = Student::find($id);
        return response()->json($students);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'date' => 'required|date',
                'email' => 'required|email|unique:students,email',
                'address' => 'required|string|max:255',
                'contact_no' => 'required|string|max:15',
            ]);

            $student = Student::create($validatedData);
            return response()->json([
                'status' => 200,
                'message' => "L'étudiant a été créé avec succès",
                'student' => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'=>$e->getcode(),
                'message' => "Une erreur s'est produite lors de la création de l'étudiant",
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function show(Student $student)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Student details',
            'student' => $student
        ]);
    }

    public function update(Request $request, Student $student)
    {
        try {
            $validatedData = $request->validate([
                'last_name' => 'sometimes|required|string|max:255',
                'first_name' => 'sometimes|required|string|max:255',
                'date' => 'sometimes|required|date',
                'email' => 'sometimes|required|email|unique:students,email,' . $student->id,
                'address' => 'sometimes|required|string|max:255',
                'contact_no' => 'sometimes|required|string|max:15',
            ]);

            $student->update($validatedData);
            return response()->json([
                'status' => 200,
                'message' => "Mise à jour réussie de l'étudiant",
                'student' => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Une erreur s'est produite lors de la mise à jour de l'étudiant",
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "L'étudiant a été supprimé avec succès"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Une erreur s'est produite lors de la suppression de l'élève",
                'error' => $e->getMessage(),
            ]);
        }
    }
}
