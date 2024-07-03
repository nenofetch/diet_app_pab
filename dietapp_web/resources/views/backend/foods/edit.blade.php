@extends('layouts.backend.main')

@section('title', 'Edit Data Makanan')

@section('css')
<link rel="stylesheet" href="{{ asset('backend') }}/libs/select2/select2.min.css"/>
<link rel="stylesheet" href="{{ asset('backend') }}/css/select2.css"/>
<link rel="stylesheet" href="{{ asset('backend') }}/libs/summernote/summernote.min.css"/>
@endsection

@section('content')
<div class="container-fluid">
    <div class="layout-specing">
        <div class="d-md-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Makanan</h5>

            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">
                    <li class="breadcrumb-item text-capitalize"><a href="{{ route('foods.index') }}">Makanan</a></li>
                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Edit Data</li>
                </ul>
            </nav>
        </div>

        <a href="{{ route('foods.index') }}" class="btn btn-warning btn-sm mt-4"><i class="fa-solid fa-arrow-left"></i> Kembali</a>

        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="container">
                    <div class="card-body">
                        <form action="{{ route('foods.update', $food->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Makanan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Makanan" name="name" value="{{ $food->name }}" autocomplete="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Porsi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('portion') is-invalid @enderror" placeholder="Contoh: 1 Porsi" name="portion" value="{{ $food->portion }}" autocomplete="portion">
                                        @error('portion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kalori <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-7 col-sm-8 mb-2">
                                                <input name="calories" id="calories" type="text" class="form-control @error('calories') is-invalid @enderror" placeholder="Kalori" value="{{ $food->calories }}">
                                                @error('calories')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-5 col-sm-4"><p class="mt-1">kal/kkal</p></div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Protein <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-7 col-sm-8 mb-2">
                                                <input name="proteins" id="proteins" type="text" class="form-control @error('proteins') is-invalid @enderror" placeholder="Protein" value="{{ $food->proteins }}">
                                                @error('proteins')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-5 col-sm-4"><p class="mt-1">gram</p></div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Karbohidrat <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-7 col-sm-8 mb-2">
                                                <input name="carbohydrate" id="carbohydrate" type="text" class="form-control @error('carbohydrate') is-invalid @enderror" placeholder="Karbohidrat" value="{{ $food->carbohydrate }}">
                                                @error('carbohydrate')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-5 col-sm-4"><p class="mt-1">gram</p></div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lemak <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-7 col-sm-8 mb-2">
                                                <input name="fat" id="fat" type="text" class="form-control @error('fat') is-invalid @enderror" placeholder="Lemak" value="{{ $food->fat }}">
                                                @error('fat')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-5 col-sm-4"><p class="mt-1">gram</p></div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Serat <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-7 col-sm-8 mb-2">
                                                <input name="fiber" id="fiber" type="text" class="form-control @error('fiber') is-invalid @enderror" placeholder="Serat" value="{{ $food->fiber }}">
                                                @error('fiber')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-5 col-sm-4"><p class="mt-1">gram</p></div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Gula <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-7 col-sm-8 mb-2">
                                                <input name="sugar" id="sugar" type="text" class="form-control @error('sugar') is-invalid @enderror" placeholder="Gula" value="{{ $food->sugar }}">
                                                @error('sugar')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-5 col-sm-4"><p class="mt-1">gram</p></div>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" id="submit" name="send" class="btn btn-primary" value="Simpan">
                                </div><!--end col-->
                            </div><!--end row-->
                        </form><!--end form-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
</div><!--end container-->
@endsection
