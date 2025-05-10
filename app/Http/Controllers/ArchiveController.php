<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archive;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf,csv,xlsx,xls|max:2048'
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('public/uploads');

                Archive::create([
                    'user_id' => auth()->id(),
                    'file' => Storage::url($path),
                    'uploaded_at' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Files uploaded successfully!');
    }
}
