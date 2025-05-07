<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'instansi' => 'required|string|max:255',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'instansi' => $request->instansi,
            'role' => $request->role ?? 'user',
        ]);
    
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }    
    
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'instansi' => 'required',
            'role' => 'required|in:admin,user',
        ]);
    
        $user = User::findOrFail($id);
    
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->instansi = $validated['instansi'];
    
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }
    
        if (auth()->user()->role === 'admin') {
            $user->role = $validated['role'];
        }
    
        $user->save();
    
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
