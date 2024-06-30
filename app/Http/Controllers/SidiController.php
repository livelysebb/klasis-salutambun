<?php

namespace App\Http\Controllers;

use App\Models\Sidi;
use App\Models\AnggotaJemaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SidiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $sidis = Sidi::with('anggotaJemaat')
            ->when($search, function ($query, $search) {
                return $query->whereHas('anggotaJemaat', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

    return view('sidis.index', compact('sidis', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotaJemaats = AnggotaJemaat::doesntHave('sidi')
        ->with('jemaat')
        ->orderBy('nama', 'asc') // Urutkan berdasarkan nama anggota jemaat (A-Z)
        ->get();

        return view('sidis.create', compact('anggotaJemaats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        DB::beginTransaction(); // Mulai transaksi

        try {
                $validatedData = $request->validate([

                'anggota_jemaat_id' => 'required|exists:anggota_jemaats,id',
                'tanggal_sidi' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) use ($request) {
                        $anggotaJemaat = AnggotaJemaat::find($request->anggota_jemaat_id);
                        if ($anggotaJemaat && $value <= $anggotaJemaat->tanggal_lahir) {
                            $fail('Tanggal sidi harus setelah tanggal lahir anggota jemaat.');
                        }
                    },
                ],
                'tempat_sidi' => 'required|string|max:255',
                'pendeta_sidi' => 'required|string|max:255',
                'bacaan_sidi' => 'required|string|max:255',
                'nomor_surat' => 'nullable|string|max:255',
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
                ]);

                // Simpan foto jika ada
                if ($request->hasFile('foto')) {
                    $fotoPath = $request->file('foto')->store('public/sidis/foto');
                    $validatedData['foto'] = $fotoPath;
                }

                Sidi::create($validatedData);

                DB::commit(); // Commit transaksi jika berhasil
                return redirect()->route('sidis.index')->with('success', 'Data sidi berhasil ditambahkan.');
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaksi jika terjadi error

                // Hapus foto yang sudah terlanjur diupload jika terjadi error
                if (isset($fotoPath)) {
                    Storage::delete($fotoPath);
                }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sidi $sidi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sidi $sidi)
    {
        $anggotaJemaats = AnggotaJemaat::with('jemaat')->get();
        $selectedAnggotaJemaat = AnggotaJemaat::find($sidi->anggota_jemaat_id); // Ambil anggota jemaat berdasarkan ID

        return view('sidis.edit', compact('sidi', 'anggotaJemaats', 'selectedAnggotaJemaat')); // Kirim ke view
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sidi $sidi)
    {

        DB::beginTransaction(); // Mulai transaksi

        try {
            // Validasi semua input, termasuk foto (jika ada)
            $validatedData = $request->validate([
                'tanggal_sidi' => 'required|date|after:anggota_jemaat.tanggal_lahir',
                'tempat_sidi' => 'required|string|max:255',
                'pendeta_sidi' => 'required|string|max:255',
                'bacaan_sidi' => 'required|string|max:255',
                'nomor_surat' => 'nullable|string|max:255',
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
            ]);

            // Hapus foto lama jika ada dan ada foto baru yang diunggah
            if ($request->hasFile('foto')) {
                if ($sidi->foto) {
                    Storage::delete($sidi->foto);
                }
                $fotoPath = $request->file('foto')->store('public/sidis/foto');
                $validatedData['foto'] = $fotoPath;
            }

            $sidi->update($validatedData);

            DB::commit(); // Commit transaksi jika berhasil
            return redirect()->route('sidis.index')->with('success', 'Data sidi berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi error

            // Hapus foto yang sudah terlanjur diupload jika terjadi error
            if (isset($fotoPath)) {
                Storage::delete($fotoPath);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sidi $sidi)
    {
        DB::beginTransaction(); // Mulai transaksi

            try {
                // Hapus foto sebelum menghapus data Sidi
                if ($sidi->foto) {
                    Storage::delete($sidi->foto);
                }

                $sidi->delete();

                DB::commit(); // Commit transaksi jika berhasil
                return redirect()->route('sidis.index')->with('success', 'Data sidi berhasil dihapus.');
            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaksi jika terjadi error
                return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }

    }
}
