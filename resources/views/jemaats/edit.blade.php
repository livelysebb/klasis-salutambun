@extends('layouts.mainlayout')

@section('title', 'Edit Jemaat')

@section('content')
<div class="container mt-4">
    <h1>Edit Jemaat</h1>

    <form action="{{ route('jemaats.update', $jemaat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $jemaat->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat', $jemaat->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $jemaat->telepon) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $jemaat->email) }}">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    @error('nama_kolom')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
@endsection
