@extends('layouts.mainlayout')

@section('title', 'Daftar Pernikahan')

@section('content')
<div class="container mt-4">
    <h1>Daftar Pernikahan</h1>

    <form action="{{ route('nikahs.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Cari pernikahan..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="mt-3">
        <a href="{{ route('nikahs.create') }}" class="btn btn-primary">Tambah Pernikahan Baru</a>
    </div>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Anggota Jemaat</th>
                <th>Pasangan</th>
                <th>Tanggal Nikah</th>
                <th>Tempat Nikah</th>
                <th>Pendeta Nikah</th>
                <th>Catatan Nikah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nikahs as $nikah)
            <tr>
                <td>{{ $nikah->id }}</td>
                <td>{{ $nikah->anggotaJemaat->nama }}</td>
                <td>{{ $nikah->pasangan->nama }}</td>
                <td>{{ $nikah->tanggal_nikah }}</td>
                <td>{{ $nikah->tempat_nikah }}</td>
                <td>{{ $nikah->pendeta_nikah }}</td>
                <td>{{ $nikah->catatan_nikah }}</td>
                <td class="d-flex flex-column">
                    <a href="{{ route('nikahs.edit', $nikah->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                    <form action="{{ route('nikahs.destroy', $nikah->id) }}" method="POST">
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
        {{ $nikahs->links() }}
    </div>
</div>
@endsection
