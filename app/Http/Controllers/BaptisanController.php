<?php

namespace App\Http\Controllers;

use App\Models\Baptisan;
use App\Models\AnggotaJemaat;
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

        $search = $request->query('search');

    $baptisans = Baptisan::with('anggotaJemaat')
        ->when($search, function ($query, $search) {
            return $query->where('tempat_baptis', 'like', "%{$search}%")
                ->orWhereHas('anggotaJemaat', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
        })
        ->latest()
        ->paginate(10);

    $baptisans->getCollection()->transform(function ($baptisan, $key) use ($baptisans) {
        $tanggalBaptis = Carbon::parse($baptisan->tanggal_baptis);
        $tanggalLahir = Carbon::parse($baptisan->anggotaJemaat->tanggal_lahir);

        // Format tanggal_baptis menjadi 'Y-m-d'
        //$baptisan->tanggal_baptis = Carbon::parse($baptisan->tanggal_baptis)->format('d-m-Y');
        //dd($baptisan->tanggal_baptis);

        if ($tanggalBaptis->greaterThanOrEqualTo($tanggalLahir)) {
            $umur = $tanggalLahir->diff($tanggalBaptis);
            $baptisan->umur_saat_baptis = $umur->y . ' tahun ' . $umur->m . ' bulan';
        } else {
            $baptisan->umur_saat_baptis = 'Tanggal Baptis Tidak Valid';
        }

        $baptisan->nomor = ($baptisans->currentPage() - 1) * $baptisans->perPage() + $key + 1;
        return $baptisan;
    });

    return view('baptisans.index', compact('baptisans', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // app/Http/Controllers/BaptisanController.php

        $anggotaJemaats = AnggotaJemaat::doesntHave('baptisan')
        ->with('jemaat')
        ->orderBy('nama', 'asc') // Urutkan berdasarkan nama anggota jemaat (ascending)
        ->get();

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
        ]);

        DB::beginTransaction();

        try {
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
        $baptisan->delete();

        return redirect()->route('baptisans.index')->with('success', 'Data baptisan berhasil dihapus.');
    }
}
