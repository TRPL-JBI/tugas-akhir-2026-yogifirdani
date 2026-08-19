<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna (role: user) dengan fitur pencarian dan pagination AJAX.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // Logika pencarian berdasarkan nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ambil data terbaru dengan pagination dinamis (default 5 item per halaman)
        $perPage = (int) $request->get('per_page', 5);
        if (!in_array($perPage, [5, 25, 50, 100])) {
            $perPage = 5;
        }
        $users = $query->latest()->paginate($perPage)->withQueryString();
        
        // Handle request AJAX untuk pencarian tanpa reload
        if ($request->ajax()) {
            return view('admin.user_profile._table', compact('users'))->render();
        }

        return view('admin.user_profile.index', compact('users'));
    }

    /**
     * Menampilkan detail profil pengguna.
     */
    public function show(User $user)
    {
        // Pastikan admin tidak bisa diakses melalui route ini
        abort_if($user->role === 'admin', 403);

        return view('admin.user_profile.show', compact('user'));
    }

    /**
     * Menampilkan form edit profil pengguna.
     */
    public function edit(User $user)
    {
        abort_if($user->role === 'admin', 403);

        return view('admin.user_profile.edit', compact('user'));
    }

    /**
     * Memperbarui data profil pengguna.
     */
    public function update(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('admin.user-profile.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus data pengguna dari database.
     */
    public function destroy(User $user)
    {
        abort_if($user->role === 'admin', 403);

        $user->delete();

        return redirect()->route('admin.user-profile.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
