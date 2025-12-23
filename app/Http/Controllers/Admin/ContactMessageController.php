<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.contact-messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $contactMessage)
    {
        // Mark as read when viewed
        if ($contactMessage->status === 'unread') {
            $contactMessage->markAsRead();
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();
        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function markAsReplied(ContactMessage $contactMessage)
    {
        $contactMessage->markAsReplied();
        return back()->with('success', 'Pesan ditandai sudah dibalas.');
    }

    public function updateNotes(Request $request, ContactMessage $contactMessage)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $contactMessage->update([
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Catatan berhasil disimpan.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contact_messages,id',
        ]);

        ContactMessage::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' pesan berhasil dihapus.');
    }

    public function getUnreadCount()
    {
        return response()->json([
            'count' => ContactMessage::unread()->count()
        ]);
    }
}
