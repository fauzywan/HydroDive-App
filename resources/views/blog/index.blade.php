<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog - {{ config('app.name') }}</title>

    <meta name="description" content="Kumpulan artikel, berita, dan tips terbaru dari {{ config('app.name') }}." />

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
    </style>
</head>

<body class="font-sans text-gray-800 overflow-x-hidden bg-gray-50">
    {{-- Efek Latar Belakang --}}
    <div class="absolute inset-0 overflow-hidden z-0 pointer-events-none">
        <div class="absolute w-96 h-96 rounded-full bg-blue-300 top-[-50px] right-[-50px] blob-effect"></div>
        <div class="absolute w-80 h-80 rounded-full bg-blue-200 bottom-[-30px] left-[-30px] blob-effect"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        {{-- HEADER --}}
        <header id="main-header" style="position:fixed; left:0; right:0" class="flex justify-between items-center py-6 sticky px-6 top-0 z-50 transition-all duration-300 ease-in-out">
            <a href="/" class="logo text-2xl font-bold text-gray-900 flex items-center">
                <span class="text-blue-500 mr-2 text-3xl leading-none">•</span>
                {{ config('app.name') }}
            </a>
            <nav class="hidden md:block">
                <ul class="flex space-x-8">
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

        {{-- Mobile Menu --}}
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

        {{-- KONTEN UTAMA DAFTAR BLOG --}}
        <main class="pt-32 pb-16">
            <div class="max-w-6xl mx-auto">
                <header class="text-center mb-12">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Semua Artikel <span class="text-gradient">Blog</span></h1>
                    <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                        Dapatkan informasi terbaru seputar dunia renang, tips pelatihan, berita event, dan kisah inspiratif dari komunitas kami.
                    </p>
                </header>

                {{-- Grid untuk menampilkan semua post blog --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($blogs as $blog)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col group">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="block">
                                <img src="{{ $blog->thumbnail ? asset('storage/' . $blog->thumbnail) : 'https://via.placeholder.com/400x250' }}" alt="Thumbnail untuk {{ $blog->title }}" class="w-full h-48 object-cover">
                            </a>
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="hover:text-blue-600 transition-colors duration-300">
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-700 text-base mb-4 flex-grow">
                                    {{ Str::limit(strip_tags($blog->content), 100) }}
                                </p>
                                <div class="mt-auto">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="inline-flex items-center text-blue-600 group-hover:text-blue-800 font-semibold text-sm">
                                        Baca Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16">
                            <p class="text-xl text-gray-500">Belum ada artikel yang dipublikasikan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>

    </div>

    {{-- Anda bisa memasukkan footer di sini jika diperlukan --}}

    @livewireScripts

    <script>
        // Script untuk header transparan saat di atas
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('main-header');
            function handleScroll() {
                if (window.scrollY > 0) {
                    header.classList.add('bg-white/80', 'shadow-md', 'backdrop-blur-md');
                } else {
                    header.classList.remove('bg-white/80', 'shadow-md', 'backdrop-blur-md');
                }
            }
            window.addEventListener('scroll', handleScroll);
            handleScroll();
        });
    </script>
</body>
</html>
