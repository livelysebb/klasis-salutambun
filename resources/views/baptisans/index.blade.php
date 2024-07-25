@extends('layouts.mainlayout')

@section('title', 'Daftar Baptisan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Daftar Baptisan</h1>
                </div>
                <div class="card-body">
                    {{-- Form Filter dan Pencarian --}}
                        <form action="{{ route('baptisans.index') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" placeholder="Cari baptisan..." value="{{ $search }}">

                                {{-- Dropdown Pemilihan Jemaat --}}
                                <select class="form-select" name="jemaat_id">
                                    <option value="">Semua Jemaat</option>
                                    @foreach ($jemaats as $id => $nama)
                                        <option value="{{ $id }}" {{ $id == $jemaatId ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>

                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </form>

                    {{-- Tombol Tambah Data Baptisan --}}
                    <div class="mt-3">
                        <a href="{{ route('baptisans.create') }}" class="btn btn-primary mb-3">Tambah Data Baptisan</a>
                    </div>

                    {{-- Daftar Baptisan (Tabel) --}}
                    <table class="table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota Jemaat</th>
                                <th>Tanggal Baptis</th>
                                <th>Tempat Baptis</th>
                                <th>Pendeta Baptis</th>
                                <th>Umur Saat Baptis</th>
                                <th>Jenis Kelamin</th>
                                <th>Nama Ayah</th>
                                <th>Nama Ibu</th>
                                <th>Daftar Saksi</th>
                                <th>Aksi</th>
                                <th>Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $nomor = ($baptisans->currentPage() - 1) * $baptisans->perPage() + 1; @endphp
                            @foreach ($baptisans as $baptisan)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
                                    <td>{{ $baptisan->anggotaJemaat->nama }}</td>
                                    <td>{{ $baptisan->tanggal_baptis->format('d-m-Y') }}</td>
                                    <td>{{ $baptisan->tempat_baptis }}</td>
                                    <td>{{ $baptisan->pendeta_baptis }}</td>
                                    <td>{{ $baptisan->umur_saat_baptis }}</td>
                                    <td>{{ $baptisan->anggotaJemaat->jenis_kelamin }}</td>
                                    <td>{{ $baptisan->anggotaJemaat->nama_ayah }}</td>
                                    <td>{{ $baptisan->anggotaJemaat->nama_ibu }}</td>
                                    <td>{{ $baptisan->daftar_saksi }}</td>
                                    <td>
                                        @if ($baptisan->dokumen_baptisan)
                                            <a href="{{ asset('storage/' . $baptisan->dokumen_baptisan) }}" class="btn btn-sm btn-outline-secondary" download>Unduh Dokumen</a>
                                        @else
                                            Tidak ada dokumen
                                        @endif
                                    </td>
                                    <td class="d-flex flex-column">
                                        <a href="{{ route('baptisans.edit', $baptisan->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                                        <form action="{{ route('baptisans.destroy', $baptisan->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $baptisans->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
