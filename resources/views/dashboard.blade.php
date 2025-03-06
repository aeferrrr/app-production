@extends('layout.layout')
@section('title', 'Dashboard')
@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (Auth::user()->role === 'admin')
                        <h1>Selamat Datang Admin</h1>
                    @elseif (Auth::user()->role === 'karyawan')
                        <h1>Selamat Datang Karyawan</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
