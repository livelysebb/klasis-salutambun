@extends('layouts.mainlayout')

@section('title', 'Edit Surat')

@section('content')
<div class="container mt-4">
    <h1>Edit Surat</h1>

    <form action="{{ route('surats.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat</label>
            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required>
            @error('nomor_surat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat->format('Y-m-d')) }}" required>
            @error('tanggal_surat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="perihal" class="form-label">Perihal</label>
            <input type="text" class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" value="{{ old('perihal', $surat->perihal) }}" required>
            @error('perihal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jenis_surat" class="form-label">Jenis Surat</label>
            <select class="form-select @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat" required>
                <option value="masuk" {{ old('jenis_surat', $surat->jenis_surat) == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                <option value="keluar" {{ old('jenis_surat', $surat->jenis_surat) == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
            </select>
            @error('jenis_surat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="pengirim_tujuan" class="form-label">Pengirim/Tujuan</label>
            <input type="text" class="form-control @error('pengirim_tujuan') is-invalid @enderror" id="pengirim_tujuan" name="pengirim_tujuan" value="{{ old('pengirim_tujuan', $surat->pengirim_tujuan) }}" required>
            @error('pengirim_tujuan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3" id="penerima-field">
            <label for="penerima" class="form-label">Penerima</label>
            <input type="text" class="form-control @error('penerima') is-invalid @enderror" id="penerima" name="penerima" value="{{ old('penerima', $surat->penerima) }}">
            @error('penerima')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jemaat_id" class="form-label">Jemaat</label>
            <select class="form-select @error('jemaat_id') is-invalid @enderror" id="jemaat_id" name="jemaat_id">
                <option value="">Pilih Jemaat</option>
                @foreach ($jemaats as $id => $nama)
                    <option value="{{ $id }}" {{ old('jemaat_id', $surat->jemaat_id) == $id ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
            @error('jemaat_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="file_surat" class="form-label">File Surat (Opsional)</label>
            @if ($surat->file_surat)
                <p>File saat ini: <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank">{{ $surat->file_surat }}</a></p>
            @endif
            <input type="file" class="form-control @error('file_surat') is-invalid @enderror" id="file_surat" name="file_surat">
            @error('file_surat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

<script>
    const jenisSuratSelect = document.getElementById('jenis_surat');
    const penerimaField = document.getElementById('penerima-field');

    jenisSuratSelect.addEventListener('change', () => {
        if (jenisSuratSelect.value === 'masuk') {
            penerimaField.style.display = 'block';
        } else {
            penerimaField.style.display = 'none';
        }
    });

    // Set initial state based on old input or default
    if ('{{ old('jenis_surat') }}' === 'masuk' || jenisSuratSelect.value === 'masuk') {
        penerimaField.style.display = 'block';
    } else {
        penerimaField.style.display = 'none';
</script>

@endsection
