@extends('layouts.mainlayout')

@section('title', 'Daftar Sidi')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Daftar Sidi</h1>
        </div>

        <div class="card-body">
            {{-- Form Filter dan Pencarian --}}
            <form action="{{ route('sidis.index') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Cari anggota sidi..." value="{{ $search }}">

                    {{-- Dropdown Pemilihan Jemaat (Hanya untuk admin_klasis dan super_admin) --}}
                    @if(auth()->user()->hasRole('admin_klasis') || auth()->user()->hasRole('super_admin'))
                        <select class="form-select" name="jemaat_id">
                            <option value="">Semua Jemaat</option>
                            @foreach ($jemaats as $id => $nama)
                                <option value="{{ $id }}" {{ $id == $jemaatId ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    @endif

                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            {{-- Tombol Tambah Data Sidi --}}
            @can('create sidis')
            <div class="mt-3">
                <a href="{{ route('sidis.create') }}" class="btn btn-primary mb-3">Tambah Data Sidi</a>
            </div>
            @endcan

            {{-- Daftar Sidi (Tabel) --}}
            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota Jemaat</th>
                        <th>Tanggal Sidi</th>
                        <th>Tempat Sidi</th>
                        <th>Pendeta Sidi</th>
                        <th>Bacaan Sidi</th>
                        <th>Nomor Surat</th>
                        <th>Foto</th>
                        <th>Dokumen</th>
                        {{-- Aksi hanya untuk super admin dan admin jemaat --}}
                        @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin_jemaat'))
                        <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $nomor = ($sidis->currentPage() - 1) * $sidis->perPage() + 1; @endphp
                    @foreach ($sidis as $sidi)
                        <tr>
                            <td>{{ $nomor++ }}</td>
                            <td>{{ $sidi->anggotaJemaat->nama }}</td>
                            <td>{{ $sidi->tanggal_sidi->format('d-m-Y') }}</td>
                            <td>{{ $sidi->tempat_sidi }}</td>
                            <td>{{ $sidi->pendeta_sidi }}</td>
                            <td>{{ $sidi->bacaan_sidi }}</td>
                            <td>{{ $sidi->nomor_surat }}</td>
                            <td>
                                @if ($sidi->foto)
                                    <img src="{{ asset('storage/' . $sidi->foto) }}" alt="Foto Sidi" class="img-thumbnail" style="max-width: 100px;">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td>
                                @if ($sidi->dokumen_sidi)
                                    <a href="{{ asset('storage/' . $sidi->dokumen_sidi) }}" class="btn btn-sm btn-outline-secondary" download>Unduh Dokumen</a>
                                @else
                                    Tidak ada dokumen
                                @endif
                            </td>
                            {{-- Aksi hanya untuk super admin dan admin jemaat --}}
                            @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin_jemaat'))
                            <td class="d-flex flex-column">
                                @can('edit sidis')
                                    <a href="{{ route('sidis.edit', $sidi->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                                @endcan
                                @can('delete sidis')
                                    <form action="{{ route('sidis.destroy', $sidi->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                @endcan
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $sidis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
