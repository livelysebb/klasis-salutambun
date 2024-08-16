@extends('layouts.mainlayout')

@section('title', 'Daftar Anggota Jemaat')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Daftar Anggota Jemaat</h1>
        </div>

        <div class="card-body">
            {{-- Form Filter dan Pencarian --}}
            <form action="{{ route('anggota-jemaat.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="search" placeholder="Cari anggota jemaat..." value="{{ $search }}">
                    </div>
                    @if(Auth::user()->hasRole('admin_klasis||super_admin'))
                        <div class="col-md-4">
                            <select class="form-select" name="jemaat_id">
                                <option value="">Semua Jemaat</option>
                                @foreach ($jemaats as $id => $nama)
                                    <option value="{{ $id }}" {{ $id == $jemaatId ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </div>
            </form>

            {{-- Tombol Tambah Anggota Jemaat Baru --}}
            @can('create anggota jemaat')
                <div class="mt-3">
                    <a href="{{ route('anggota-jemaat.create') }}" class="btn btn-primary mb-3">Tambah Anggota Jemaat Baru</a>
                </div>
            @endcan

            {{-- Daftar Anggota Jemaat (Tabel) --}}
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
                        @can('edit anggota jemaat')
                        <th>Aksi</th>
                        @endcan

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
                            <td>{{ $anggota->tanggal_lahir->format('d-m-Y') }}</td>
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
                                @can('edit anggota jemaat')
                                    <a href="{{ route('anggota-jemaat.edit', $anggota->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                                @endcan
                                @can('delete anggota jemaat')
                                    <form action="{{ route('anggota-jemaat.destroy', $anggota->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $anggotaJemaat->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
