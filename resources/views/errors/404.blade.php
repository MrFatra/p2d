@extends('layouts.error')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <div class="h-screen flex items-center justify-center px-6 py-12">
        <div class="max-w-xl text-center">
            <div class="flex items-center justify-center">
                <dotlottie-wc src="https://lottie.host/1b6aa065-ba26-4678-869a-8f28e6ae6459/q6xxbaWgRe.lottie" class="w-200px md:w-[500px]"
                    speed="1" autoplay loop></dotlottie-wc>
            </div>

            <h1 class=" text-4xl font-extrabold">Halaman Tidak Ditemukan</h1>

            <p class="mt-4 text-lg text-gray-500">Maaf, halaman yang Anda cari tidak tersedia atau sudah dipindahkan.</p>
        </div>
    </div>
@endsection
