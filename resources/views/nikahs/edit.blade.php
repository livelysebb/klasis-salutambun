@extends('layouts.mainlayout')

@section('title', 'Edit Data Pernikahan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Edit Data Pernikahan</h1>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('nikahs.update', $nikah->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="anggota_jemaat_id" value="{{ $nikah->anggota_jemaat_id }}">
                        <input type="hidden" name="pasangan_id" value="{{ $nikah->pasangan_id }}">

                        <div class="mb-3">
                            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
                            <input type="text" class="form-control" id="anggota_jemaat_id" value="{{ $nikah->anggotaJemaat->nama }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="pasangan_id" class="form-label">Pasangan</label>
                            <input type="text" class="form-control" id="pasangan_id" value="{{ $nikah->pasangan->nama }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_nikah" class="form-label">Tanggal Nikah</label>
                            <input type="date" class="form-control @error('tanggal_nikah') is-invalid @enderror" id="tanggal_nikah" name="tanggal_nikah" value="{{ old('tanggal_nikah', $nikah->tanggal_nikah->format('Y-m-d')) }}" required>
                            @error('tanggal_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tempat_nikah" class="form-label">Tempat Nikah</label>
                            <input type="text" class="form-control @error('tempat_nikah') is-invalid @enderror" id="tempat_nikah" name="tempat_nikah" value="{{ old('tempat_nikah', $nikah->tempat_nikah) }}" required>
                            @error('tempat_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pendeta_nikah" class="form-label">Pendeta Nikah</label>
                            <input type="text" class="form-control @error('pendeta_nikah') is-invalid @enderror" id="pendeta_nikah" name="pendeta_nikah" value="{{ old('pendeta_nikah', $nikah->pendeta_nikah) }}" required>
                            @error('pendeta_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan_nikah" class="form-label">Catatan Nikah</label>
                            <textarea class="form-control @error('catatan_nikah') is-invalid @enderror" id="catatan_nikah" name="catatan_nikah">{{ old('catatan_nikah', $nikah->catatan_nikah) }}</textarea>
                            @error('catatan_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto_nikah" class="form-label">Foto Nikah (Opsional)</label>
                            @if ($nikah->foto_nikah)
                                <p>File saat ini: <a href="{{ asset('storage/' . $nikah->foto_nikah) }}" target="_blank">{{ $nikah->foto_nikah }}</a></p>
                            @endif
                            <input type="file" class="form-control @error('foto_nikah') is-invalid @enderror" id="foto_nikah" name="foto_nikah">
                            @error('foto_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dokumen_nikah" class="form-label">Dokumen Nikah (Opsional)</label>
                            @if ($nikah->dokumen_nikah)
                                <p>File saat ini: <a href="{{ asset('storage/' . $nikah->dokumen_nikah) }}" target="_blank">{{ $nikah->dokumen_nikah }}</a></p>
                            @endif
                            <input type="file" class="form-control @error('dokumen_nikah') is-invalid @enderror" id="dokumen_nikah" name="dokumen_nikah">
                            @error('dokumen_nikah')
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
