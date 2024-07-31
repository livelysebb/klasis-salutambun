<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Jemaat;
use App\Models\AnggotaJemaat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengurusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $jemaatId = $request->query('jemaat_id');

        $jemaats = Jemaat::pluck('nama', 'id');

        $query = Pengurus::with('anggotaJemaat.jemaat')
            ->when($search, function ($query, $search) {
                $query->whereHas('anggotaJemaat', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->when($jemaatId, function ($query, $jemaatId) {
                $query->where('jemaat_id', $jemaatId);
            });

        $pengurus = $query->latest()->paginate(10);

        return view('penguruses.index', compact('pengurus', 'search', 'jemaats', 'jemaatId'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotaJemaats = AnggotaJemaat::whereDoesntHave('pengurus')->get(); // Hanya anggota jemaat yang belum menjadi pengurus
        return view('penguruses.create', compact('anggotaJemaats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'anggota_jemaat_id' => 'required|exists:anggota_jemaats,id|unique:penguruses,anggota_jemaat_id',
            'jabatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // 2. Simpan Data Pengurus
        try {
            $validatedData['tanggal_mulai'] = Carbon::parse($validatedData['tanggal_mulai']);
            if ($validatedData['tanggal_selesai']) {
                $validatedData['tanggal_selesai'] = Carbon::parse($validatedData['tanggal_selesai']);
            }
            Pengurus::create($validatedData);

            return redirect()->route('penguruses.index')->with('success', 'Pengurus berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengurus $pengurus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengurus $pengurus)
    {
        $anggotaJemaats = AnggotaJemaat::whereDoesntHave('pengurus', function($query) use ($pengurus){
            $query->where('id', '!=', $pengurus->id);
        })->get();
        return view('penguruses.edit', compact('pengurus', 'anggotaJemaats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengurus $pengurus)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            // Tidak perlu validasi anggota_jemaat_id karena tidak bisa diubah
            'jabatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        // 2. Konversi Tanggal
        $validatedData['tanggal_mulai'] = Carbon::parse($validatedData['tanggal_mulai']);
        if ($validatedData['tanggal_selesai']) {
            $validatedData['tanggal_selesai'] = Carbon::parse($validatedData['tanggal_selesai']);
        }

        // 3. Update Data Pengurus
        try {
            $pengurus->update($validatedData);

            return redirect()->route('penguruses.index')->with('success', 'Pengurus berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengurus $pengurus)
    {
        try {
            $pengurus->delete();

            return redirect()->route('penguruses.index')->with('success', 'Pengurus berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
