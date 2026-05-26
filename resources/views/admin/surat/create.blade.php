@extends('layouts.admin')

@section('title', 'Tambah Surat')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="stat-card">
    <h6 class="fw-bold mb-3">Buat Surat Baru</h6>

    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.surat.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label small fw-bold">Cari Penduduk (NIK/Nama)</label>
            <input type="text" id="searchPenduduk" class="form-control" placeholder="Ketik NIK atau nama...">
            <input type="hidden" name="penduduk_id" id="pendudukId">
            <div id="searchResults" class="list-group mt-1" style="display:none;"></div>
            <div id="selectedPenduduk" class="alert alert-info small mt-2" style="display:none;"></div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Jenis Surat</label>
            <select name="jenis_surat" class="form-select" required>
                <option value="">-- Pilih Jenis Surat --</option>
                @foreach($jenisSurat as $key => $label)
                    <option value="{{ $key }}" {{ old('jenis_surat') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Isi Surat</label>
            <textarea name="isi_surat" class="form-control" rows="8" placeholder="Isi/konten surat..." required>{{ old('isi_surat') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill">
            <i class="bi bi-check-lg"></i> Buat & Terbitkan Surat
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
let searchTimeout;
const searchInput = document.getElementById('searchPenduduk');
const searchResults = document.getElementById('searchResults');
const pendudukId = document.getElementById('pendudukId');
const selectedDiv = document.getElementById('selectedPenduduk');

searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value;

    if (query.length < 2) {
        searchResults.style.display = 'none';
        return;
    }

    searchTimeout = setTimeout(() => {
        fetch(`{{ route('admin.penduduk.search') }}?q=${query}`)
            .then(res => res.json())
            .then(data => {
                searchResults.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        searchResults.innerHTML += `
                            <a href="#" class="list-group-item list-group-item-action small"
                               onclick="selectPenduduk(${item.id}, '${item.nama}', '${item.nik}', '${item.alamat}')">
                                <strong>${item.nama}</strong> - ${item.nik}<br>
                                <small class="text-muted">${item.alamat}</small>
                            </a>
                        `;
                    });
                    searchResults.style.display = 'block';
                } else {
                    searchResults.innerHTML = '<div class="list-group-item small text-muted">Tidak ditemukan</div>';
                    searchResults.style.display = 'block';
                }
            });
    }, 300);
});

function selectPenduduk(id, nama, nik, alamat) {
    pendudukId.value = id;
    selectedDiv.innerHTML = `<strong>${nama}</strong> (${nik})<br>${alamat}`;
    selectedDiv.style.display = 'block';
    searchResults.style.display = 'none';
    searchInput.value = nama;
}
</script>
@endpush
