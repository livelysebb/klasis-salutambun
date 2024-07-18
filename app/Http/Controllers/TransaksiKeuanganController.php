<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use App\Models\Jemaat;
use Illuminate\Support\Facades\DB;

class TransaksiKeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $jemaatId = $request->query('jemaat_id');

        $jemaats = Jemaat::pluck('nama', 'id');

        $query = TransaksiKeuangan::with('jemaat')
            ->when($search, function ($query, $search) {
                $query->where('keterangan', 'like', "%{$search}%");
            })
            ->when($jemaatId, function ($query, $jemaatId) {
                $query->where('jemaat_id', $jemaatId);
            });

        // Hitung total pengeluaran dan pemasukan sebelum paginasi
        $totalPengeluaran = (clone $query)->where('jenis_transaksi', 'pengeluaran')->sum('jumlah');
        $totalPemasukan = (clone $query)->where('jenis_transaksi', 'pemasukan')->sum('jumlah');

        // Paginasi hasil query
        $transaksiKeuangan = $query->latest()->paginate(10);

        $sisaDana = $totalPemasukan - $totalPengeluaran;

        return view('transaksi_keuangans.index', compact('transaksiKeuangan', 'search', 'jemaats', 'jemaatId', 'totalPengeluaran', 'totalPemasukan', 'sisaDana'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jemaats = Jemaat::all(); // Ambil semua data jemaat (jika diperlukan)
        return view('transaksi_keuangans.create', compact('jemaats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'jemaat_id' => 'required|exists:jemaats,id',
            'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Simpan transaksi
            TransaksiKeuangan::create($validatedData);
            DB::commit();

            return redirect()->route('transaksi_keuangans.index')->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiKeuangan $transaksiKeuangan)
    {
        return view('transaksi_keuangans.show', compact('transaksiKeuangan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiKeuangan $transaksiKeuangan)
    {
        $jemaats = Jemaat::all(); // Ambil semua data jemaat (jika diperlukan)
        return view('transaksi_keuangans.edit', compact('transaksiKeuangan', 'jemaats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiKeuangan $transaksiKeuangan)
    {
        // Validasi input
        $validatedData = $request->validate([
            'jemaat_id' => 'required|exists:jemaats,id',
            'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $transaksiKeuangan->update($validatedData);
            DB::commit();
            return redirect()->route('transaksi_keuangans.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiKeuangan $transaksiKeuangan)
    {
        DB::beginTransaction();

        try {
            $transaksiKeuangan->delete();
            DB::commit();
            return redirect()->route('transaksi_keuangans.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
