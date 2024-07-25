@extends('layouts.mainlayout')

@section('title', 'Edit Data Baptisan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Edit Data Baptisan</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('baptisans.update', $baptisan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
                            <input type="text" class="form-control" id="anggota_jemaat_id" name="anggota_jemaat_id" value="{{ $baptisan->anggotaJemaat->nama }} ({{ $baptisan->anggotaJemaat->jemaat->nama }})" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_baptis" class="form-label">Tanggal Baptis</label>
                            <input type="date" class="form-control @error('tanggal_baptis') is-invalid @enderror" id="tanggal_baptis" name="tanggal_baptis" value="{{ old('tanggal_baptis', $baptisan->tanggal_baptis->format('Y-m-d')) }}" required>
                            @error('tanggal_baptis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tempat_baptis" class="form-label">Tempat Baptis</label>
                            <input type="text" class="form-control @error('tempat_baptis') is-invalid @enderror" id="tempat_baptis" name="tempat_baptis" value="{{ old('tempat_baptis', $baptisan->tempat_baptis) }}" required>
                            @error('tempat_baptis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pendeta_baptis" class="form-label">Pendeta Baptis</label>
                            <input type="text" class="form-control @error('pendeta_baptis') is-invalid @enderror" id="pendeta_baptis" name="pendeta_baptis" value="{{ old('pendeta_baptis', $baptisan->pendeta_baptis) }}" required>
                            @error('pendeta_baptis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="daftar_saksi" class="form-label">Daftar Saksi (pisahkan dengan koma)</label>
                            <textarea class="form-control @error('daftar_saksi') is-invalid @enderror" id="daftar_saksi" name="daftar_saksi">{{ old('daftar_saksi', $baptisan->daftar_saksi) }}</textarea>
                            @error('daftar_saksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dokumen_baptisan" class="form-label">Dokumen Baptisan (Opsional)</label>
                            <input type="file" class="form-control @error('dokumen_baptisan') is-invalid @enderror" id="dokumen_baptisan" name="dokumen_baptisan">
                            @error('dokumen_baptisan')
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
