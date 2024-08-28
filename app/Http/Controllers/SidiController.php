<?php

namespace App\Http\Controllers;

use App\Models\Sidi;
use App\Models\Jemaat;
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
        // 1. Otorisasi
        if (! auth()->user()->can('view sidis')) {
            abort(403, 'Unauthorized');
        }

        // 2. Ambil Data Jemaat untuk Dropdown (Hanya untuk admin_klasis dan super_admin)
        $jemaats = [];
        if (auth()->user()->hasRole('admin_klasis') || auth()->user()->hasRole('super_admin')) {
            $jemaats = Jemaat::pluck('nama', 'id');
        }

        // 3. Ambil nilai 'search' dan 'jemaat_id' dari query parameter
        $search = $request->query('search');
        $jemaatId = $request->query('jemaat_id');

        // 4. Query Data Sidi dengan Filter, Relasi, dan Pencarian
        $query = Sidi::with('anggotaJemaat.jemaat')
            ->when($search, function ($query, $search) {
                $query->whereHas('anggotaJemaat', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->when(auth()->user()->hasRole('admin_jemaat'), function ($query) {
                $query->whereHas('anggotaJemaat', function ($q) {
                    $q->where('jemaat_id', auth()->user()->jemaat_id);
                });
            })
            ->when(($jemaatId && (auth()->user()->hasRole('admin_klasis') || auth()->user()->hasRole('super_admin'))), function ($query) use ($jemaatId) {
                $query->whereHas('anggotaJemaat', function ($q) use ($jemaatId) {
                    $q->where('jemaat_id', $jemaatId);
                });
            })
            ->latest();

        // 5. Paginasi
        $sidis = $query->paginate(10);

        // 6. Kembalikan View
        return view('sidis.index', compact('sidis', 'search', 'jemaats', 'jemaatId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cek apakah pengguna memiliki izin untuk membuat sidi
        if (!auth()->user()->can('create sidis')) {
            abort(403, 'Unauthorized'); // Jika tidak memiliki izin, tampilkan error 403
        }

        if (auth()->user()->hasRole('admin_jemaat')) {
            // Jika admin jemaat, ambil hanya anggota jemaat dari jemaatnya sendiri yang belum memiliki data sidi
            $anggotaJemaats = AnggotaJemaat::where('jemaat_id', auth()->user()->jemaat_id)
                ->doesntHave('sidi')
                ->with('jemaat')
                ->orderBy('nama', 'asc')
                ->get();
        } else {
            // Jika bukan admin jemaat (misalnya super admin), ambil semua anggota jemaat yang belum memiliki data sidi
            $anggotaJemaats = AnggotaJemaat::doesntHave('sidi')
                ->with('jemaat')
                ->orderBy('nama', 'asc')
                ->get();
        }

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
                'dokumen_sidi' => 'nullable|file|mimes:pdf,doc,docx|max:2048', //validasi dokumen
                ]);

                // Simpan foto jika ada
                if ($request->hasFile('foto')) {
                    $fotoPath = $request->file('foto')->store('public/sidis/foto');
                    $validatedData['foto'] = $fotoPath;
                }
                if ($request->hasFile('dokumen_sidi')) {
                    $dokumenPath = $request->file('dokumen_sidi')->store('public/sidis/dokumen');
                    $validatedData['dokumen_sidi'] = $dokumenPath;
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

            DB::beginTransaction();

        try {
            // Validasi semua input, termasuk foto dan dokumen sidi
            $validatedData = $request->validate([
                'tanggal_sidi' => 'required|date|after:anggota_jemaat.tanggal_lahir',
                'tempat_sidi' => 'required|string|max:255',
                'pendeta_sidi' => 'required|string|max:255',
                'bacaan_sidi' => 'required|string|max:255',
                'nomor_surat' => 'nullable|string|max:255',
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'dokumen_sidi' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);

            // Hapus dokumen lama jika ada dan pengguna mengunggah dokumen baru
            if ($request->hasFile('dokumen_sidi')) {
                if ($sidi->dokumen_sidi) {
                    Storage::delete($sidi->dokumen_sidi);
                }
                $dokumenPath = $request->file('dokumen_sidi')->store('public/sidis/dokumen');
                $validatedData['dokumen_sidi'] = $dokumenPath;
            }

            // Hapus foto lama jika ada dan ada foto baru yang diunggah
            if ($request->hasFile('foto')) {
                if ($sidi->foto) {
                    Storage::delete($sidi->foto);
                }
                $fotoPath = $request->file('foto')->store('public/sidis/foto');
                $validatedData['foto'] = $fotoPath;
            }

            $sidi->update($validatedData);

            DB::commit();
            return redirect()->route('sidis.index')->with('success', 'Data sidi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sudah terlanjur diupload jika terjadi error
            if (isset($fotoPath)) {
                Storage::delete($fotoPath);
            }
            if (isset($dokumenPath)) { // Tambahkan penanganan untuk dokumen
                Storage::delete($dokumenPath);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sidi $sidi)
    {
            DB::beginTransaction();

        try {
            // Hapus dokumen sidi sebelum menghapus data Sidi
            if ($sidi->dokumen_sidi) {
                Storage::disk('public')->delete($sidi->dokumen_sidi);
            }

            // Hapus foto sebelum menghapus data Sidi (jika ada)
            if ($sidi->foto) {
                Storage::disk('public')->delete($sidi->foto);
            }

            $sidi->delete(); // Hapus data Sidi

            DB::commit();
            return redirect()->route('sidis.index')->with('success', 'Data sidi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }

    }
}
