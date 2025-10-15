<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpdbRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = PpdbRegistration::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by name, email, or registration number
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(15);

        return view('admin.ppdb-registrations.index', compact('registrations'));
    }

    public function show(PpdbRegistration $ppdbRegistration)
    {
        return view('admin.ppdb-registrations.show', compact('ppdbRegistration'));
    }

    public function verify(PpdbRegistration $ppdbRegistration)
    {
        $ppdbRegistration->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Registration verified successfully.');
    }

    public function reject(Request $request, PpdbRegistration $ppdbRegistration)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $ppdbRegistration->update([
            'status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Registration rejected.');
    }

    public function updateNotes(Request $request, PpdbRegistration $ppdbRegistration)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $ppdbRegistration->update([
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Notes updated successfully.');
    }

    public function downloadDocument(PpdbRegistration $ppdbRegistration, $documentKey)
    {
        $documents = is_string($ppdbRegistration->documents) 
            ? json_decode($ppdbRegistration->documents, true) 
            : $ppdbRegistration->documents;

        if (!isset($documents[$documentKey])) {
            abort(404, 'Document not found');
        }

        $document = $documents[$documentKey];
        $path = $document['path'];

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($path, $document['name']);
    }

    public function destroy(PpdbRegistration $ppdbRegistration)
    {
        // Delete associated documents
        $documents = is_string($ppdbRegistration->documents) 
            ? json_decode($ppdbRegistration->documents, true) 
            : $ppdbRegistration->documents;

        if (is_array($documents)) {
            foreach ($documents as $document) {
                if (isset($document['path']) && Storage::disk('public')->exists($document['path'])) {
                    Storage::disk('public')->delete($document['path']);
                }
            }
        }

        $ppdbRegistration->delete();

        return redirect()->route('admin.ppdb-registrations.index')
            ->with('success', 'Registration deleted successfully.');
    }
}
