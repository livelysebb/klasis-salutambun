@extends('layouts.mainlayout')

@section('title', 'Edit Anggota Jemaat')

@section('content')
<div class="container mt-4">
    <h1>Edit Anggota Jemaat</h1>

    <form action="{{ route('anggota-jemaat.update', $anggotaJemaat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $anggotaJemaat->nama }}" required>
            @error('nama')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jemaat_id" class="form-label">Jemaat</label>
            <select class="form-select" id="jemaat_id" name="jemaat_id" required>
                @foreach ($jemaats as $jemaat)
                    <option value="{{ $jemaat->id }}" {{ $jemaat->id == $anggotaJemaat->jemaat_id ? 'selected' : '' }}>
                        {{ $jemaat->nama }}
                    </option>
                @endforeach
            </select>
            @error('jemaat_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Laki-laki" {{ $anggotaJemaat->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $anggotaJemaat->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $anggotaJemaat->tempat_lahir }}">
            @error('tempat_lahir')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $anggotaJemaat->tanggal_lahir }}">
            @error('tanggal_lahir')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_ayah" class="form-label">Nama Ayah</label>
            <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ $anggotaJemaat->nama_ayah }}">
            @error('nama_ayah')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama_ibu" class="form-label">Nama Ibu</label>
            <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ $anggotaJemaat->nama_ibu }}">
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
            @if ($anggotaJemaat->foto)
                <img src="{{ asset('storage/' . $anggotaJemaat->foto) }}" alt="Foto Saat Ini" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

</div>
@endsection
