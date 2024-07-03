@extends('layouts.backend.main')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="layout-specing">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted mb-1">Welcome back, {{ Auth::user()->name }}!</h6>
                <h5 class="mb-0">Dashboard</h5>
            </div>
        </div>

        <div class="row row-cols-xl-4 row-cols-md-2 row-cols-1">
            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-utensils fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Data Makanan</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span class="counter-value" data-target="{{ $foods }}"></span></span></p>
                        </div>
                    </div>
                </a>
            </div><!--end col-->

            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-pizza-slice fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Data Cemilan</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span class="counter-value" data-target="{{ $snacks }}"></span></p>
                        </div>
                    </div>
                </a>
            </div><!--end col-->

            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-coffee fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Data Minuman</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span class="counter-value" data-target="{{ $drinks }}"></span></p>
                        </div>
                    </div>
                </a>
            </div><!--end col-->

            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-dumbbell fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Data Olahraga</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span class="counter-value" data-target="{{ $sports }}"></span></p>
                        </div>
                    </div>
                </a>
            </div><!--end col-->

            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-video fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Data Edukasi</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span class="counter-value" data-target="{{ $educations }}"></span></span></p>
                        </div>
                    </div>
                </a>
            </div><!--end col-->

            <div class="col mt-4">
                <a href="#!" class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon text-center rounded-pill">
                            <i class="uil uil-users-alt fs-4 mb-0"></i>
                        </div>
                        <div class="flex-1 ms-3">
                            <h6 class="mb-0 text-muted">Data Pengguna</h6>
                            <p class="fs-5 text-dark fw-bold mb-0"><span class="counter-value" data-target="{{ $users }}"></span></span></p>
                        </div>
                    </div>
                </a>
            </div><!--end col-->
        </div><!--end row-->
    </div>
</div>
@endsection
