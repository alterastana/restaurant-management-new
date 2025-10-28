@extends('Dashboard.layout.master')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Member Loyalty</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/Dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Dashboard.loyalty.index') }}">Loyalty Members</a></li>
        <li class="breadcrumb-item active">Tambah Member</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-plus me-1"></i>
                    Form Tambah Member Loyalty
                </div>
                <div>
                    <a href="{{ route('Dashboard.loyalty.index') }}" class="btn btn-dark btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('Dashboard.loyalty.store') }}" method="POST" id="loyaltyForm" class="needs-validation" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-id-card me-1"></i>Customer ID
                            </label>
                            <div class="input-group">
                                <input type="number" name="customer_id" id="customer_id" 
                                    class="form-control @error('customer_id') is-invalid @enderror" 
                                    required placeholder="Masukkan ID Customer"
                                    value="{{ old('customer_id') }}">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-search"></i>
                                </span>
                                <div class="invalid-feedback">
                                    Silakan masukkan Customer ID yang valid
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-coins me-1"></i>Points
                            </label>
                            <input type="number" name="points" 
                                class="form-control @error('points') is-invalid @enderror" 
                                required placeholder="Masukkan jumlah points"
                                value="{{ old('points') }}">
                            <div class="invalid-feedback">
                                Points harus minimal 0
                            </div>
                        </div>
                    </div>
                </div>

                <div id="loyalty-info" class="card bg-light mb-4" style="display:none;">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fas fa-info-circle me-1"></i>Informasi Member
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status Member</label>
                                    <input type="text" id="membership_level" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Points Saat Ini</label>
                                    <input type="text" id="points_info" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('Dashboard.loyalty.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerIdInput = document.getElementById('customer_id');
    const infoCard = document.getElementById('loyalty-info');
    const membershipInput = document.getElementById('membership_level');
    const pointsInput = document.getElementById('points_info');

    if (!customerIdInput) return;

    customerIdInput.addEventListener('change', async function() {
        const customerId = this.value;

        if (!customerId) {
            infoCard.style.display = 'none';
            membershipInput.value = '';
            pointsInput.value = '';
            return;
        }

        // show basic loading state
        infoCard.style.display = 'block';
        membershipInput.value = 'Mencari...';
        pointsInput.value = '...';

        try {
            const response = await fetch("{{ route('Dashboard.loyalty.check') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ customer_id: customerId })
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();

            membershipInput.value = data.membership_level ?? 'Tidak tersedia';
            pointsInput.value = data.points ?? 0;

        } catch (err) {
            membershipInput.value = '';
            pointsInput.value = '';
            infoCard.style.display = 'block';
            // show error message inside card-body
            const body = infoCard.querySelector('.card-body');
            if (body) {
                body.innerHTML = '<div class="alert alert-warning mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Data member tidak ditemukan</div>';
            }
            console.error(err);
        }
    });
});
</script>

@endsection
