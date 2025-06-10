<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Peminjaman;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query if it exists
        $search = $request->input('search');
        
        // Start with a base query excluding admin users
        $query = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        });
        
        // Apply search filter if search parameter exists
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Get the filtered users
        $users = $query->get();

        return view('admin.UserManagement.index', compact('users'));
    }

    public function create()
    {
        return view('admin.UserManagement.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign 'user' role to the newly created user
        $user->assignRole('user');

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Prevent editing admin users
        if ($user->hasRole('admin')) {
            return redirect()->route('user.index')->with('error', 'Tidak dapat mengedit pengguna dengan role admin.');
        }

        return view('admin.UserManagement.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent updating admin users
        if ($user->hasRole('admin')) {
            return redirect()->route('user.index')->with('error', 'Tidak dapat mengubah pengguna dengan role admin.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin users
        if ($user->hasRole('admin')) {
            return redirect()->route('user.index')->with('error', 'Tidak dapat menghapus pengguna dengan role admin.');
        }

        // Check if user has active loans (peminjaman with status 'approved' that haven't been returned)
        $activePeminjaman = Peminjaman::where('id_user', $id)
            ->where('status', 'approved')
            ->whereNotExists(function ($query) {
                $query->select('id')
                      ->from('pengembalians')
                      ->whereColumn('pengembalians.id_peminjaman', 'peminjamans.id')
                      ->whereIn('pengembalians.status', ['complete', 'damage']);
            })
            ->count();
        
        if ($activePeminjaman > 0) {
            return redirect()->route('user.index')
                ->with('error', 'Pengguna tidak dapat dihapus karena sedang memiliki peminjaman aktif.');
        }

        // Check if user has pending loan requests
        $pendingPeminjaman = Peminjaman::where('id_user', $id)
            ->where('status', 'pending')
            ->count();
            
        if ($pendingPeminjaman > 0) {
            return redirect()->route('user.index')
                ->with('error', 'Pengguna tidak dapat dihapus karena memiliki permintaan peminjaman yang belum diproses.');
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }


}


