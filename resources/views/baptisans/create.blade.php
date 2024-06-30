@extends('layouts.mainlayout')

@section('title', 'Tambah Data Baptisan')

@section('content')
<div class="container mt-4">
    <h1>Tambah Data Baptisan</h1>

    <form action="{{ route('baptisans.store') }}" method="POST">
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
        </div>

        <div class="mb-3">
            <label for="tanggal_baptis" class="form-label">Tanggal Baptis</label>
            <input type="date" class="form-control" id="tanggal_baptis" name="tanggal_baptis" value="{{ old('tanggal_baptis') }}" required>
        </div>

        <div class="mb-3">
            <label for="tempat_baptis" class="form-label">Tempat Baptis</label>
            <input type="text" class="form-control" id="tempat_baptis" name="tempat_baptis" value="{{ old('tempat_baptis') }}" required>
        </div>

        <div class="mb-3">
            <label for="pendeta_baptis" class="form-label">Pendeta Baptis</label>
            <input type="text" class="form-control" id="pendeta_baptis" name="pendeta_baptis" value="{{ old('pendeta_baptis') }}" required>
        </div>

        <div class="mb-3">
            <label for="daftar_saksi" class="form-label">Daftar Saksi (pisahkan dengan koma)</label>
            <input type="text" class="form-control" id="daftar_saksi" name="daftar_saksi" value="{{ old('daftar_saksi') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
