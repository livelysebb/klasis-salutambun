@extends('layouts.mainlayout')

@section('title', 'Tambah Transaksi Keuangan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Tambah Transaksi Keuangan</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi_keuangans.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jemaat_id" class="form-label">Jemaat</label>
                            <select class="form-select @error('jemaat_id') is-invalid @enderror" id="jemaat_id" name="jemaat_id" required>
                                <option value="">Pilih Jemaat</option>
                                @foreach ($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id }}" {{ old('jemaat_id') == $jemaat->id ? 'selected' : '' }}>
                                        {{ $jemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jemaat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                            <select class="form-select @error('jenis_transaksi') is-invalid @enderror" id="jenis_transaksi" name="jenis_transaksi" required>
                                <option value="">Pilih Jenis Transaksi</option>
                                <option value="pemasukan" {{ old('jenis_transaksi') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="pengeluaran" {{ old('jenis_transaksi') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                            @error('jenis_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control @error('tanggal_transaksi') is-invalid @enderror" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ old('tanggal_transaksi') }}" required>
                            @error('tanggal_transaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                            <textarea class="form-control" id="keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
