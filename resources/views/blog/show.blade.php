<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- Judul halaman dinamis sesuai judul post --}}
    <title>{{ $blog->title }} - {{ config('app.name') }}</title>

    {{-- Deskripsi dinamis, bisa mengambil potongan konten --}}
    <meta name="description" content="{{ Str::limit(strip_tags($blog->content), 150) }}" />

    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    <style>
        html { scroll-behavior: smooth; }
        .blob-effect { filter: blur(100px); opacity: 0.3; }
        .text-gradient {
            background-image: linear-gradient(to right, #007bff, #00c6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        /* Tambahkan style untuk konten blog agar lebih mudah dibaca */
        .prose {
            line-height: 1.75;
        }
        body{
            background-color: #fff;
        }
        .prose h2 {
            font-size: 1.875rem;
            margin-top: 2em;
            margin-bottom: 1em;
            font-weight: 700;
        }
        .prose p {
            margin-bottom: 1.25em;
        }
        .prose a {
            color: #2563eb;
            text-decoration: underline;
        }
        .prose img {
            width: 320px;
            border-radius: 0.75rem;
            margin-top: 2em;
            margin-bottom: 2em;
        }
    </style>
</head>

<body class="font-sans text-gray-800 overflow-x-hidden bg-white">
    {{-- Efek Latar Belakang (diambil dari welcome.blade.php) --}}


    <div class="container mx-auto px-4 relative z-10">
        {{-- HEADER (diambil dari welcome.blade.php) --}}
        <header id="main-header" style="position:fixed; left:0; right:0" class="flex justify-between items-center py-6 sticky px-6 top-0 z-50 transition-all duration-300 ease-in-out bg-white/80 shadow-md backdrop-blur-md">
            <a href="/" class="logo text-2xl font-bold text-gray-900 flex items-center">
                <span class="text-blue-500 mr-2 text-3xl leading-none">•</span>
                {{ config('app.name') }}
            </a>
            <nav class="hidden md:block">
                <ul class="flex space-x-8">
                    {{-- Ubah link agar mengarah ke homepage --}}
                    <li><a href="/#tentang-kami" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg">Tentang Kami</a></li>
                    <li><a href="/#sponsor" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg">Sponsor</a></li>
                    <li><a href="/#lokasi" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg">Lokasi</a></li>
                    <li><a href="/#blog" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg">Blog</a></li>
                    <li><a href="/#contact-footer" class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg">Kontak</a></li>
                </ul>
            </nav>
            <a href="/login" class="hidden md:flex items-center bg-gray-900 text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                <span class="text-blue-500 mr-2 text-xl">•</span> Masuk
            </a>
            <button class="md:hidden text-gray-800 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </header>

        {{-- Mobile Menu (diambil dari welcome.blade.php) --}}
        <div id="mobile-menu" class="hidden md:hidden fixed top-0 left-0 w-full h-screen bg-white z-50 flex flex-col items-center justify-center space-y-6">
            <button class="absolute top-6 right-4 text-gray-800 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <a href="/#tentang-kami" class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2" onclick="document.getElementById('mobile-menu').classList.add('hidden')">Tentang Kami</a>
            <a href="/#acara" class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2" onclick="document.getElementById('mobile-menu').classList.add('hidden')">Acara</a>
            <a href="/#blog" class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2" onclick="document.getElementById('mobile-menu').classList.add('hidden')">Blog</a>
            <a href="/login" class="md:flex items-center bg-gray-900 text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                <span class="text-blue-500 mr-2 text-xl">•</span> Masuk
            </a>
        </div>


    </div>
     <article class="pt-[6em] bg-white/70 backdrop-blur-sm   ">

                <!-- Thumbnail Blog -->
                @if($blog->thumbnail)
                    <img class="mx-auto h-auto w-full max-h-[320px] object-cover mb-8 shadow-md" src="{{ asset('storage/' . $blog->thumbnail) }}" alt="Thumbnail for {{ $blog->title }}">
                @endif

                <!-- Judul dan Meta Info -->
                <header class="mb-8 text-center">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">{{ $blog->title }}</h1>
                    <div class="text-md text-gray-600">
                        <span>Dipublikasikan pada {{ $blog->created_at ? $blog->created_at->format('d F Y') : $blog->created_at->format('d F Y') }}</span>
                        @if($blog->user)
                            <span class="mx-2">&bull;</span>
                            <span>Oleh {{ $blog->user->name }}</span>
                        @endif
                    </div>
                </header>

                <!-- Konten Blog -->
                <div class="prose prose-lg max-w-none text-gray-700 px-10">
                    {{-- Menggunakan nl2br untuk menghormati baris baru dari textarea sederhana --}}
                    {!! nl2br(e($blog->content)) !!}
                </div>

                <!-- Tombol Kembali ke Halaman Blog Utama -->
                <div class="mt-12 pt-8 border-t border-gray-200 text-center">
                    <a href="/blogs" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-full font-bold hover:bg-blue-700 transition duration-300 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali ke Blog
                    </a>
                </div>
            </article>

    {{-- FOOTER (diambil dari welcome.blade.php) --}}
    {{-- Anda bisa meletakkan kode footer Anda di sini jika ada, atau include dari file terpisah --}}
    {{-- Contoh: @include('layouts.partials.footer') --}}

    @livewireScripts


</body>
</html>
