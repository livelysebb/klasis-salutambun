@extends('layouts.mainlayout')

@section('title', 'Daftar Baptisan')

@section('content')
<div class="container mt-4">
    <h1>Daftar Baptisan</h1>

    <form action="{{ route('baptisans.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Cari baptisan..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="mt-3">
        <a href="{{ route('baptisans.create') }}" class="btn btn-primary">Tambah Data Baptisan</a>
    </div>

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
            </tr>
        </thead>
        <tbody>
            @php
                $nomor = ($baptisans->currentPage() - 1) * $baptisans->perPage() + 1;
            @endphp
            @foreach ($baptisans as $baptisan)
                <tr>
                    <td>{{ $nomor++ }}</td>
                    <td>{{ $baptisan->anggotaJemaat->nama }}</td>
                    <td>{{ $baptisan->tanggal_baptis}}</td>
                    <td>{{ $baptisan->tempat_baptis }}</td>
                    <td>{{ $baptisan->pendeta_baptis }}</td>
                    <td>{{ $baptisan->umur_saat_baptis }}</td>
                    <td>{{ $baptisan->anggotaJemaat->jenis_kelamin }}</td>
                    <td>{{ $baptisan->anggotaJemaat->nama_ayah }}</td>
                    <td>{{ $baptisan->anggotaJemaat->nama_ibu }}</td>
                    <td>{{ $baptisan->daftar_saksi }}</td>
                    <td class="d-flex flex-column">
                        <a href="{{ route('baptisans.edit', $baptisan->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                        <form action="{{ route('baptisans.destroy', $baptisan->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $baptisans->links() }}
    </div>
</div>
@endsection
