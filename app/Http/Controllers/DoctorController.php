<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    //index
    public function index(Request $request)
    {
        $doctors = DB::table('doctors')
            ->when($request->input('name'), function ($query, $doctors_name) {
                return $query->where('doctor_name', 'like', '%' . $doctors_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.doctors.index', compact('doctors'));

    }
    //create
    public function create()
    {
        return view('pages.doctors.create');
    }
    //store
    public function store(Request $request)
    {
        $request->validate([
            'doctor_name' => 'required',
            'doctor_email' => 'required|email',
            'doctor_spesialist' => 'required',
            'doctor_phone' => 'required',
            'doctor_address' => 'required',
            'sip' => 'required',
        ]);

        $doctor = new Doctor();
        $doctor->doctor_name = $request->doctor_name;
        $doctor->doctor_email = $request->doctor_email;
        $doctor->doctor_spesialist = $request->doctor_spesialist;
        $doctor->doctor_phone = $request->doctor_phone;
        $doctor->doctor_address = $request->doctor_address;
        $doctor->sip = $request->sip;
        $doctor->save();

        return redirect()->route('doctors.index')->with('success', 'doctor created successfully.');
    }
    //edit
    public function edit($id)
    {
        $doctor = doctor::find($id);
        return view('pages.doctors.edit', compact('doctor'));
    }
    public function destroy($id)
    {
        $Doctor = Doctor::find($id);
        $Doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
