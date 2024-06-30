@extends('layouts.mainlayout')

@section('title', 'Daftar Jemaat')

@section('content')
<div class="container mt-4">
    <h1>Daftar Jemaat</h1>
        <form action="{{ route('jemaats.index') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Cari jemaat..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

    <div class="mt-3">
        <a href="{{ route('jemaats.create') }}" class="btn btn-primary">Tambah Jemaat Baru</a>
    </div>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jemaats as $jemaat)
                <tr>
                    <td>{{ $jemaat->id }}</td>
                    <td>{{ $jemaat->nama }}</td>
                    <td>{{ $jemaat->alamat }}</td>
                    <td>{{ $jemaat->telepon }}</td>
                    <td>{{ $jemaat->email }}</td>
                    <td class="d-flex flex-column">
                        <a href="{{ route('jemaats.edit', $jemaat->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                        <form action="{{ route('jemaats.destroy', $jemaat->id) }}" method="POST">
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
        {{ $jemaats->links() }}
    </div>
</div>
@endsection
