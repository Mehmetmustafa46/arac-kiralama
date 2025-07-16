<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Kullanıcı profil detayını gösterir
     */
    public function show(User $user)
    {
        // Kullanıcının rezervasyonlarını al
        $reservations = Reservation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.users.show', compact('user', 'reservations'));
    }
    
    /**
     * Kullanıcı düzenleme formunu gösterir
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Kullanıcı bilgilerini günceller
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'is_admin' => ['sometimes', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        $userData = $request->only(['name', 'email', 'phone', 'address']);
        
        // Admin durumunu güncelle
        $userData['is_admin'] = $request->has('is_admin');
        
        // Şifre değişikliği varsa güncelle
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        
        $user->update($userData);
        
        return redirect()->route('admin.users.show', $user)->with('success', 'Kullanıcı bilgileri başarıyla güncellendi.');
    }
} 