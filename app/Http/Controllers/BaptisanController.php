<?php

namespace App\Http\Controllers;

use App\Models\Baptisan;
use App\Models\AnggotaJemaat;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;


class BaptisanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Otorisasi
        if (! auth()->user()->can('view baptisans')) {
            abort(403, 'Unauthorized');
        }

        // 2. Ambil Data Jemaat untuk Dropdown
        $search = $request->query('search');
        $jemaats = Jemaat::pluck('nama', 'id');
        $jemaatId = $request->query('jemaat_id');

        // 3. Query Data Baptisan dengan Filter dan Relasi
        $query = Baptisan::with('anggotaJemaat.jemaat')
            ->when($request->query('search'), function ($query, $search) {
                return $query->where('tempat_baptis', 'like', "%{$search}%")
                    ->orWhereHas('anggotaJemaat', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->when(auth()->user()->hasRole('admin_jemaat'), function ($query) {
                $query->whereHas('anggotaJemaat', function ($q) {
                    $q->where('jemaat_id', auth()->user()->jemaat_id);
                });
            })
            ->when(auth()->user()->hasRole('admin_klasis') && $request->query('jemaat_id'), function ($query) use ($request) {
                $query->whereHas('anggotaJemaat', function ($q) use ($request) {
                    $q->where('jemaat_id', $request->query('jemaat_id'));
                });
            })
            ->when((auth()->user()->hasRole('admin_klasis') || auth()->user()->hasRole('super_admin')) && $request->query('jemaat_id'), function ($query) use ($request) {
                $query->whereHas('anggotaJemaat', function ($q) use ($request) {
                    $q->where('jemaat_id', $request->query('jemaat_id'));
                });
            })
            ->latest();

        // 4. Paginasi
        $baptisans = $query->paginate(10);

        // 5. Hitung Umur Saat Baptis dan Tambahkan Nomor Urut
        $baptisans->getCollection()->transform(function ($baptisan, $key) use ($baptisans) {
            $tanggalBaptis = Carbon::parse($baptisan->tanggal_baptis);
            $tanggalLahir = Carbon::parse($baptisan->anggotaJemaat->tanggal_lahir);

            if ($tanggalBaptis->greaterThanOrEqualTo($tanggalLahir)) {
                $umur = $tanggalLahir->diff($tanggalBaptis);
                $baptisan->umur_saat_baptis = $umur->y . ' tahun ' ;
            } else {
                $baptisan->umur_saat_baptis = 'Tanggal Baptis Tidak Valid';
            }

            $baptisan->nomor = ($baptisans->currentPage() - 1) * $baptisans->perPage() + $key + 1;
            return $baptisan;
        });

        // 6. Kembalikan View
        return view('baptisans.index', compact('baptisans', 'search', 'jemaats', 'jemaatId'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! auth()->user()->can('create baptisans')) {
            abort(403, 'Unauthorized');
        }

        if (auth()->user()->hasRole('admin_jemaat')) {
            // Jika admin jemaat, ambil hanya anggota jemaat dari jemaatnya sendiri yang belum memiliki data baptisan
            $anggotaJemaats = AnggotaJemaat::where('jemaat_id', auth()->user()->jemaat_id)
                ->doesntHave('baptisan')
                ->with('jemaat')
                ->orderBy('nama', 'asc')
                ->get();
        } else {
            // Jika bukan admin jemaat (super admin), ambil semua anggota jemaat yang belum memiliki data baptisan
            $anggotaJemaats = AnggotaJemaat::doesntHave('baptisan')
                ->with('jemaat')
                ->orderBy('nama', 'asc')
                ->get();
        }

        return view('baptisans.create', compact('anggotaJemaats'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'anggota_jemaat_id' => 'required|exists:anggota_jemaats,id',
            'tanggal_baptis' => 'required|date',
            'tempat_baptis' => 'required|string|max:255',
            'pendeta_baptis' => 'required|string|max:255',
            'daftar_saksi' => 'nullable|string',
            'dokumen_baptisan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('dokumen_baptisan')) {
                $dokumenPath = $request->file('dokumen_baptisan')->store('public/baptisans/dokumen');
                $validatedData['dokumen_baptisan'] = $dokumenPath;
            }

            $anggotaJemaat = AnggotaJemaat::findOrFail($validatedData['anggota_jemaat_id']);

            if ($anggotaJemaat->baptisan()->exists()) {
                return back()->with('error', 'Anggota jemaat ini sudah memiliki data baptisan.');
            }

            $tanggalBaptis = Carbon::parse($validatedData['tanggal_baptis']);
            $tanggalLahir = Carbon::parse($anggotaJemaat->tanggal_lahir);

            if ($tanggalBaptis->greaterThanOrEqualTo($tanggalLahir)) {
                $umur = $tanggalLahir->diff($tanggalBaptis);
                $validatedData['umur_saat_baptis'] = $umur->y . ' tahun ' . $umur->m . ' bulan';
            } else {
                $validatedData['umur_saat_baptis'] = 'Tanggal Baptis Tidak Valid';
            }

            $baptisan = new Baptisan($validatedData);
            $anggotaJemaat->baptisan()->save($baptisan);

            DB::commit();

            return redirect()->route('baptisans.index')->with('success', 'Data baptisan berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Baptisan $baptisan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Baptisan $baptisan)
    {
        // Ambil anggota jemaat yang terkait dengan baptisan
        $selectedAnggotaJemaat = AnggotaJemaat::find($baptisan->anggota_jemaat_id);

        // Ambil semua anggota jemaat untuk ditampilkan dalam pilihan (optional, jika diperlukan)
        $anggotaJemaats = AnggotaJemaat::with('jemaat')->get();

        return view('baptisans.edit', compact('baptisan', 'anggotaJemaats', 'selectedAnggotaJemaat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Baptisan $baptisan)
    {
        $request->validate([
            'tanggal_baptis' => 'required|date',
            'tempat_baptis' => 'required|string|max:255',
            'pendeta_baptis' => 'required|string|max:255',
            'daftar_saksi' => 'nullable|string',
        ]);
       // Hapus _token dan _method dari data yang akan disimpan
        $validatedData = $request->except(['_token', '_method']);
        // Hapus dokumen lama jika ada dan pengguna mengunggah dokumen baru
    if ($request->hasFile('dokumen_baptisan')) {
        if ($baptisan->dokumen_baptisan) {
            Storage::delete($baptisan->dokumen_baptisan);
        }
        $dokumenPath = $request->file('dokumen_baptisan')->store('public/baptisans/dokumen');
        $validatedData['dokumen_baptisan'] = $dokumenPath;
    }
        // Update data baptisan
        $baptisan->update($validatedData);

        // Redirect ke halaman index baptisan dengan pesan sukses
        return redirect()->route('baptisans.index')->with('success', 'Data baptisan berhasil diperbarui.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Baptisan $baptisan)
    {
        if ($baptisan->dokumen_baptisan) {
            Storage::delete($baptisan->dokumen_baptisan);
        }

        $baptisan->delete();

        return redirect()->route('baptisans.index')->with('success', 'Data baptisan berhasil dihapus.');
    }
}
