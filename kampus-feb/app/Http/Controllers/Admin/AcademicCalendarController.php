<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use Illuminate\Http\Request;

class AcademicCalendarController extends Controller
{
    public function index()
    {
        $calendars = AcademicCalendar::orderBy('start_date', 'desc')
            ->paginate(20);
        
        return view('admin.academic-calendars.index', compact('calendars'));
    }

    public function create()
    {
        return view('admin.academic-calendars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'event_type' => 'required|in:perkuliahan,ujian,libur,wisuda,registrasi,lainnya',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        AcademicCalendar::create($validated);

        return redirect()->route('admin.academic-calendars.index')
            ->with('success', 'Kalender akademik berhasil ditambahkan');
    }

    public function edit(AcademicCalendar $academicCalendar)
    {
        return view('admin.academic-calendars.edit', compact('academicCalendar'));
    }

    public function update(Request $request, AcademicCalendar $academicCalendar)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
            'event_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'event_type' => 'required|in:perkuliahan,ujian,libur,wisuda,registrasi,lainnya',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $academicCalendar->update($validated);

        return redirect()->route('admin.academic-calendars.index')
            ->with('success', 'Kalender akademik berhasil diupdate');
    }

    public function destroy(AcademicCalendar $academicCalendar)
    {
        $academicCalendar->delete();

        return redirect()->route('admin.academic-calendars.index')
            ->with('success', 'Kalender akademik berhasil dihapus');
    }
}
