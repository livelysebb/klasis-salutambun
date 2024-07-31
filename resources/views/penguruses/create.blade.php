@extends('layouts.mainlayout')

@section('title', 'Tambah Pengurus Baru')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Tambah Pengurus Baru</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('penguruses.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
                            <select class="form-select @error('anggota_jemaat_id') is-invalid @enderror" id="anggota_jemaat_id" name="anggota_jemaat_id" required>
                                <option value="">Pilih Anggota Jemaat</option>
                                @foreach ($anggotaJemaats as $anggotaJemaat)
                                    <option value="{{ $anggotaJemaat->id }}" {{ old('anggota_jemaat_id') == $anggotaJemaat->id ? 'selected' : '' }}>
                                        {{ $anggotaJemaat->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('anggota_jemaat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai')
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
