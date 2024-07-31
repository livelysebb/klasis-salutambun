@extends('layouts.mainlayout')

@section('title', 'Edit Pengurus')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Edit Pengurus</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('penguruses.update', $pengurus->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
                            <select class="form-select" id="anggota_jemaat_id" name="anggota_jemaat_id" disabled>
                                <option value="{{ $pengurus->anggota_jemaat_id }}">{{ $pengurus->anggotaJemaat->nama }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan', $pengurus->jabatan) }}" required>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengurus->tanggal_mulai->format('Y-m-d')) }}" required>
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pengurus->tanggal_selesai ? $pengurus->tanggal_selesai->format('Y-m-d') : null) }}">
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
