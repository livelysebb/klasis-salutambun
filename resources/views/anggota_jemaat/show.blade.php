@extends('layouts.mainlayout')

@section('title', 'Detail Anggota Jemaat')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">Detail Anggota Jemaat: {{ $anggotaJemaat->nama }}</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    @if ($anggotaJemaat->foto)
                        <img src="{{ asset('storage/' . $anggotaJemaat->foto) }}" alt="Foto {{ $anggotaJemaat->nama }}" class="img-fluid rounded-start profile-picture border border-dark">
                    @else
                        <img src="{{ asset('storage/public/anggota-jemaat/foto/default-profile.jpg') }}" alt="Foto Default" class="img-fluid rounded-start profile-picture border border-dark">
                    @endif
                </div>
                <div class="col-md-8">
                    <h5 class="card-subtitle mb-2 text-muted">Informasi Umum</h5>
                    <p class="card-text"><strong>Jemaat:</strong> {{ $anggotaJemaat->jemaat->nama }}</p>
                    <p class="card-text"><strong>Jenis Kelamin:</strong> {{ $anggotaJemaat->jenis_kelamin }}</p>
                    <p class="card-text"><strong>Tempat Lahir:</strong> {{ $anggotaJemaat->tempat_lahir }}</p>
                    <p class="card-text"><strong>Tanggal Lahir:</strong> {{ $anggotaJemaat->tanggal_lahir }}</p>
                    <p class="card-text"><strong>Nama Ayah:</strong> {{ $anggotaJemaat->nama_ayah }}</p>
                    <p class="card-text"><strong>Nama Ibu:</strong> {{ $anggotaJemaat->nama_ibu }}</p>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <h5 class="card-subtitle mb-2 text-muted">Data Baptis</h5>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            @if ($baptis)
                                <tr>
                                    <th>Tanggal Baptis:</th>
                                    <td>{{ $baptis->tanggal_baptis }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Baptis:</th>
                                    <td>{{ $baptis->tempat_baptis }}</td>
                                </tr>
                                <tr>
                                    <th>Pendeta Baptis:</th>
                                    <td>{{ $baptis->pendeta_baptis }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2">Belum ada data baptis.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="card-subtitle mb-2 text-muted">Data Sidi</h5>
                    <table class="table table-striped table-bordered">
                        <tbody>
                            @if ($sidi)
                                <tr>
                                    <th>Tanggal Sidi:</th>
                                    <td>{{ $sidi->tanggal_sidi }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Sidi:</th>
                                    <td>{{ $sidi->tempat_sidi }}</td>
                                </tr>
                                <tr>
                                    <th>Pendeta Sidi:</th>
                                    <td>{{ $sidi->pendeta_sidi }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2">Belum ada data sidi.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <h5 class="card-subtitle mb-2 text-muted">Data Nikah</h5>
                    @if ($nikahs->count() > 0)
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal Nikah</th>
                                    <th>Pasangan</th>
                                    <th>Tempat Nikah</th>
                                    <th>Pendeta Nikah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nikahs as $nikah)
                                    <tr>
                                        <td>{{ $nikah->tanggal_nikah }}</td>
                                        <td>{{ $nikah->pasangan->nama }}</td>
                                        <td>{{ $nikah->tempat_nikah }}</td>
                                        <td>{{ $nikah->pendeta_nikah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Belum ada data nikah.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
