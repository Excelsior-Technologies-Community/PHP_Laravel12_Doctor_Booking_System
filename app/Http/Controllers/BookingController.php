<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('index', compact('doctors'));
    }

    public function book(Request $request)
    {
        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patient->id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        return redirect()->back()->with('success', 'Appointment Booked!');
    }

    public function appointments()
    {
        $appointments = Appointment::with('doctor', 'patient')->get();
        return view('appointments', compact('appointments'));
    }

    public function doctors()
    {
        $doctors = Doctor::all();
        return view('doctors', compact('doctors'));
    }

    public function patients()
    {
        $patients = Patient::all();
        return view('patients', compact('patients'));
    }

    public function dashboard()
    {
        $doctor_count = Doctor::count();
        $patient_count = Patient::count();
        $appointment_count = Appointment::count();
        return view('dashboard', compact('doctor_count', 'patient_count', 'appointment_count'));
    }

    public function cancel($id)
    {
        Appointment::find($id)->delete();
        return back();
    }
}
