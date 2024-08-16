@extends('layouts.mainlayout')

@section('title', 'Daftar Pernikahan')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Daftar Pernikahan</h1>
        </div>

        <div class="card-body">
            {{-- Form Filter dan Pencarian --}}
            <form action="{{ route('nikahs.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="search" placeholder="Cari pernikahan..." value="{{ $search }}">
                    </div>
                    @if(auth()->user()->hasRole('admin_klasis') || auth()->user()->hasRole('super_admin'))
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

            {{-- Tombol Tambah Pernikahan Baru --}}
            @can('create nikahs')
                <div class="mt-3">
                    <a href="{{ route('nikahs.create') }}" class="btn btn-primary mb-3">Tambah Data Pernikahan</a>
                </div>
            @endcan

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
                        <th>Foto Nikah</th>
                        <th>Dokumen Nikah</th>
                        @can('edit nikah')
                        <th>Aksi</th>
                        @endcan

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
                            <td>
                                @if ($nikah->foto_nikah)
                                    <img src="{{ asset('storage/' . $nikah->foto_nikah) }}" alt="Foto Nikah" class="img-thumbnail" style="max-width: 100px;">
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td>
                                @if ($nikah->dokumen_nikah)
                                    <a href="{{ asset('storage/' . $nikah->dokumen_nikah) }}" target="_blank" class="btn btn-sm btn-outline-secondary" download>Unduh Dokumen</a>
                                @else
                                    Tidak ada dokumen
                                @endif
                            </td>
                            <td class="d-flex flex-column">
                                @can('edit nikahs')
                                    <a href="{{ route('nikahs.edit', $nikah->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                                @endcan
                                @can('delete nikahs')
                                    <form action="{{ route('nikahs.destroy', $nikah->id) }}" method="POST" style="display: inline;">
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
                {{ $nikahs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
