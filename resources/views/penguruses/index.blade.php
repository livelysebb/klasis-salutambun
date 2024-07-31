@extends('layouts.mainlayout')

@section('title', 'Daftar Pengurus')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Daftar Pengurus</h1>
        </div>
        <div class="card-body">
            {{-- Form Filter dan Pencarian --}}
            <form action="{{ route('penguruses.index') }}" method="GET">
                <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Cari pengurus..." value="{{ $search }}">
                        <select class="form-select" name="jemaat_id">
                            <option value="">Semua Jemaat</option>
                            @foreach ($jemaats as $id => $nama)
                                <option value="{{ $id }}" {{ $id == $jemaatId ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>

                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            {{-- Tombol Tambah Pengurus Baru --}}
            <div class="mt-3">
                <a href="{{ route('penguruses.create') }}" class="btn btn-primary mb-3">Tambah Pengurus Baru</a>
            </div>

            {{-- Daftar Pengurus (Tabel) --}}
            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Jemaat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $nomor = ($pengurus->currentPage() - 1) * $pengurus->perPage() + 1; @endphp
                    @foreach ($pengurus as $pengurusItem)
                        <tr>
                            <td>{{ $nomor++ }}</td>
                            <td>{{ $pengurusItem->anggotaJemaat->nama }}</td>
                            <td>{{ $pengurusItem->jabatan }}</td>
                            <td>{{ $pengurusItem->anggotaJemaat->jemaat->nama }}</td>
                            <td class="d-flex flex-column">
                                <a href="{{ route('penguruses.edit', $pengurusItem->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                                <form action="{{ route('penguruses.destroy', $pengurusItem->id) }}" method="POST" style="display: inline;">
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
                {{ $pengurus->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
