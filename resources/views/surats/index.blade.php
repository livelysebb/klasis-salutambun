@extends('layouts.mainlayout')

@section('title', 'Daftar Surat')

@section('content')
<div class="container mt-4">
    <h1>Daftar Surat</h1>

    <form action="{{ route('surats.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Cari surat..." value="{{ $search }}">
            <select class="form-select" name="jemaat_id">
                <option value="">Semua Jemaat</option>
                @foreach ($jemaats as $id => $nama)
                    <option value="{{ $id }}" {{ $id == $jemaatId ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <div class="mt-3">
        <a href="{{ route('surats.create') }}" class="btn btn-primary">Tambah Surat Baru</a>
    </div>

    <table class="table table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Jenis Surat</th>
                <th>Perihal</th>
                <th>Tanggal Surat</th>
                <th>Pengirim/Tujuan</th>
                <th>Penerima</th>
                <th>Jemaat</th>
                <th>File Surat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surats as $surat)
                <tr>
                    <td>{{ $surat->nomor_surat }}</td>
                    <td>{{ $surat->jenis_surat }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td>{{ $surat->tanggal_surat->format('d-m-Y') }}</td>
                    <td>{{ $surat->pengirim_tujuan }}</td>
                    <td>{{ $surat->penerima ?? '-' }}</td>
                    <td>{{ $surat->jemaat->nama }}</td>
                    <td>
                        @if ($surat->file_surat)
                            <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank">Lihat File</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                    <a href="{{ route('surats.edit', $surat->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                    <form action="{{ route('surats.destroy', $surat->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">Hapus</button>
                                            </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $surats->links() }}
    </div>
</div>
@endsection

