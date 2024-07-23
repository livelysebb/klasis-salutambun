<?php

namespace App\Http\Controllers;

use App\Models\Nikah;
use App\Models\AnggotaJemaat;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class NikahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nikahs = Nikah::with(['anggotaJemaat', 'pasangan']); // Eager load relasi

        if ($request->has('search')) {
            $nikahs->whereHas('anggotaJemaat', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->input('search') . '%');
            })->orWhereHas('pasangan', function ($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->input('search') . '%');
            });
        }

        $nikahs = $nikahs->paginate(10); // Pagination

        return view('nikahs.index', compact('nikahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil ID anggota jemaat yang sudah menikah (dari tabel nikahs)
        $sudahMenikahIds = Nikah::pluck('anggota_jemaat_id')->toArray();

        // Ambil semua anggota jemaat yang belum menikah
        $anggotaJemaat = AnggotaJemaat::whereNotIn('id', $sudahMenikahIds)
            ->orderBy('nama', 'asc')
            ->get();

        return view('nikahs.create', compact('anggotaJemaat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {// 1. Validasi Input
            $validatedData = $request->validate([
                'anggota_jemaat_id' => ['required', 'exists:anggota_jemaats,id', function ($attribute, $value, $fail) {
                    if (Nikah::where('anggota_jemaat_id', $value)->exists()) {
                        $fail('Anggota jemaat sudah menikah.');
                    }
                }],
                'pasangan_id' => ['required', 'exists:anggota_jemaats,id', 'different:anggota_jemaat_id', function ($attribute, $value, $fail) {
                    if (Nikah::where('anggota_jemaat_id', $value)->exists()) {
                        $fail('Pasangan sudah menikah.');
                    }
                }],
                'tanggal_nikah' => 'required|date',
                'tempat_nikah' => 'required|string',
                'pendeta_nikah' => 'required|string',
                'catatan_nikah' => 'nullable|string',
                'foto_nikah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
                'dokumen_nikah' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Validasi dokumen
            ]);



            // 3. Simpan Data Pernikahan
            try {
                    // 2. Handle Upload File (Foto dan Dokumen)
                if ($request->hasFile('foto_nikah')) {
                    $validatedData['foto_nikah'] = $request->file('foto_nikah')->store('nikahs', 'public');
                }
                if ($request->hasFile('dokumen_nikah')) {
                    $validatedData['dokumen_nikah'] = $request->file('dokumen_nikah')->store('nikahs', 'public');
                }
                Nikah::create($validatedData);
                return redirect()->route('nikahs.index')->with('success', 'Data pernikahan berhasil ditambahkan!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Nikah $nikah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nikah $nikah)
    {
        $anggotaJemaat = AnggotaJemaat::all();
        return view('nikahs.edit', compact('nikah', 'anggotaJemaat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nikah $nikah)
    {

        // Validasi

                $validatedData = $request->validate([
                    'tanggal_nikah' => 'required|date',
                    'tempat_nikah' => 'required|string',
                    'pendeta_nikah' => 'required|string',
                    'catatan_nikah' => 'nullable|string',
                ], [
                    'pasangan_id.different' => 'Anggota jemaat dan pasangan tidak boleh sama.',
                ]);

                if ($request->hasFile('foto_nikah')) {
                    if ($nikah->foto_nikah) {
                        Storage::disk('public')->delete($nikah->foto_nikah);
                    }
                    $validatedData['foto_nikah'] = $request->file('foto_nikah')->store('nikahs', 'public');
                }

                if ($request->hasFile('dokumen_nikah')) {
                    if ($nikah->dokumen_nikah) {
                        Storage::disk('public')->delete($nikah->dokumen_nikah);
                    }
                    $validatedData['dokumen_nikah'] = $request->file('dokumen_nikah')->store('nikahs', 'public');
                }

                $nikah->update($validatedData);
                return redirect()->route('nikahs.index')->with('success', 'Data pernikahan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nikah $nikah)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            $nikah->delete();
            DB::commit(); // Commit transaksi jika berhasil
            return redirect()->route('nikahs.index')->with('success', 'Data pernikahan berhasil dihapus!');
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
