@extends('layouts.mainlayout')

@section('title', 'Edit Data Sidi')

@section('content')
<div class="container mt-4">
    <h1>Edit Data Sidi</h1>

    <form action="{{ route('sidis.update', $sidi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
            <input type="text" class="form-control" id="anggota_jemaat_id" name="anggota_jemaat_id" value="{{ $selectedAnggotaJemaat->nama }}" disabled>
        </div>

        <div class="mb-3">
            <label for="tanggal_sidi" class="form-label">Tanggal Sidi</label>
            <input type="date" class="form-control" id="tanggal_sidi" name="tanggal_sidi" value="{{ old('tanggal_sidi', $sidi->tanggal_sidi) }}" required>
            @error('tanggal_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tempat_sidi" class="form-label">Tempat Sidi</label>
            <input type="text" class="form-control" id="tempat_sidi" name="tempat_sidi" value="{{ old('tempat_sidi', $sidi->tempat_sidi) }}" required>
            @error('tempat_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pendeta_sidi" class="form-label">Pendeta Sidi</label>
            <input type="text" class="form-control" id="pendeta_sidi" name="pendeta_sidi" value="{{ old('pendeta_sidi', $sidi->pendeta_sidi) }}" required>
            @error('pendeta_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="bacaan_sidi" class="form-label">Bacaan Sidi</label>
            <input type="text" class="form-control" id="bacaan_sidi" name="bacaan_sidi" value="{{ old('bacaan_sidi', $sidi->bacaan_sidi) }}" required>
            @error('bacaan_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $sidi->nomor_surat) }}">
            @error('nomor_surat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($sidi->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $sidi->foto) }}" alt="Foto Saat Ini" class="img-thumbnail" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
