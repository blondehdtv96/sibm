<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

/**
 * Controller untuk admin mengelola riwayat chat
 */
class ChatHistoryController extends Controller
{
    /**
     * Tampilkan halaman riwayat chat
     */
    public function index(Request $request)
    {
        $query = Chat::query()->orderBy('created_at', 'desc');

        // Filter berdasarkan tanggal jika ada
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter berdasarkan session jika ada
        if ($request->has('session') && $request->session) {
            $query->where('session_id', $request->session);
        }

        // Search berdasarkan pesan
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_message', 'like', "%{$search}%")
                  ->orWhere('bot_reply', 'like', "%{$search}%");
            });
        }

        $chats = $query->paginate(20);

        // Statistik
        $stats = [
            'total' => Chat::count(),
            'today' => Chat::whereDate('created_at', today())->count(),
            'this_week' => Chat::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Chat::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.chat-history.index', compact('chats', 'stats'));
    }

    /**
     * Hapus riwayat chat tertentu
     */
    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();

        return redirect()->back()->with('success', 'Riwayat chat berhasil dihapus');
    }

    /**
     * Hapus semua riwayat chat
     */
    public function destroyAll()
    {
        Chat::truncate();

        return redirect()->back()->with('success', 'Semua riwayat chat berhasil dihapus');
    }

    /**
     * Hapus riwayat chat berdasarkan tanggal
     */
    public function destroyByDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        Chat::whereDate('created_at', $request->date)->delete();

        return redirect()->back()->with('success', 'Riwayat chat pada tanggal ' . $request->date . ' berhasil dihapus');
    }

    /**
     * Export riwayat chat ke CSV
     */
    public function export()
    {
        $chats = Chat::orderBy('created_at', 'desc')->get();

        $filename = 'chat-history-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($chats) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, ['ID', 'Session ID', 'User Message', 'Bot Reply', 'IP Address', 'Created At']);
            
            // Data
            foreach ($chats as $chat) {
                fputcsv($file, [
                    $chat->id,
                    $chat->session_id,
                    $chat->user_message,
                    $chat->bot_reply,
                    $chat->ip_address,
                    $chat->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
