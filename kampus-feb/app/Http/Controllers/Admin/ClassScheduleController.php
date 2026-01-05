<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassSchedule::with('lecturer');

        // Filter
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }

        if ($request->filled('semester_level')) {
            $query->where('semester_level', $request->semester_level);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        $schedules = $query->orderBy('day')
            ->orderBy('start_time')
            ->paginate(20);

        // Get unique values for filters
        $programStudis = ClassSchedule::select('program_studi')
            ->distinct()
            ->pluck('program_studi');

        return view('admin.class-schedules.index', compact('schedules', 'programStudis'));
    }

    public function create()
    {
        $lecturers = Lecturer::where('is_visible', true)
            ->orderBy('name')
            ->get();

        return view('admin.class-schedules.create', compact('lecturers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
            'program_studi' => 'required|string|max:100',
            'semester_level' => 'required|integer|min:1|max:8',
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'lecturer_id' => 'nullable|exists:lecturers,id',
            'day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'class_name' => 'nullable|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        ClassSchedule::create($validated);

        return redirect()->route('admin.class-schedules.index')
            ->with('success', 'Jadwal perkuliahan berhasil ditambahkan');
    }

    public function edit(ClassSchedule $classSchedule)
    {
        $lecturers = Lecturer::where('is_visible', true)
            ->orderBy('name')
            ->get();

        return view('admin.class-schedules.edit', compact('classSchedule', 'lecturers'));
    }

    public function update(Request $request, ClassSchedule $classSchedule)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
            'program_studi' => 'required|string|max:100',
            'semester_level' => 'required|integer|min:1|max:8',
            'course_code' => 'required|string|max:20',
            'course_name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'lecturer_id' => 'nullable|exists:lecturers,id',
            'day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'class_name' => 'nullable|string|max:10',
            'capacity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $classSchedule->update($validated);

        return redirect()->route('admin.class-schedules.index')
            ->with('success', 'Jadwal perkuliahan berhasil diupdate');
    }

    public function destroy(ClassSchedule $classSchedule)
    {
        $classSchedule->delete();

        return redirect()->route('admin.class-schedules.index')
            ->with('success', 'Jadwal perkuliahan berhasil dihapus');
    }

    // Export to PDF
    public function exportPdf(Request $request)
    {
        $query = ClassSchedule::with('lecturer')->where('is_active', true);

        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }

        if ($request->filled('semester_level')) {
            $query->where('semester_level', $request->semester_level);
        }

        $schedules = $query->orderBy('day')->orderBy('start_time')->get();

        // Group by day
        $groupedSchedules = $schedules->groupBy('day');

        $pdf = \PDF::loadView('admin.class-schedules.pdf', compact('groupedSchedules', 'request'));
        
        return $pdf->download('jadwal-perkuliahan.pdf');
    }
}
