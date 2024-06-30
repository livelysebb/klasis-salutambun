@extends('layouts.mainlayout')

@section('title', 'Edit Data Pernikahan')

@section('content')
<div class="container mt-4">
    <h1>Edit Data Pernikahan</h1>

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
            <input type="date" class="form-control @error('tanggal_nikah') is-invalid @enderror" id="tanggal_nikah" name="tanggal_nikah" value="{{ old('tanggal_nikah', $nikah->tanggal_nikah) }}" required>
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
            <textarea name="catatan_nikah" id="catatan_nikah" class="form-control">{{ old('catatan_nikah', $nikah->catatan_nikah) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
