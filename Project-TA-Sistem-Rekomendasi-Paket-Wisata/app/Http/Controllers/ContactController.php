<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TouristSuggestion;

class ContactController extends Controller
{
    /**
     * Menyimpan saran/pesan dari wisatawan ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        TouristSuggestion::create($validated);

        return redirect()->back()->with('success', __('messages.contact_success_msg') ?? 'Pesan Anda berhasil dikirim! Terima kasih atas saran Anda.');
    }
}
