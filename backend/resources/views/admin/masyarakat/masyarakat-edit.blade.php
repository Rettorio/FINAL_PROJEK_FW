@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Masyarakat /</span> <?= $title ?></h4>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header text-end">
                        <a href="{{ route('masyarakat.index') }}" class="btn btn-warning btn-sm float-right rounded">
                            <i class="fa-solid fa-rotate-left me-1"></i> Kembali
                        </a>
                    </h5>
                    <div class="card-body">
                        <form action="{{ route('masyarakat.update', $masyarakat->id) }}" method="POST" class="row g-3 needs-validation"
                            novalidate enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label" for="nik">NIK<span class="text-danger">*</span></label>
                                <input type="text" id="nik" class="form-control @error('nik') is-invalid @enderror"
                                    placeholder="12383080131" name="nik" value="{{ old('nik') ?? $masyarakat->nik }}" required />
                                @error('nik')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="name">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="name"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    placeholder="Nama orang" name="nama_lengkap" value="{{ old('nama_lengkap') ?? $masyarakat->nama_lengkap }}"
                                    required />
                                @error('nama_lengkap')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-12 mb-4 mt-4">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" name="tanggal_lahir" value={{ old('tanggal_lahir') != null ? \Carbon\Carbon::createFromFormat('Y-m-d', old('tanggal_lahir')) : $masyarakat->tanggal_lahir }} placeholder="DD/MM/YYYY"
                                    class="form-control datepicker" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="tempat_lahir">Tempat Lahir<span
                                        class="text-danger">*</span></label>
                                <input type="text" id="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Ambon"
                                    name="tempat_lahir" value="{{ old('tempat_lahir') ?? $masyarakat->tempat_lahir }}" required />
                                @error('tempat_lahir')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="jumlah">Jenis Kelamin<span
                                        class="text-danger">*</span></label>
                                <select name="jenis_kelamin" id="jumlah"
                                    class="selectpicker w-100 @error('jenis_kelamin') is-invalid @enderror"
                                    data-style="btn-default" data-live-search="true">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    @foreach ($jk as $data)
                                        <option value="{{ $data['jenis_kelamin'] }}"
                                            {{ (old('jenis_kelamin') ?? $masyarakat->jenis_kelamin) == $data['jenis_kelamin'] ? 'selected' : null }}>
                                            {{ $data['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_kelamin')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="agama">Agama<span class="text-danger">*</span></label>
                                <select name="agama" id="agama"
                                    class="selectpicker w-100 @error('agama') is-invalid @enderror" data-style="btn-default"
                                    data-live-search="true">
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach ($agama as $data)
                                        <option value="{{ $data }}"
                                            {{ (old('agama') ?? $masyarakat->agama) == $data ? 'selected' : null }}>
                                            {{ $data }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="alamat">Alamat<span class="text-danger">*</span></label>
                                <input type="text" id="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror" placeholder="Jalan jalan"
                                    name="alamat" value="{{ old('alamat') ?? $masyarakat->alamat }}" required />
                                @error('alamat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="hidden" name="oldImage" value="{{ $masyarakat->foto }}">
                            <div class="col-md-6">
                                <label class="form-label" for="image">Foto </label>
                                <div class="img-preview mb-1">
                                    <img id="image-preview" src="/storage/{{$masyarakat->foto ?? '' }}" alt="Image Preview" width="200" height="200"
                                        class="rounded" style="{{ $masyarakat->foto != null ? "" : "display: none;"}}">
                                </div>
                                <input type="file" id="image"
                                    class="form-control @error('foto') is-invalid @enderror" placeholder="foto orang"
                                    name="foto" />
                                @error('foto')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="status">Status Kawin<span
                                        class="text-danger">*</span></label>
                                <select name="status_kawin" id="status"
                                    class="selectpicker w-100 @error('status_kawin') is-invalid @enderror"
                                    data-style="btn-default" data-live-search="true">
                                    <option value="">-- Pilih Status --</option>
                                    @foreach ($sk as $data)
                                        <option value="{{ $data }}"
                                            {{ (old('status_kawin') ?? $masyarakat->status_kawin) == $data ? 'selected' : null }}>
                                            {{ $data }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_kawin')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 text-end">
                                <button type="reset" class="btn btn-secondary btn-sm rounded"><i
                                        class="fa-solid fa-rotate me-1"></i> Reset </button>
                                <button type="submit" class="btn btn-primary btn-sm rounded"><i
                                        class="fa-solid fa-floppy-disk me-1"></i> Simpan </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                orientation: 'auto left',
                autoclose: true,
                endDate: new Date()
            });
        });
    </script>
@endsection
