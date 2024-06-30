@extends('layouts.mainlayout')

@section('title', 'Tambah Data Sidi')

@section('content')
<div class="container mt-4">
    <h1>Tambah Data Sidi</h1>

    <form action="{{ route('sidis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
            <select class="form-select" id="anggota_jemaat_id" name="anggota_jemaat_id" required>
                <option value="">Pilih Anggota Jemaat</option>
                @foreach ($anggotaJemaats as $anggotaJemaat)
                    <option value="{{ $anggotaJemaat->id }}" {{ old('anggota_jemaat_id') == $anggotaJemaat->id ? 'selected' : '' }}>
                        {{ $anggotaJemaat->nama }} ({{ $anggotaJemaat->jemaat->nama }})
                    </option>
                @endforeach
            </select>
            @error('anggota_jemaat_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_sidi" class="form-label">Tanggal Sidi</label>
            <input type="date" class="form-control @error('tanggal_sidi') is-invalid @enderror" id="tanggal_sidi" name="tanggal_sidi" value="{{ old('tanggal_sidi') }}" required>
            @error('tanggal_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tempat_sidi" class="form-label">Tempat Sidi</label>
            <input type="text" class="form-control @error('tempat_sidi') is-invalid @enderror" id="tempat_sidi" name="tempat_sidi" value="{{ old('tempat_sidi') }}" required>
            @error('tempat_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pendeta_sidi" class="form-label">Pendeta Sidi</label>
            <input type="text" class="form-control @error('pendeta_sidi') is-invalid @enderror" id="pendeta_sidi" name="pendeta_sidi" value="{{ old('pendeta_sidi') }}" required>
            @error('pendeta_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="bacaan_sidi" class="form-label">Bacaan Sidi</label>
            <input type="text" class="form-control @error('bacaan_sidi') is-invalid @enderror" id="bacaan_sidi" name="bacaan_sidi" value="{{ old('bacaan_sidi') }}" required>
            @error('bacaan_sidi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}">
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
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
