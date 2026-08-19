<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TouristSuggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    /**
     * Menampilkan daftar saran wisatawan dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = TouristSuggestion::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->get('per_page', 5);
        if (!in_array($perPage, [5, 25, 50, 100])) {
            $perPage = 5;
        }
        $suggestions = $query->latest()->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('admin.saran._table', compact('suggestions'))->render();
        }

        return view('admin.saran.index', compact('suggestions'));
    }

    /**
     * Menghapus saran wisatawan dari database.
     */
    public function destroy(TouristSuggestion $suggestion)
    {
        $suggestion->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Saran wisatawan berhasil dihapus.']);
        }

        return redirect()->route('admin.saran-wisatawan.index')
            ->with('success', 'Saran wisatawan berhasil dihapus.');
    }
}
