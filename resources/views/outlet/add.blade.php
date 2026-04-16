@extends('layouts.app')

@section('title', 'Tambah Outlet')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fc; }
    .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); }
    .card-header { background-color: #ffffff; border-bottom: 1px solid #f1f1f1; font-weight: 700; color: #4e73df; padding: 1.25rem; }
    .form-label { font-size: 0.75rem; font-weight: 700; color: #4e73df; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 0.5rem; }
    .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1); }
    .text-danger { font-size: 0.75rem; font-weight: 600; }
    .btn-submit { border-radius: 10px; font-weight: 700; padding: 0.75rem 2rem; transition: all 0.3s; }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-pill px-4">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('outlet') }}" method="POST">
                @csrf
                @method('post')

                <div class="card shadow card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-store mr-2"></i>
                        <span>Informasi Cabang / Outlet</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 border-right">
                                <div class="mb-4">
                                    <label class="form-label">Kode Outlet</label>
                                    <input type="text" class="form-control text-uppercase @error('kode_outlet') is-invalid @enderror"
                                           name="kode_outlet" value="{{ old('kode_outlet') }}" placeholder="Contoh: OUT-001">
                                    @error('kode_outlet') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Nama Outlet</label>
                                    <input type="text" class="form-control text-uppercase @error('nama_outlet') is-invalid @enderror"
                                           name="nama_outlet" value="{{ old('nama_outlet') }}" placeholder="Nama Cabang">
                                    @error('nama_outlet') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control text-uppercase @error('alamat') is-invalid @enderror"
                                              name="alamat" rows="3" placeholder="Jl. Raya No. 123...">{{ old('alamat') }}</textarea>
                                    @error('alamat') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6 px-lg-4">
                                <div class="mb-4">
                                    <label class="form-label">Penanggung Jawab</label>
                                    <input type="text" class="form-control text-uppercase @error('penanggung_jawab') is-invalid @enderror"
                                           name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" placeholder="Nama Manager/SPV">
                                    @error('penanggung_jawab') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Nomor Telepon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0" style="border-radius: 10px 0 0 10px;"><i class="fas fa-phone fa-sm"></i></span>
                                        </div>
                                        <input type="number" class="form-control @error('telepon') is-invalid @enderror"
                                               style="border-radius: 0 10px 10px 0;" name="telepon" value="{{ old('telepon') }}" placeholder="08xxx">
                                    </div>
                                    @error('telepon') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-0">
                                    <label class="form-label">Status Operasional</label>
                                    <select class="form-control custom-select fw-bold @if(old('status') == 'Aktif') text-success @endif" name="status" id="statusSelect">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                                        <option value="Non Aktif" {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>🔴 Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between align-items-center py-3">
                        <a href="{{ route('outlet') }}" class="btn btn-dark fw-bold">Kembali</a>
                        <button class="btn btn-primary btn-sm btn-submit shadow" type="submit">
                            <i class="fas fa-save mr-2"></i> Simpan Data Outlet
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Penyesuaian warna teks dropdown status secara dinamis
    document.getElementById('statusSelect').addEventListener('change', function() {
        if (this.value === 'Aktif') {
            this.classList.add('text-success');
            this.classList.remove('text-danger');
        } else if (this.value === 'Non Aktif') {
            this.classList.add('text-danger');
            this.classList.remove('text-success');
        } else {
            this.classList.remove('text-success', 'text-danger');
        }
    });
</script>
@endsection
