<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Patient;
use App\Models\Archive;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class ArchiveController extends Controller
{
    public function index()
    {
        $patients = DB::table('patients')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('archive', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'birthdate' => 'required|date|before_or_equal:today',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'job' => 'nullable|string|max:255',
            'tribes' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'reference' => 'nullable|string|max:255',
            'with_suspect' => 'nullable|string|max:255',
            'files' => 'required|array|min:1',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png,xlsx,xls,csv|max:10240'
        ]);

        $patient = Patient::create([
            'user_id' => Auth::id(),
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'weight' => $request->weight ?? 0,
            'height' => $request->height ?? 0,
            'job' => $request->job ?? null,
            'tribes' => $request->tribes ?? null,
            'marital_status' => $request->marital_status ?? null,
            'reference' => $request->reference ?? null,
            'with_suspect' => $request->with_suspect ?? null,
        ]);

        // $uploadedFiles = [];
        // if ($request->hasFile('files')) {
        //     foreach ($request->file('files') as $file) {
        //         $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //         $path = $file->storeAs('archives', $fileName, 'public');
        //         $uploadedFiles[] = $path;

        //         $size = $file->getSize();
        //         $sizeValue = number_format($size / 1024, 2);
        //         $unit = 'KB';

        //         if ($size >= 1048576) {
        //             $sizeValue = number_format($size / 1048576, 2);
        //             $unit = 'MB';
        //         }

        //         Archive::create([
        //             'user_id' => Auth::id(),
        //             'patient_id' => $patient->id,
        //             'file_name' => $file->getClientOriginalName(),
        //             'file' => $path,
        //             'type' => $file->getClientOriginalExtension(),
        //             'size' => $sizeValue,
        //             'unit_size' => $unit,
        //             'uploaded_at' => now(),
        //         ]);
        //     }
        // }
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $folderPath = 'archives/' . $patient->id . '-' . $request->fullname;

                $path = Storage::disk('filebase')->putFileAs(
                    $folderPath,
                    $file,
                    $fileName,
                    'public'
                );

                // Dapatkan URL publik
                // $url = Storage::disk('filebase')->url($path);

                $size = $file->getSize();
                $sizeValue = number_format($size / 1024, 2);
                $unit = 'KB';

                if ($size >= 1048576) {
                    $sizeValue = number_format($size / 1048576, 2);
                    $unit = 'MB';
                }

                Archive::create([
                    'user_id' => Auth::id(),
                    'patient_id' => $patient->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file' => $path, // Simpan path S3
                    // 'url' => $url,   // Simpan URL publik (optional)
                    'type' => $file->getClientOriginalExtension(),
                    'size' => $sizeValue,
                    'unit_size' => $unit,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data pasien dan file berhasil disimpan!');
    }

    public function edit($id)
    {
        $patient = DB::table('patients')->where('id', $id)->first();
        $files = DB::table('archives')->where('patient_id', $id)->get();

        $files = $files->map(function ($file) {
            $file->url = Storage::disk('filebase')->temporaryUrl(
                $file->file,
                now()->addMinutes(5)
            );
            return $file;
        });

        return response()->json([
            'patient' => $patient,
            'files' => $files
        ]);
    }

    public function show($id)
    {
        $patient = DB::table('patients')->where('id', $id)->first();
        $files = DB::table('archives')->where('patient_id', $id)->get();

        $files = $files->map(function ($file) {
            // Gunakan temporaryUrl dengan expiry time
            $file->url = Storage::disk('filebase')->temporaryUrl(
                $file->file,
                now()->addMinutes(5) // URL berlaku 5 menit
            );
            return $file;
        });

        return response()->json([
            'patient' => $patient,
            'files' => $files
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data pasien
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'birthdate' => 'required|date|before_or_equal:today',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'job' => 'nullable|string|max:255',
            'tribes' => 'nullable|string|max:255',
            'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            'reference' => 'nullable|string|max:255',
            'with_suspect' => 'nullable|string|max:255',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png,xlsx,xls,csv|max:10240'
        ]);

        // Update data pasien
        $patient = Patient::findOrFail($id);
        $patient->update([
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'birthdate' => $request->birthdate,
            'weight' => $request->weight ?? 0,
            'height' => $request->height ?? 0,
            'job' => $request->job ?? null,
            'tribes' => $request->tribes ?? null,
            'marital_status' => $request->marital_status ?? null,
            'reference' => $request->reference ?? null,
            'with_suspect' => $request->with_suspect ?? null,
        ]);

        // Handle file uploads baru
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Folder path menggunakan ID pasien
                $folderPath = 'archives/' . $patient->id . '-' . $patient->fullname;

                $path = Storage::disk('filebase')->putFileAs(
                    $folderPath,
                    $file,
                    $fileName,
                    'public' 
                );

                $size = $file->getSize();
                $sizeValue = number_format($size / 1024, 2);
                $unit = 'KB';

                if ($size >= 1048576) {
                    $sizeValue = number_format($size / 1048576, 2);
                    $unit = 'MB';
                }

                Archive::create([
                    'user_id' => Auth::id(),
                    'patient_id' => $patient->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file' => $path,
                    'type' => $file->getClientOriginalExtension(),
                    'size' => $sizeValue,
                    'unit_size' => $unit,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $file = Archive::where('patient_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (Storage::disk('public')->exists($file->file)) {
            Storage::disk('public')->delete($file->file);
        }

        $patient = Patient::where('id', $id)->firstOrFail();

        $file->delete();
        $patient->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }

    public function removeFile($id)
    {
        try {
            $file = Archive::findOrFail($id);

            // Hapus dari Filebase
            Storage::disk('filebase')->delete($file->file);

            // Hapus dari database
            $file->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete file: ' . $e->getMessage()
            ], 500);
        }
    }
}
