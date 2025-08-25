@extends('layouts.error')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="h-screen flex items-center justify-center px-6 py-12">
        <div class="max-w-xl text-center">
            <div class="flex items-center justify-center">
                <dotlottie-wc src="https://lottie.host/66c89864-80bd-4039-b725-a817b2c7cfc6/qScQUN1lc1.lottie"
                    class="w-200px md:w-[500px]" speed="1" autoplay loop></dotlottie-wc>
            </div>

            <h1 class="text-4xl font-extrabold mt-6">Akses Ditolak</h1>

            <p class="mt-4 text-lg text-gray-500">
                Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini
                adalah kesalahan.
            </p>
        </div>
    </div>
@endsection
