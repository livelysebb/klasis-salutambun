@extends('layouts.mainlayout')

@section('title', 'Daftar Anggota Jemaat')

@section('content')
<div class="container mt-4">
    <h1>Daftar Anggota Jemaat</h1>

        <form action="{{ route('anggota-jemaat.index') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Cari anggota jemaat..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>


    <div class="mt-3">
        <a href="{{ route('anggota-jemaat.create') }}" class="btn btn-primary">Tambah Anggota Jemaat Baru</a>
    </div>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Jemaat</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Nama Ayah</th>
                <th>Nama Ibu</th>
                <th>Baptis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggotaJemaat as $anggota)
                <tr>
                    <td>{{ $anggota->nomor }}</td>
                    <td><a href="{{ route('anggota-jemaat.show', $anggota->id) }}">{{ $anggota->nama }}</a></td>
                    <td>{{ $anggota->jemaat->nama }}</td>
                    <td>{{ $anggota->jenis_kelamin }}</td>
                    <td>{{ $anggota->tempat_lahir }}</td>
                    <td>{{ $anggota->tanggal_lahir }}</td>
                    <td>{{ $anggota->nama_ayah }}</td>
                    <td>{{ $anggota->nama_ibu }}</td>
                    <td>
                        @if ($anggota->baptisan)
                            Sudah Baptis
                        @else
                            Belum Baptis
                        @endif
                    </td>
                    <td class="d-flex flex-column">
                        <a href="{{ route('anggota-jemaat.edit', $anggota->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                        <form action="{{ route('anggota-jemaat.destroy', $anggota->id) }}" method="POST">
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
        {{ $anggotaJemaat->links() }}
    </div>
</div>
@endsection
