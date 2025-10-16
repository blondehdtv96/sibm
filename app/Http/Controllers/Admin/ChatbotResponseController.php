<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotResponse;
use Illuminate\Http\Request;

/**
 * Controller untuk admin mengelola balasan chatbot
 */
class ChatbotResponseController extends Controller
{
    /**
     * Tampilkan daftar balasan chatbot
     */
    public function index()
    {
        $responses = ChatbotResponse::orderBy('priority', 'desc')
            ->orderBy('title')
            ->paginate(20);

        return view('admin.chatbot-responses.index', compact('responses'));
    }

    /**
     * Tampilkan form tambah balasan baru
     */
    public function create()
    {
        return view('admin.chatbot-responses.create');
    }

    /**
     * Simpan balasan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trigger_name' => 'required|string|max:255|unique:chatbot_responses,trigger_name',
            'title' => 'required|string|max:255',
            'keywords' => 'required|string',
            'response' => 'required|string',
            'priority' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        // Convert keywords string to array
        $keywords = array_map('trim', explode(',', $validated['keywords']));
        
        ChatbotResponse::create([
            'trigger_name' => $validated['trigger_name'],
            'title' => $validated['title'],
            'keywords' => $keywords,
            'response' => $validated['response'],
            'priority' => $validated['priority'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.chatbot-responses.index')
            ->with('success', 'Balasan chatbot berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit balasan
     */
    public function edit(ChatbotResponse $chatbotResponse)
    {
        return view('admin.chatbot-responses.edit', compact('chatbotResponse'));
    }

    /**
     * Update balasan
     */
    public function update(Request $request, ChatbotResponse $chatbotResponse)
    {
        $validated = $request->validate([
            'trigger_name' => 'required|string|max:255|unique:chatbot_responses,trigger_name,' . $chatbotResponse->id,
            'title' => 'required|string|max:255',
            'keywords' => 'required|string',
            'response' => 'required|string',
            'priority' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        // Convert keywords string to array
        $keywords = array_map('trim', explode(',', $validated['keywords']));
        
        $chatbotResponse->update([
            'trigger_name' => $validated['trigger_name'],
            'title' => $validated['title'],
            'keywords' => $keywords,
            'response' => $validated['response'],
            'priority' => $validated['priority'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.chatbot-responses.index')
            ->with('success', 'Balasan chatbot berhasil diupdate');
    }

    /**
     * Hapus balasan
     */
    public function destroy(ChatbotResponse $chatbotResponse)
    {
        $chatbotResponse->delete();

        return redirect()->route('admin.chatbot-responses.index')
            ->with('success', 'Balasan chatbot berhasil dihapus');
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggleStatus(ChatbotResponse $chatbotResponse)
    {
        $chatbotResponse->update([
            'is_active' => !$chatbotResponse->is_active
        ]);

        $status = $chatbotResponse->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Balasan chatbot berhasil {$status}");
    }
}
