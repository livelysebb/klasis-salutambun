@extends('layouts.mainlayout')

@section('title', 'Tambah Data Pernikahan')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Tambah Data Pernikahan</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('nikahs.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="anggota_jemaat_id" class="form-label">Anggota Jemaat</label>
                            <select class="form-select @error('anggota_jemaat_id') is-invalid @enderror" id="anggota_jemaat_id" name="anggota_jemaat_id" required>
                                <option value="">Pilih Anggota Jemaat</option>
                                @foreach ($anggotaJemaat as $anggota)
                                    <option value="{{ $anggota->id }}" {{ old('anggota_jemaat_id') == $anggota->id ? 'selected' : '' }}>
                                        {{ $anggota->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('anggota_jemaat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pasangan_id" class="form-label">Pasangan</label>
                            <select class="form-select @error('pasangan_id') is-invalid @enderror" id="pasangan_id" name="pasangan_id" required>
                                <option value="">Pilih Pasangan</option>
                                @foreach ($anggotaJemaat as $anggota)
                                    <option value="{{ $anggota->id }}" {{ old('pasangan_id') == $anggota->id ? 'selected' : '' }}>
                                        {{ $anggota->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pasangan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_nikah" class="form-label">Tanggal Nikah</label>
                            <input type="date" class="form-control @error('tanggal_nikah') is-invalid @enderror" id="tanggal_nikah" name="tanggal_nikah" value="{{ old('tanggal_nikah') }}" required>
                            @error('tanggal_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tempat_nikah" class="form-label">Tempat Nikah</label>
                            <input type="text" class="form-control @error('tempat_nikah') is-invalid @enderror" id="tempat_nikah" name="tempat_nikah" value="{{ old('tempat_nikah') }}" required>
                            @error('tempat_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pendeta_nikah" class="form-label">Pendeta Nikah</label>
                            <input type="text" class="form-control @error('pendeta_nikah') is-invalid @enderror" id="pendeta_nikah" name="pendeta_nikah" value="{{ old('pendeta_nikah') }}" required>
                            @error('pendeta_nikah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="catatan_nikah" class="form-label">Catatan Nikah</label>
                            <textarea class="form-control @error('catatan_nikah') is-invalid @enderror" id="catatan_nikah" name="catatan_nikah">{{ old('catatan_nikah') }}</textarea>
                            @error('catatan_nikah')
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
