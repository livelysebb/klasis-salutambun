<?php

namespace App\Http\Controllers;

use App\Models\AnggotaJemaat;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // untuk validasi unik
use Illuminate\Support\Facades\Storage;

class AnggotaJemaatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $jemaatId = $request->query('jemaat_id');

        $anggotaJemaat = AnggotaJemaat::with('jemaat')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->when(auth()->user()->hasRole('admin_jemaat'), function ($query) {
                $query->where('jemaat_id', auth()->user()->jemaat_id);
            })
            // Tambahkan kondisi untuk super admin
            ->when(auth()->user()->hasRole('super_admin') && $jemaatId, function ($query) use ($jemaatId) {
                $query->where('jemaat_id', $jemaatId);
            })
            ->latest()
            ->paginate(10);

        $anggotaJemaat->getCollection()->transform(function ($item, $key) use ($anggotaJemaat) {
            $item->nomor = ($anggotaJemaat->currentPage() - 1) * $anggotaJemaat->perPage() + $key + 1;
            return $item;
        });

        $jemaats = Jemaat::pluck('nama', 'id');

        return view('anggota_jemaat.index', compact('anggotaJemaat', 'search', 'jemaats', 'jemaatId'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('admin_jemaat')) {
            // Jika admin jemaat, ambil hanya jemaat yang sesuai dengan jemaat_id pengguna
            $jemaats = Jemaat::where('id', auth()->user()->jemaat_id)->get();
        } else {
            // Jika bukan admin jemaat, ambil semua jemaat
            $jemaats = Jemaat::all();
        }

        return view('anggota_jemaat.create', compact('jemaats'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jemaat_id' => 'required|exists:jemaats,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('anggota-jemaat/foto');
            $validatedData['foto'] = $fotoPath;
        }

        AnggotaJemaat::create($validatedData);

        return redirect()->route('anggota-jemaat.index')
            ->with('success', 'Anggota jemaat berhasil ditambahkan.');
    }

    public function show(AnggotaJemaat $anggotaJemaat)
    {
        $anggotaJemaat->load('jemaat'); // Eager loading relasi jemaat
        $baptis = $anggotaJemaat->baptisan;
        $sidi = $anggotaJemaat->sidi;
        $nikahs = $anggotaJemaat->pernikahans; // Ambil data pernikahan dari anggota jemaat
        $jemaat = $anggotaJemaat->jemaat; // Ambil data jemaat

        return view('anggota_jemaat.show', compact('anggotaJemaat', 'jemaat', 'baptis', 'sidi', 'nikahs'));
    }

    public function edit(AnggotaJemaat $anggotaJemaat)
    {
        $jemaats = Jemaat::all();
        return view('anggota_jemaat.edit', compact('anggotaJemaat', 'jemaats'));
    }

    public function update(Request $request, AnggotaJemaat $anggotaJemaat)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jemaat_id' => 'required|exists:jemaats,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($anggotaJemaat->foto) {
                Storage::delete($anggotaJemaat->foto);
            }
            $fotoPath = $request->file('foto')->store('public/anggota-jemaat/foto');
            $validatedData['foto'] = $fotoPath;
        }

        $anggotaJemaat->update($validatedData);

        return redirect()->route('anggota-jemaat.index')
            ->with('success', 'Data anggota jemaat berhasil diperbarui.');
    }

    public function destroy(AnggotaJemaat $anggotaJemaat)
    {
        $anggotaJemaat->delete();

        return redirect()->route('anggota-jemaat.index')
            ->with('success', 'Anggota jemaat berhasil dihapus.');
    }
}
