<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Archive;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        $patientData = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required|date',
            'phone' => 'required',
            'address' => 'required',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'job' => 'nullable',
            'ethnicity' => 'nullable',
            'marital_status' => 'nullable',
            'reference' => 'nullable',
            'companion' => 'nullable',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,csv,xlsx,xls|max:10240'
        ]);

        
        // Simpan data pasien
        $patient = Patient::create($patientData);

        // Handle file upload
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads', 'public');
                $size = $this->formatSizeUnits($file->getSize());

                Archive::create([
                    'user_id' => auth()->id(),
                    'patient_id' => $patient->id,
                    'file' => basename($path),
                    'type' => $file->getClientOriginalExtension(),
                    'size' => $size,
                    'uploaded_at' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Patient and files saved successfully!');
    }

    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } else {
            $bytes = $bytes . ' B';
        }
        return $bytes;
    }
}