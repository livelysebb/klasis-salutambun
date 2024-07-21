@extends('layouts.mainlayout')

@section('title', 'Daftar Pernikahan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Daftar Pernikahan</h1>
                </div>

                <div class="card-body">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('nikahs.index') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Cari pernikahan..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </form>

                    {{-- Tombol Tambah Pernikahan Baru --}}
                    <div class="mt-3">
                        <a href="{{ route('nikahs.create') }}" class="btn btn-primary mb-3">Tambah Pernikahan Baru</a>
                    </div>

                    {{-- Daftar Pernikahan (Tabel) --}}
                    <table class="table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
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
                            @php $nomor = ($nikahs->currentPage() - 1) * $nikahs->perPage() + 1; @endphp
                            @foreach ($nikahs as $nikah)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
                                    <td>{{ $nikah->anggotaJemaat->nama }}</td>
                                    <td>{{ $nikah->pasangan->nama }}</td>
                                    <td>{{ $nikah->tanggal_nikah->format('d-m-Y') }}</td>
                                    <td>{{ $nikah->tempat_nikah }}</td>
                                    <td>{{ $nikah->pendeta_nikah }}</td>
                                    <td>{{ $nikah->catatan_nikah }}</td>
                                    <td class="d-flex flex-column">
                                        <a href="{{ route('nikahs.edit', $nikah->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                                        <form action="{{ route('nikahs.destroy', $nikah->id) }}" method="POST" style="display: inline;">
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
                        {{ $nikahs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
