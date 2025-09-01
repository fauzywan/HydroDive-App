<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      {{ config('app.name') }}
    </title>
    <meta
      name="description"
      content="Situs resmi Hydrodive, asosiasi renang terkemuka yang mewadahi berbagai acara renang. Kelola pendaftaran, pelaksanaan event, dan akses laporan kompetisi dengan mudah."
    />
        <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    <style>
      /* Optional: Custom scroll behavior for smooth scrolling */
      html {
        scroll-behavior: smooth;
      }
      svg {
    width: 24px;   /* Atur lebar yang Anda inginkan, misalnya 24 piksel */
    height: 24px;  /* Atur tinggi yang sama untuk menjaga rasio aspek */
    display: inline-block; /* Penting untuk perilaku yang benar dalam teks */
    vertical-align: middle; /* Untuk menyelaraskan dengan teks jika digunakan di samping teks */
}

/* Jika Anda ingin ukuran yang berbeda untuk ikon tertentu,
   berikan kelas pada elemen <a> atau SVG itu sendiri */
    .medsos-icon svg path{

    }
    .medsosList svg {
    stroke:#fff !important;
    color:#fff !important;
    width: 32px;
    height: 32px;
}

/* Contoh jika Anda ingin SVG selalu mengisi lebar container-nya */
.container-for-svg {
    width: 32px;
    height: 32px; /* Atur tinggi jika Anda ingin kotak yang ketat */
}

.container-for-svg svg {
    width: 100%;  /* SVG akan mengisi 100% lebar container */
    height: 100%; /* SVG akan mengisi 100% tinggi container */
}

      /* Optional: Custom styles that Tailwind might not directly cover or for specific overrides */
      .gradient-bg {
        background: linear-gradient(
          to right,
          #007bff,
          #00c6ff
        ); /* Biru cerah ke biru muda */
      }
      .text-gradient {
        background-image: linear-gradient(to right, #007bff, #00c6ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      }
      .blob-effect {
        filter: blur(100px);
        opacity: 0.3;
      }
    </style>
  </head>

  <body class="font-sans text-gray-800 overflow-x-hidden">
    <div class="absolute inset-0 overflow-hidden z-0 pointer-events-none">
      <div
        class="absolute w-96 h-96 rounded-full bg-blue-300 top-[-50px] right-[-50px] blob-effect"
      ></div>
      <div
        class="absolute w-80 h-80 rounded-full bg-blue-200 bottom-[-30px] left-[-30px] blob-effect"
      ></div>
      <div
        class="absolute w-72 h-72 rounded-full bg-blue-100 top-1/4 left-1/3 blob-effect"
      ></div>
      <div
        class="absolute w-96 h-96 rounded-full bg-blue-300 bottom-1/5 right-1/4 blob-effect"
      ></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
      <header id="main-header"  style="position:fixed; left:0; right:0"class="flex justify-between  items-center py-6 sticky px-6 top-0 z-50 transition-all duration-300 ease-in-out">
        <div
          class="logo text-2xl font-bold text-gray-900 flex items-center animate-fade-in"
        >
          <span class="text-blue-500 mr-2 text-3xl leading-none">•</span>
         {{ config('app.name') }}
        </div>
        <nav class="hidden md:block">
          <ul class="flex space-x-8">
            <li>
              <a
                href="#tentang-kami"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg"
                >Tentang Kami</a
              >
            </li>
            <li>
              <a
                href="#sponsor"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg"
                >Sponsor</a
              >
            </li>
            <li>
              <a
                href="#lokasi"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg"
                >Lokasi</a
              >
            </li>
            <li>
              <a
                href="#sejarah"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg"
                >Sejarah</a
              >
            </li>
            <li>
              <a
                href="#blog"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg"
                >Blog</a
              >
            </li>
            <li>
              <a
                href="#contact-footer"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-300 font-semibold text-lg"
                >Kontak</a
              >
            </li>
          </ul>
        </nav>
        <a
          href="/login"
          class="hidden md:flex items-center bg-gray-900 text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-700 transition-all duration-300 shadow-lg transform hover:scale-105 animate-fade-in"
        >
          <span class="text-blue-500 mr-2 text-xl">•</span> Masuk
        </a>
        <button
          class="md:hidden text-gray-800 focus:outline-none"
          onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
        >
          <svg
            class="w-8 h-8"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
        </button>
      </header>

      <div
        id="mobile-menu"
        class="hidden md:hidden fixed top-0 left-0 w-full h-screen bg-white z-50 flex flex-col items-center justify-center space-y-6"
      >
        <button
          class="absolute top-6 right-4 text-gray-800 focus:outline-none"
          onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
        >
          <svg
            class="w-8 h-8"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            ></path>
          </svg>
        </button>
        <a
          href="#tentang-kami"
          class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2"
          onclick="document.getElementById('mobile-menu').classList.add('hidden')"
          >Tentang Kami</a
        >
        <a
          href="#acara"
          class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2"
          onclick="document.getElementById('mobile-menu').classList.add('hidden')"
          >Acara</a
        >
        <a
          href="#sponsor"
          class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2"
          onclick="document.getElementById('mobile-menu').classList.add('hidden')"
          >Sponsor</a
        >
        <a
          href="#lokasi"
          class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2"
          onclick="document.getElementById('mobile-menu').classList.add('hidden')"
          >Lokasi</a
        >
        <a
          href="#sejarah"
          class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2"
          onclick="document.getElementById('mobile-menu').classList.add('hidden')"
          >Sejarah</a
        >
        <a
          href="#blog"
          class="text-gray-800 hover:text-blue-600 text-2xl font-bold py-2"
          onclick="document.getElementById('mobile-menu').classList.add('hidden')"
          >Blog</a
        >
       <a
          href="/login"
          class=" md:flex items-center bg-gray-900 text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-700 transition-all duration-300 shadow-lg transform hover:scale-105 animate-fade-in"
        >
          <span class="text-blue-500 mr-2 text-xl">•</span> Masuk
        </a>
      </div>

      <section
        class=" pt-[10em] flex flex-col md:flex-row items-center justify-between py-20 min-h-[600px]"
      >
        <div
          class="md:w-1/2 text-center md:text-left mb-10 md:mb-0 pr-0 md:pr-12"
        >
          <h1
            class="text-5xl md:text-6xl font-extrabold leading-tight text-gray-900 mb-6"
          >
          {{ $section['hero']['judul'] }}
          @if($section['hero']['appName']!="")
          <span class="text-gradient">{{$section['hero']['appName']}}</span>
          @endif
          </h1>
          <p class="text-lg md:text-xl text-gray-600 mb-8">
          {{ $section['hero']['deskripsi'] }}

        </p>
        <a
        href="/register"
            class="inline-flex items-center bg-blue-600 text-white px-8 py-4 rounded-full text-xl font-bold hover:bg-blue-700 transition duration-300 shadow-lg"
            >
            Daftar Sekarang
            <svg
            class="w-5 h-5 ml-3"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
              >
              <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M14 5l7 7m0 0l-7 7m7-7H3"
              ></path>
            </svg>
          </a>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div
            class="w-full max-w-lg h-[450px] bg-white rounded-3xl shadow-xl flex justify-center items-center overflow-hidden"
            >
            <img
            src="{{ $section['hero']['img'] }}"
            alt="Ilustrasi Renang Hydrodive"
            class="w-full h-full object-cover rounded-3xl"
            />
          </div>
        </div>
    </section>

    <section
    id="tentang-kami"
    class="bg-white p-8 md:p-12 rounded-3xl shadow-lg mb-8 text-center"
    >
    <h2 class="text-4xl font-extrabold text-gray-900 mb-10">
        {{ $section['tentang_kami']['judul'] }}<span class="text-gradient">  {{ $section['tentang_kami']['appName'] }} </span>

    </h2>
    <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
         {{ $section['tentang_kami']['deskripsi'] }}

        </p>
        <div
          class="flex flex-col md:flex-row items-center gap-10 text-left max-w-5xl mx-auto"
        >
          <div class="md:w-1/2 min-w-[300px]">
            <img
              src="{{ $section['visi_misi']['img'] }}"
              alt="Tim Hydrodive"
              class="w-full h-auto rounded-2xl shadow-md"
            />
          </div>
          <div class="md:w-1/2 pr-0 md:pr-5">
            <h3 class="text-3xl font-bold text-gray-900 mb-4">
             {{ $section['visi_misi']['judul'] }}
            </h3>
            <p class="text-gray-700 text-lg mb-6">

                {{ $section['visi_misi']['visi'] }}
            </p>
            <ul class="list-none space-y-4 text-gray-700 text-lg">
                @foreach ($section['visi_misi']['misi']['items'] as $misi)

                <li class="flex items-start">
                  <span class="text-blue-500 text-2xl mr-3">{{$section['visi_misi']['misi']['icon']}}</span> {{ $misi }}
                </li>

                @endforeach
            </ul>
          </div>
        </div>

    </section>
    <section>
        <div
            class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 max-w-4xl mx-auto"
            >
            @foreach ($section['moto']['cards'] as $item)

            <div
            class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300"
            >
            <span class="text-5xl mb-4 inline-block">{{$item['icon_emoji']}}</span>
                <h4 class="text-xl font-bold text-gray-900 mb-2">
                    {{$item['title']}}
                </h4>
                <p class="text-gray-600 text-sm">
                    {{$item['description']}}
                </p>
            </div>
            @endforeach

        </div>
    </section>
      {{-- <section
        id="acara"
        class="bg-white p-8 md:p-12 rounded-3xl shadow-lg mb-8 text-center"
      >
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10">
          Acara <span class="text-gradient">Mendatang</span>
        </h2>
        <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
          Bersiaplah untuk kompetisi dan acara renang yang menarik! Daftarkan
          diri Anda dan jadilah bagian dari keseruan Hydrodive.
        </p>
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto"
        >
          <div
            class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col animated-element animate-slideInUp"
          >
            <div
              class="relative h-48 bg-cover bg-center"
              style="
                background-image: url('https://images.unsplash.com/photo-1630049038179-afaaebb62fe2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fHN3aW1taW5nfGVufDB8fDB8fHwy');
              "
            >
              <div
                class="absolute inset-0 bg-gradient-to-t from-blue-700 to-transparent opacity-80"
              ></div>
              <div
                class="absolute bottom-4 left-4 text-white text-sm font-semibold bg-blue-600 px-3 py-1 rounded-full shadow-md"
              >
                Highlight Event
              </div>
            </div>
            <div class="p-6 flex-grow text-left">
              <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
                Kejuaraan Renang Nasional Hydrodive 2025
              </h3>
              <p class="text-gray-700 mb-4 text-base line-clamp-3">
                Kompetisi tingkat nasional untuk seluruh kategori usia. Jadikan
                diri Anda juara dengan berpartisipasi dalam ajang bergengsi ini!
              </p>
              <div class="text-base text-gray-600 space-y-2 mb-4">
                <p class="flex items-center">
                  <svg
                    class="w-5 h-5 mr-3 text-blue-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                    ></path>
                  </svg>
                  <span class="font-semibold">15 - 17 Agustus 2025</span>
                </p>
                <p class="flex items-center">
                  <svg
                    class="w-5 h-5 mr-3 text-blue-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                  <span class="font-semibold"
                    >Stadion Akuatik Senayan, Jakarta</span
                  >
                </p>
              </div>
            </div>
            <div class="p-6 pt-0 text-left">
              <a
                href="#"
                class="inline-flex items-center bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition duration-300 text-base shadow-md"
              >
                Daftar Sekarang
                <svg
                  class="w-5 h-5 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 8l4 4m0 0l-4 4m4-4H3"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
          <div
            class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col animated-element animate-slideInUp"
          >
            <div
              class="relative h-48 bg-cover bg-center"
              style="
                background-image: url('https://images.unsplash.com/photo-1630049038179-afaaebb62fe2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fHN3aW1taW5nfGVufDB8fDB8fHwy');
              "
            >
              <div
                class="absolute inset-0 bg-gradient-to-t from-blue-700 to-transparent opacity-80"
              ></div>
              <div
                class="absolute bottom-4 left-4 text-white text-sm font-semibold bg-blue-600 px-3 py-1 rounded-full shadow-md"
              >
                Highlight Event
              </div>
            </div>
            <div class="p-6 flex-grow text-left">
              <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
                Kejuaraan Renang Nasional Hydrodive 2025
              </h3>
              <p class="text-gray-700 mb-4 text-base line-clamp-3">
                Kompetisi tingkat nasional untuk seluruh kategori usia. Jadikan
                diri Anda juara dengan berpartisipasi dalam ajang bergengsi ini!
              </p>
              <div class="text-base text-gray-600 space-y-2 mb-4">
                <p class="flex items-center">
                  <svg
                    class="w-5 h-5 mr-3 text-blue-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                    ></path>
                  </svg>
                  <span class="font-semibold">15 - 17 Agustus 2025</span>
                </p>
                <p class="flex items-center">
                  <svg
                    class="w-5 h-5 mr-3 text-blue-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                  <span class="font-semibold"
                    >Stadion Akuatik Senayan, Jakarta</span
                  >
                </p>
              </div>
            </div>
            <div class="p-6 pt-0 text-left">
              <a
                href="#"
                class="inline-flex items-center bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition duration-300 text-base shadow-md"
              >
                Daftar Sekarang
                <svg
                  class="w-5 h-5 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 8l4 4m0 0l-4 4m4-4H3"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
          <div
            class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col animated-element animate-slideInUp"
          >
            <div
              class="relative h-48 bg-cover bg-center"
              style="
                background-image: url('https://images.unsplash.com/photo-1630049038179-afaaebb62fe2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MjB8fHN3aW1taW5nfGVufDB8fDB8fHwy');
              "
            >
              <div
                class="absolute inset-0 bg-gradient-to-t from-blue-700 to-transparent opacity-80"
              ></div>
              <div
                class="absolute bottom-4 left-4 text-white text-sm font-semibold bg-blue-600 px-3 py-1 rounded-full shadow-md"
              >
                Highlight Event
              </div>
            </div>
            <div class="p-6 flex-grow text-left">
              <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
                Kejuaraan Renang Nasional Hydrodive 2025
              </h3>
              <p class="text-gray-700 mb-4 text-base line-clamp-3">
                Kompetisi tingkat nasional untuk seluruh kategori usia. Jadikan
                diri Anda juara dengan berpartisipasi dalam ajang bergengsi ini!
              </p>
              <div class="text-base text-gray-600 space-y-2 mb-4">
                <p class="flex items-center">
                  <svg
                    class="w-5 h-5 mr-3 text-blue-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                    ></path>
                  </svg>
                  <span class="font-semibold">15 - 17 Agustus 2025</span>
                </p>
                <p class="flex items-center">
                  <svg
                    class="w-5 h-5 mr-3 text-blue-500"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                  <span class="font-semibold"
                    >Stadion Akuatik Senayan, Jakarta</span
                  >
                </p>
              </div>
            </div>
            <div class="p-6 pt-0 text-left">
              <a
                href="#"
                class="inline-flex items-center bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition duration-300 text-base shadow-md"
              >
                Daftar Sekarang
                <svg
                  class="w-5 h-5 ml-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 8l4 4m0 0l-4 4m4-4H3"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <a
          href="#"
          class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mt-12 text-lg"
        >
          Lihat Semua Acara
          <svg
            class="w-5 h-5 ml-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 8l4 4m0 0l-4 4m4-4H3"
            ></path>
          </svg>
        </a>
      </section> --}}

      {{-- <section
        id="sponsor"
        class="bg-gray-100 p-8 md:p-12 rounded-3xl shadow-lg mb-8 text-center"
      >
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10">
          Mitra <span class="text-gradient">Sponsor</span> Kami
        </h2>
        <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
          Dukungan dari para sponsor kami sangat berharga dalam mewujudkan visi
          Hydrodive dan menyelenggarakan event renang berkualitas.
        </p>
        <div
          class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 justify-items-center items-center max-w-5xl mx-auto"
        >
          <div
            class="p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 flex justify-center items-center"
          >
            <img
              src="C:\Users\iwanf\Downloads\Group 207@2x.png"
              alt="Brand Sport"
              class="max-w-[120px] h-auto opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </div>
          <div
            class="p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 flex justify-center items-center"
          >
            <img
              src="C:\Users\iwanf\Downloads\Group 207@2x.png"
              alt="Bank Nasional"
              class="max-w-[120px] h-auto opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </div>
          <div
            class="p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 flex justify-center items-center"
          >
            <img
              src="C:\Users\iwanf\Downloads\Group 207@2x.png"
              alt="Air Mineral"
              class="max-w-[120px] h-auto opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </div>
          <div
            class="p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 flex justify-center items-center"
          >
            <img
              src="C:\Users\iwanf\Downloads\Group 207@2x.png"
              alt="Media Partner"
              class="max-w-[120px] h-auto opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </div>
          <div
            class="p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 flex justify-center items-center"
          >
            <img
              src="C:\Users\iwanf\Downloads\Group 207@2x.png"
              alt="Peralatan Renang"
              class="max-w-[120px] h-auto opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </div>
          <div
            class="p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 flex justify-center items-center"
          >
            <img
              src="C:\Users\iwanf\Downloads\Group 207@2x.png"
              alt="Pemerintah Daerah"
              class="max-w-[120px] h-auto opacity-80 hover:opacity-100 transition-opacity duration-300"
            />
          </div>
        </div>
        <a
          href="#"
          class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mt-12 text-lg"
        >
          Jadilah Sponsor Hydrodive
          <svg
            class="w-5 h-5 ml-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 8l4 4m0 0l-4 4m4-4H3"
            ></path>
          </svg>
        </a>
      </section> --}}



      {{-- <section
        id="sejarah"
        class="bg-gray-100 p-8 md:p-12 rounded-3xl shadow-lg mb-8 text-center"
      >
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10">
          Jejak <span class="text-gradient">Sejarah</span> Hydrodive
        </h2>
        <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
          Sejak didirikan, Hydrodive telah berkomitmen penuh untuk memajukan
          olahraga renang dan melahirkan generasi perenang handal.
        </p>
        <div class="relative max-w-3xl mx-auto pb-12">
          <div
            class="absolute w-0.5 bg-gray-300 top-0 bottom-0 left-1/2 -ml-0.5 md:left-1/2 md:transform md:-translate-x-1/2"
          ></div>

          <div
            class="flex flex-col md:flex-row justify-between mb-10 relative md:items-start"
          >
            <div
              class="md:w-1/2 md:text-right md:pr-16 order-2 md:order-1 text-left px-4 md:px-0"
            >
              <div
                class="bg-white p-6 rounded-xl shadow-md relative mt-8 md:mt-0"
              >
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                  Pendirian Hydrodive
                </h3>
                <p class="text-gray-700">
                  Hydrodive secara resmi didirikan oleh sekelompok penggemar
                  renang dengan visi menciptakan platform manajemen event renang
                  yang terintegrasi.
                </p>
              </div>
            </div>
            <div
              class="absolute md:relative w-full md:w-auto text-center z-10 top-0 left-1/2 md:left-1/2 md:transform md:-translate-x-1/2 px-4 md:px-0"
            >
              <span
                class="inline-block bg-blue-500 text-white text-lg font-bold px-5 py-2 rounded-full border-2 border-blue-500 shadow-lg"
                >2018</span
              >
            </div>
            <div class="hidden md:block md:w-1/2 order-3"></div>
          </div>

          <div
            class="flex flex-col md:flex-row justify-between mb-10 relative md:items-start"
          >
            <div class="hidden md:block md:w-1/2 order-1"></div>
            <div
              class="absolute md:relative w-full md:w-auto text-center z-10 top-0 left-1/2 md:left-1/2 md:transform md:-translate-x-1/2 px-4 md:px-0"
            >
              <span
                class="inline-block bg-blue-500 text-white text-lg font-bold px-5 py-2 rounded-full border-2 border-blue-500 shadow-lg"
                >2020</span
              >
            </div>
            <div
              class="md:w-1/2 md:pl-16 order-2 md:order-3 text-left px-4 md:px-0"
            >
              <div
                class="bg-white p-6 rounded-xl shadow-md relative mt-8 md:mt-0"
              >
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                  Peluncuran Platform Online
                </h3>
                <p class="text-gray-700">
                  Platform pendaftaran online dan sistem pelaporan hasil
                  dikembangkan, memudahkan peserta dan penyelenggara acara.
                </p>
              </div>
            </div>
          </div>

          <div
            class="flex flex-col md:flex-row justify-between mb-10 relative md:items-start"
          >
            <div
              class="md:w-1/2 md:text-right md:pr-16 order-2 md:order-1 text-left px-4 md:px-0"
            >
              <div
                class="bg-white p-6 rounded-xl shadow-md relative mt-8 md:mt-0"
              >
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                  Ekspansi Nasional
                </h3>
                <p class="text-gray-700">
                  Menyelenggarakan event di berbagai kota besar di Indonesia,
                  menjangkau lebih banyak komunitas perenang.
                </p>
              </div>
            </div>
            <div
              class="absolute md:relative w-full md:w-auto text-center z-10 top-0 left-1/2 md:left-1/2 md:transform md:-translate-x-1/2 px-4 md:px-0"
            >
              <span
                class="inline-block bg-blue-500 text-white text-lg font-bold px-5 py-2 rounded-full border-2 border-blue-500 shadow-lg"
                >2023</span
              >
            </div>
            <div class="hidden md:block md:w-1/2 order-3"></div>
          </div>

          <div
            class="flex flex-col md:flex-row justify-between relative md:items-start"
          >
            <div class="hidden md:block md:w-1/2 order-1"></div>
            <div
              class="absolute md:relative w-full md:w-auto text-center z-10 top-0 left-1/2 md:left-1/2 md:transform md:-translate-x-1/2 px-4 md:px-0"
            >
              <span
                class="inline-block bg-blue-500 text-white text-lg font-bold px-5 py-2 rounded-full border-2 border-blue-500 shadow-lg"
                >Sekarang</span
              >
            </div>
            <div
              class="md:w-1/2 md:pl-16 order-2 md:order-3 text-left px-4 md:px-0"
            >
              <div
                class="bg-white p-6 rounded-xl shadow-md relative mt-8 md:mt-0"
              >
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                  Masa Depan Berkelanjutan
                </h3>
                <p class="text-gray-700">
                  Berkomitmen untuk terus berinovasi dalam teknologi dan
                  manajemen event, serta membina talenta renang masa depan.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section> --}}

      <section
        id="blog"
        class="bg-white p-8 md:p-12 rounded-3xl shadow-lg mb-8 text-center"
      >
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10">
          Berita & <span class="text-gradient">Blog</span> Terbaru
        </h2>
        <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">
          Dapatkan informasi terbaru seputar dunia renang, tips pelatihan,
          berita event, dan kisah inspiratif dari komunitas Hydrodive.
        </p>
        <div
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto"
        >
            @foreach($blogs as $blog)
              <div
            class="bg-gray-50 rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col"
          >
            <img
             src="{{asset('storage/' . $blog->thumbnail)}}"
              alt="Manfaat Renang"
              class="w-full h-48 object-cover"
            />
            <div class="p-6 flex-grow text-left">
              <h3 class="text-xl font-bold text-gray-900 mb-3">
                {{ $blog->title }}
              </h3>

              <p class="text-gray-700 text-base mb-4">
                {{ Str::limit($blog->content, 100, '...') }}
              </p>
              <a
                href="/post/{{ $blog->slug }}"
                class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-sm"
              >
                Baca Selengkapnya →
              </a>
            </div>
          </div>
            @endforeach


        </div>
        <a
          href="/blogs"
          class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mt-12 text-lg"
        >
          Lihat Semua Artikel
          <svg
            class="w-5 h-5 ml-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 8l4 4m0 0l-4 4m4-4H3"
            ></path>
          </svg>
        </a>
      </section>
    </div>
 <section
        id="lokasi"
        class="bg-white p-8 md:p-12 rounded-3xl shadow-lg mb-8 text-center"
      >
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10">
          {{ $section['lokasi']['judul1'] }} <span class="text-gradient">{{ $section['lokasi']['judul2'] }}</span>
        </h2>
        <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto">

                    {{ $section['lokasi']['deskripsi'] }}
        </p>
        <div class="flex flex-col items-center gap-8 max-w-4xl mx-auto">
          <div
            class="w-full h-[400px] bg-gray-200 rounded-2xl overflow-hidden shadow-xl"
          >
           <iframe
              src="{{ $section['lokasi']['link_peta'] }}"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              class="w-full h-full border-0"
              ></iframe>

            </div>
            <div class="text-left text-lg text-gray-700">
                <p class="mb-4">
                    {{ $section['lokasi']['deskripsi2'] }}
            </p>

            <a
              href="{{ $section['lokasi']['lihat_map'] }}"
              target="_blank"
              class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition duration-300"
            >
              Lihat di Google Maps <span class="ml-2">→</span>
            </a>
          </div>
        </div>
      </section>
    <footer
      id="contact-footer"
      class="bg-gray-900 text-white py-16 px-4 rounded-t-3xl mt-12"
    >
      <div
        class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 text-center md:text-left"
      >
        <div>
          <h4 class="text-2xl font-bold text-blue-400 mb-6"> {{ config('app.name') }}</h4>
          <p class="text-gray-400 mb-4">
            {{ $section['footer']['app'] }}
          </p>
          <div class="flex justify-center md:justify-start space-x-6">
            @foreach ($section['footer']['media_sosial'] as $medsos)
            <a
            href="{{ $medsos['url'] }}"
            target="_blank"
            class=" transition-colors duration-300 medsosList"
            >@if (Str::contains($medsos['icon'], 'svg')){!! $medsos['icon'] !!}@else{{ $medsos['icon'] }}@endif</a
            >

            @endforeach

          </div>
        </div>

        <div>
          <h4 class="text-xl font-bold text-blue-400 mb-6">Navigasi Cepat</h4>
          <ul class="space-y-3">
            <li>
              <a
                href="#tentang-kami"
                class="text-gray-400 hover:text-white transition-colors duration-300"
                >Tentang Kami</a
              >
            </li>
            <li>
              <a
                href="#acara"
                class="text-gray-400 hover:text-white transition-colors duration-300"
                >Acara Mendatang</a
              >
            </li>
            <li>
              <a
                href="#sponsor"
                class="text-gray-400 hover:text-white transition-colors duration-300"
                >Sponsor Kami</a
              >
            </li>
            <li>
              <a
                href="#lokasi"
                class="text-gray-400 hover:text-white transition-colors duration-300"
                >Lokasi Kantor</a
              >
            </li>
            <li>
              <a
                href="#sejarah"
                class="text-gray-400 hover:text-white transition-colors duration-300"
                >Sejarah Hydrodive</a
              >
            </li>
            <li>
              <a
                href="#blog"
                class="text-gray-400 hover:text-white transition-colors duration-300"
                >Blog & Berita</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h4 class="text-xl font-bold text-blue-400 mb-6">{{$section['footer']['kontak']['judul']}}</h4>
          <ul class="space-y-3 text-gray-400">
            @foreach ($section['footer']['kontak']['items'] as $item)

            <li>
                {{ $item['text'] }} :  {{$item['deskripsi']}}
            </li>
            @endforeach

          </ul>

        </div>
      </div>
      <div
        class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-500 text-sm"
      >
        © 2025 Hydrodive. All Rights Reserved.
      </div>
    </footer>

    @livewireScripts

    <script src="https://unpkg.com/scrollreveal"></script>
       <script>
  ScrollReveal().reveal('#tentang-kami', {
    origin: 'bottom',
    distance: '50px',
    duration: 1000,
    delay: 100,
    easing: 'ease-in-out',
    reset: false
  });

  ScrollReveal().reveal('#tentang-kami img', {
    origin: 'left',
    distance: '50px',
    duration: 1000,
    delay: 200
  });

  ScrollReveal().reveal('#tentang-kami h3, #tentang-kami p, #tentang-kami ul li', {
    origin: 'right',
    distance: '30px',
    duration: 1000,
    interval: 100
  });

  ScrollReveal().reveal('.grid > div', {
    origin: 'bottom',
    distance: '40px',
    duration: 1000,
    interval: 200,
    easing: 'ease'
  });

  ScrollReveal().reveal('#acara', {
    origin: 'bottom',
    distance: '60px',
    duration: 1000,
    delay: 100
  });

  ScrollReveal().reveal('#acara .relative', {
    origin: 'bottom',
    distance: '40px',
    duration: 1000,
    interval: 150
  });
    ScrollReveal().reveal('section', {
    distance: '60px',
    duration: 1000,
    easing: 'ease-in-out',
    origin: 'bottom',
    interval: 200,
  });

  ScrollReveal().reveal('h1, h2, h3,#sejarah span, p', {
    distance: '40px',
    duration: 800,
    origin: 'bottom',
    interval: 100,
    easing: 'ease-in-out',
  });

  ScrollReveal().reveal('img', {
    distance: '80px',
    origin: 'right',
    duration: 1000,
    easing: 'ease-out',
  });


  document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('main-header');
    const heroSection = document.querySelector('section'); // Asumsikan hero ada di section pertama
function handleScroll() {
  if (window.scrollY > 0) {
    header.classList.add('bg-white', 'shadow-md', 'backdrop-blur-md');
  } else {
    header.classList.remove('bg-white', 'shadow-md', 'backdrop-blur-md');
  }
}

window.addEventListener('scroll', handleScroll);
handleScroll();
  });
    </script>
</body>
</html>
