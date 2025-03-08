@extends('layout.layout')
@section('title', 'Admin')
@section('content')

<div class="container mt-3">
    <div class="row">
        <!-- Card Total Karyawan -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body text-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="avatar bg-primary text-white p-2 rounded-circle">
                            <i class="bx bx-user fs-4"></i>
                        </div>
                        <div class="text-end">
                            <h6 class="text-muted mb-1">Total Karyawan</h6>
                            <h3 class="mb-0">{{ $jumlahKaryawan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>

@endsection
