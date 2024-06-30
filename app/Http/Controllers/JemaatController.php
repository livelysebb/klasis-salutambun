<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // Import DB untuk handling transaksi
use Exception; // Import Exception untuk penanganan error
use App\Models\Jemaat;
use Illuminate\Http\Request;

class JemaatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $jemaats = Jemaat::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%");
        })->paginate(10);

        return view('jemaats.index', compact('jemaats', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jemaats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Jemaat::create($validatedData);

        return redirect()->route('jemaats.index')->with('success', 'Jemaat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jemaat $jemaat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jemaat $jemaat)
    {
        return view('jemaats.edit', compact('jemaat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jemaat $jemaat)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

       $validatedData = $request->except('_token','_method'); // Hapus _token

        $jemaat->update($validatedData);

        return redirect()->route('jemaats.index')->with('success', 'Data jemaat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jemaat $jemaat)
    {
        $jemaat->delete();
        return redirect()->route('jemaats.index')->with('success', 'Jemaat berhasil dihapus.');
    }
}
