@extends('layouts.app')

@section('title', 'Tambah Data Supplier')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fc; }
    .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); }
    .card-header { background-color: #ffffff; border-bottom: 1px solid #f1f1f1; font-weight: 700; color: #4e73df; padding: 1.25rem; }
    .form-label { font-size: 0.75rem; font-weight: 700; color: #4e73df; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 0.5rem; }
    .form-control {
        border-radius: 10px;
        padding: 0.6rem 1rem;
        border: 1px solid #d1d3e2;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1); }
    .input-group-text { border-radius: 10px 0 0 10px; background-color: #f8f9fc; border-right: none; color: #b7b9cc; }
    .has-icon .form-control { border-radius: 0 10px 10px 0; }
    .text-danger { font-size: 0.75rem; font-weight: 600; }
    .btn-primary { border-radius: 10px; font-weight: 700; padding: 0.75rem; transition: all 0.3s; }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6"> <form action="{{ route('supplier') }}" method="POST">
                @csrf
                @method('POST')

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="fas fa-truck me-2"></i>
                        <span>Pendaftaran Supplier Baru</span>
                    </div>
                    <div class="card-body p-4">

                        <div class="mb-4">
                            <label for="nama_supplier" class="form-label">Nama Perusahaan / Supplier</label>
                            <div class="input-group has-icon">
                                <span class="input-group-text"><i class="fas fa-building fa-sm"></i></span>
                                <input type="text"
                                       class="form-control text-uppercase @error('nama_supplier') is-invalid @enderror"
                                       name="nama_supplier" id="nama_supplier"
                                       value="{{ old('nama_supplier') }}"
                                       placeholder="CONTOH: PT. SUMBER MAKMUR"
                                       autocomplete="off">
                            </div>
                            @error('nama_supplier')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @else
                                <small class="text-muted" style="font-size: 0.7rem;">Nama lengkap badan usaha atau perorangan</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="no_hp" class="form-label">Nomor Telepon / WhatsApp</label>
                            <div class="input-group has-icon">
                                <span class="input-group-text"><i class="fas fa-phone-alt fa-sm"></i></span>
                                <input type="number"
                                       class="form-control @error('no_hp') is-invalid @enderror"
                                       name="no_hp" id="no_hp"
                                       value="{{ old('no_hp') }}"
                                       placeholder="08123456xxxx"
                                       autocomplete="off">
                            </div>
                            @error('no_hp') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="alamat" class="form-label">Alamat Kantor</label>
                            <div class="input-group has-icon">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt fa-sm"></i></span>
                                <textarea class="form-control text-uppercase @error('alamat') is-invalid @enderror"
                                          name="alamat" id="alamat" rows="3"
                                          placeholder="ALAMAT LENGKAP SUPPLIER..."
                                          autocomplete="off">{{ old('alamat') }}</textarea>
                            </div>
                            @error('alamat') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Supplier
                            </button>
                            <a href="{{ route('supplier') }}" class="btn btn-link w-100 text-muted mt-2 small text-decoration-none">Batal & Kembali</a>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
