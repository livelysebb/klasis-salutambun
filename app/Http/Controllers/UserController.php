<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jemaat;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Memastikan hanya super admin yang bisa mengakses
        if (! auth()->user()->hasRole('super_admin')) {
            abort(403, 'Unauthorized');
        }

        $users = User::paginate(10); // Paginasi data user

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $jemaats = Jemaat::pluck('nama', 'id');
        return view('users.create', compact('roles', 'jemaats'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

            'jemaat_id' => Rule::requiredIf($request->role === 'admin_jemaat') . '|exists:jemaats,id', // Wajib jika role adalah admin_jemaat
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        $user->assignRole($request->input('role'));

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $jemaats = Jemaat::pluck('nama', 'id') ; // Ambil data jemaat jika admin_klasis

        return view('users.edit', compact('user', 'roles', 'jemaats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
    // Unique kecuali ID user saat ini
                ],
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|exists:roles,name',
                'jemaat_id' => Rule::requiredIf($request->role === 'admin_jemaat') . '|exists:jemaats,id', // Wajib jika role adalah admin_jemaat
            ]);

            // 2. Update Password (Jika Diisi)
            if ($request->filled('password')) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']); // Hapus field password jika tidak diisi
            }

            // 3. Update Data User
            $user->update($validatedData);

            // 4. Update Role
            $user->syncRoles($request->input('role'));

            // 5. Redirect dengan Pesan Sukses
            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
