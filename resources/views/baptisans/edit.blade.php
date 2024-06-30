@extends('layouts.mainlayout')

@section('title', 'Edit Data Baptisan')

@section('content')
<div class="container mt-4">
    <h1>Edit Data Baptisan</h1>

    <form action="{{ route('baptisans.update', $baptisan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
            <input type="text" class="form-control" id="anggota_jemaat_id" name="anggota_jemaat_id" value="{{ $selectedAnggotaJemaat->nama }}" disabled>
        </div>

        <div class="mb-3">
            <label for="tanggal_baptis" class="form-label">Tanggal Baptis</label>
            <input type="date" class="form-control" id="tanggal_baptis" name="tanggal_baptis" value="{{ old('tanggal_baptis', $baptisan->tanggal_baptis) }}" required>
        </div>

        <div class="mb-3">
            <label for="tempat_baptis" class="form-label">Tempat Baptis</label>
            <input type="text" class="form-control" id="tempat_baptis" name="tempat_baptis" value="{{ old('tempat_baptis', $baptisan->tempat_baptis) }}" required>
        </div>

        <div class="mb-3">
            <label for="pendeta_baptis" class="form-label">Pendeta Baptis</label>
            <input type="text" class="form-control" id="pendeta_baptis" name="pendeta_baptis" value="{{ old('pendeta_baptis', $baptisan->pendeta_baptis) }}" required>
        </div>

        <div class="mb-3">
            <label for="daftar_saksi" class="form-label">Daftar Saksi</label>
            <textarea class="form-control" id="daftar_saksi" name="daftar_saksi" required>{{ old('daftar_saksi', $baptisan->daftar_saksi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
