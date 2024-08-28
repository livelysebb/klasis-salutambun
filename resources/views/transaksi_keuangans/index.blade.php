@extends('layouts.mainlayout')

@section('title', 'Daftar Transaksi Keuangan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Daftar Transaksi Keuangan</h1>
                </div>

                <div class="card-body">
                    <form action="{{ route('transaksi_keuangans.index') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Cari transaksi..." value="{{ $search }}">

                            {{-- Hanya tampilkan dropdown jemaat jika bukan admin bendahara jemaat --}}
                            @unlessrole('admin_bendahara_jemaat')
                                <select class="form-select" name="jemaat_id">
                                    <option value="">Semua Jemaat</option>
                                    @foreach ($jemaats as $id => $nama)
                                        <option value="{{ $id }}" {{ $id == $jemaatId ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                            @endunlessrole

                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                        </div>
                    </form>

                    <div class="mt-3">
                        @can('create keuangan')
                        <a href="{{ route('transaksi_keuangans.create') }}" class="btn btn-primary mb-3">Tambah Transaksi Baru</a>
                        @endcan

                        @can('generate laporan')
                        <a href="{{ route('transaksi_keuangans.laporan_pdf', ['jemaat_id' => $jemaatId]) }}" class="btn btn-secondary mb-3">Unduh Laporan PDF</a>
                        @endcan

                        @can('view transaksi keuangan')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-white bg-danger mb-3">
                                    <div class="card-header">Total Pengeluaran</div>
                                    <div class="card-body">
                                        <h5 class="card-title">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-header">Total Pemasukan</div>
                                    <div class="card-body">
                                        <h5 class="card-title">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-white bg-info mb-3">
                                    <div class="card-header">Sisa Dana</div>
                                    <div class="card-body">
                                        <h5 class="card-title">Rp {{ number_format($sisaDana, 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endcan

                    {{-- Hanya tampilkan tabel transaksi jika bukan admin klasis --}}
                    @can('view keuangan')
                        <table class="table table-striped table-hover mt-3">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jemaat</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Keterangan</th>
                                    @can('delete keuangan')
                                    <th>Aksi</th>
                                    @endcan

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nomor = ($transaksiKeuangan->currentPage() - 1) * $transaksiKeuangan->perPage() + 1;
                                @endphp
                                @foreach ($transaksiKeuangan as $transaksi)
                                    <tr>
                                        <td>{{ $nomor++ }}</td>
                                        <td>{{ $transaksi->jemaat->nama }}</td>
                                        <td>{{ $transaksi->jenis_transaksi }}</td>
                                        <td>{{ $transaksi->jumlah }}</td>
                                        <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
                                        <td>{{ $transaksi->keterangan }}</td>

                                        @can('delete keuangan')
                                        <td class="d-flex flex-column">
                                            <a href="{{ route('transaksi_keuangans.edit', $transaksi->id) }}" class="btn btn-sm btn-outline-primary mb-2">Edit</a>
                                            <form action="{{ route('transaksi_keuangans.destroy', $transaksi->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endcan
                        <div class="d-flex justify-content-center mt-3">
                            {{ $transaksiKeuangan->links() }}
                        </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
