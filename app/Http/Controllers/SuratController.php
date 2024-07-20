<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnggotaJemaat;
use App\Models\Jemaat;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
            $jemaatId = $request->query('jemaat_id');

            $jemaats = Jemaat::pluck('nama', 'id'); // Ambil data jemaat untuk dropdown

            $query = Surat::with('jemaat')
                ->when($search, function ($query, $search) {
                    $query->where('perihal', 'like', "%{$search}%");
                })
                ->when($jemaatId, function ($query, $jemaatId) {
                    $query->where('jemaat_id', $jemaatId); // Filter langsung berdasarkan jemaat_id
                });

            $surats = $query->latest()->paginate(10);

            return view('surats.index', compact('surats', 'search', 'jemaats', 'jemaatId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jemaats = Jemaat::pluck('nama', 'id'); // Ambil data jemaat untuk dropdown
         return view('surats.create', compact('jemaats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // 1. Validasi Input
        $validatedData = $request->validate([
            'nomor_surat'     => 'required|string|max:255',
            'tanggal_surat'   => 'required|date',
            'perihal'         => 'required|string|max:255',
            'jenis_surat'     => 'required|in:masuk,keluar',
            'pengirim_tujuan' => 'required|string|max:255',
            'penerima'        => 'nullable|string|max:255', // Nullable untuk surat keluar
            'file_surat'      => 'nullable|file|mimes:pdf,doc,docx', // Validasi file (opsional)
            'jemaat_id'       => 'nullable|exists:jemaats,id', // Nullable jika tidak semua surat terkait jemaat
        ]);

        // 2. Handle Upload File (Jika Ada)
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surats', $fileName, 'public'); // Simpan di folder 'public/surats'
            $validatedData['file_surat'] = $filePath;
        }

        // 3. Simpan Data Surat
        Surat::create($validatedData);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('surats.index')->with('success', 'Surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        $jemaats = Jemaat::pluck('nama', 'id');

        return view('surats.edit', compact('surat', 'jemaats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'nomor_surat'     => 'required|string|max:255',
            'tanggal_surat'   => 'required|date',
            'perihal'         => 'required|string|max:255',
            'jenis_surat'     => 'required|in:masuk,keluar',
            'pengirim_tujuan' => 'required|string|max:255',
            'penerima'        => 'nullable|string|max:255', // Nullable untuk surat keluar
            'file_surat'      => 'nullable|file|mimes:pdf,doc,docx', // Validasi file (opsional)
            'jemaat_id'       => 'nullable|exists:jemaats,id',
        ]);

        // 2. Handle Upload File (Jika Ada)
        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            if ($surat->file_surat) {
                Storage::disk('public')->delete($surat->file_surat);
            }

            $file = $request->file('file_surat');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surats', $fileName, 'public');
            $validatedData['file_surat'] = $filePath;
        }

        // 3. Update Data Surat
        $surat->update($validatedData);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('surats.index')->with('success', 'Surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
                // Hapus file surat jika ada
            if ($surat->file_surat) {
                Storage::disk('public')->delete($surat->file_surat);
            }

            $surat->delete();

            return redirect()->route('surats.index')->with('success', 'Surat berhasil dihapus.');
    }
}
