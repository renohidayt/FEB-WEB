<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show student dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $student = $user->student;

        // Redirect if not a student
        if (!$student) {
            return redirect()->route('home')
                ->with('error', 'Anda bukan mahasiswa.');
        }

        return view('student.dashboard', compact('user', 'student'));
    }
}