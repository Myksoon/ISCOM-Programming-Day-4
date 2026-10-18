@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="card-title fw-bold mb-0">
                    <i class="bi bi-calendar-plus me-2 text-warning"></i>Tambah Reservasi Booking Baru
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Pemesan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-semibold">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-3 border">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-calendar-event me-1"></i>Jadwal Mulai Sewa</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="tanggal" class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="jam" class="form-label fw-semibold">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="time" name="jam" id="jam" class="form-control @error('jam') is-invalid @enderror" value="{{ old('jam') }}" required>
                                @error('jam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-3 border">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-calendar-check me-1"></i>Jadwal Selesai / Dikembalikan</h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Dikembalikan <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="jam_selesai" class="form-label fw-semibold">Jam Dikembalikan <span class="text-danger">*</span></label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai') }}" required>
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-semibold">Catatan / Pilihan Moge (Opsional)</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror" placeholder="Contoh: Kawasaki ZX-6R, request 2 helm full face">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
