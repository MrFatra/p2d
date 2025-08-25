@extends('layouts.error')

@section('title', 'Terjadi Kesalahan')

@section('content')
    <div class="h-screen flex items-center justify-center px-6 py-12">
        <div class="max-w-2xl text-center">
            {{-- Lottie Animation --}}
            <div class="flex items-center justify-center">
                <dotlottie-wc src="https://lottie.host/bff79c6e-4424-4f67-aa09-4aa4234e22c2/MG9GCZGQy4.lottie"
                    class="w-200px md:w-[500px]" speed="1" autoplay loop></dotlottie-wc>
            </div>

            {{-- Judul --}}
            <h1 class="text-4xl font-extrabold mt-6">Terjadi Kesalahan</h1>

            {{-- Deskripsi --}}
            <p class="mt-4 text-lg text-gray-500">
                Maaf, saat ini terjadi gangguan pada server atau sedang dalam pemeliharaan. Silakan coba kembali beberapa
                saat lagi, atau hubungi administrator jika masalah terus berlanjut.
            </p>
        </div>
    </div>
@endsection
