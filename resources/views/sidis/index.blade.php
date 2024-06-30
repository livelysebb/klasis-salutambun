@extends('layouts.mainlayout')

@section('title', 'Daftar Sidi')

@section('content')
<div class="container mt-4">
    <h1>Daftar Sidi</h1>

    <form action="{{ route('sidis.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Cari anggota sidi..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="mt-3">
        <a href="{{ route('sidis.create') }}" class="btn btn-primary">Tambah Data Sidi</a>
    </div>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Anggota Jemaat</th>
                <th>Tanggal Sidi</th>
                <th>Tempat Sidi</th>
                <th>Pendeta Sidi</th>
                <th>Bacaan Sidi</th>
                <th>Nomor Surat</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sidis as $sidi)
                <tr>
                    <td>{{ $sidi->id }}</td>
                    <td>{{ $sidi->anggotaJemaat->nama }}</td>
                    <td>{{ $sidi->tanggal_sidi }}</td>
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
                    <td class="d-flex flex-column">
                        <a href="{{ route('sidis.edit', $sidi->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                        <form action="{{ route('sidis.destroy', $sidi->id) }}" method="POST" style="display: inline;">
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
        {{ $sidis->links() }}
    </div>
</div>
@endsection
