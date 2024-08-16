@extends('layouts.mainlayout')

@section('title', 'Tambah Anggota Jemaat Baru')

@section('content')
<div class="container mt-4">
    <h1>Tambah Anggota Jemaat Baru</h1>

    <form action="{{ route('anggota-jemaat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- <div class="mb-3">
            <label for="jemaat_id" class="form-label">Jemaat</label>
            <select class="form-select" id="jemaat_id" name="jemaat_id" required>
                <option value="">Pilih Jemaat</option>
                @foreach ($jemaats as $jemaat)
                    <option value="{{ $jemaat->id }}" {{ old('jemaat_id') == $jemaat->id ? 'selected' : '' }}>
                        {{ $jemaat->nama }}
                    </option>
                @endforeach
            </select>
            @error('jemaat_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div> -->
        <div class="mb-3">
            <label for="jemaat_id" class="form-label">Jemaat</label>
            @if (auth()->user()->hasRole('admin_jemaat'))
                <input type="text" class="form-control" id="jemaat_id" value="{{ $jemaats->first()->nama }}" disabled>
                <input type="hidden" name="jemaat_id" value="{{ $jemaats->first()->id }}">
            @else
                <select class="form-select @error('jemaat_id') is-invalid @enderror" id="jemaat_id" name="jemaat_id" required>
                    <option value="">Pilih Jemaat</option>
                    @foreach ($jemaats as $jemaat) <div class="alert alert-danger">{{ $message }}</div>
                        <option value="{{ $jemaat->id }}" {{ old('jemaat_id') == $jemaat->id ? 'selected' : '' }}>{{ $jemaat->nama }}</option>
                    @endforeach
                </select>
                @error('jemaat_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
            @error('tempat_lahir')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
            @error('tanggal_lahir')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_ayah" class="form-label">Nama Ayah</label>
            <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}">
            @error('nama_ayah')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_ibu" class="form-label">Nama Ibu</label>
            <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}">
            @error('nama_ibu')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
            @error('foto')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

