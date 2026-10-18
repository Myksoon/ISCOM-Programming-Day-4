@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-1">Daftar Reservasi Sewa Moge</h2>
        <p class="text-muted mb-0">Kelola jadwal booking rental moge wilayah Surabaya & sekitarnya</p>
    </div>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary px-3 shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Booking
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>Nama Pemesan</th>
                        <th>No. HP / WA</th>
                        <th>Mulai Sewa</th>
                        <th>Selesai / Kembali</th>
                        <th>Catatan / Unit Moge</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="text-center fw-medium">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-dark">{{ $booking->nama }}</td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->no_hp) }}" target="_blank" class="text-decoration-none text-success">
                                    <i class="bi bi-whatsapp me-1"></i>{{ $booking->no_hp }}
                                </a>
                            </td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d/m/Y') }}</div>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($booking->jam)->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                @if($booking->tanggal_selesai && $booking->jam_selesai)
                                    <div>{{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d/m/Y') }}</div>
                                    <small class="text-muted"><i class="bi bi-clock-history me-1"></i>{{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }} WIB</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $booking->catatan ?? '-' }}</td>
                            <td>
                                @if($booking->status === 'menunggu')
                                    <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>
                                @elseif($booking->status === 'disewa')
                                    <span class="badge bg-primary px-2 py-1"><i class="bi bi-bicycle me-1"></i>Disewa</span>
                                @elseif($booking->status === 'delay')
                                    <span class="badge text-white px-2 py-1" style="background-color: #fd7e14;"><i class="bi bi-exclamation-triangle me-1"></i>Delay</span>
                                @elseif($booking->status === 'reschedule')
                                    <span class="badge bg-info text-dark px-2 py-1"><i class="bi bi-arrow-repeat me-1"></i>Reschedule</span>
                                @elseif($booking->status === 'selesai')
                                    <span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                                @elseif($booking->status === 'batal')
                                    <span class="badge bg-danger px-2 py-1"><i class="bi bi-x-circle me-1"></i>Batal</span>
                                @else
                                    <span class="badge bg-secondary px-2 py-1">{{ $booking->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-warning" title="Edit Booking">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Yakin hapus data?')" title="Hapus Booking">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                                Belum ada data reservasi moge saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
