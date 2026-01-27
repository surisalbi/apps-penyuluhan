<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $title }} - APPS Penyuluhan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
  </head>

  <body class="min-h-screen flex justify-center bg-gradient-to-b from-primary to-primaryDark">
    <div class="absolute inset-0 bg-white/5 blur-3xl"></div>
        <!-- Mobile Wrapper -->
        <div class="w-full max-w-sm min-h-screen relative">
            <!-- Header -->
            <div class="pt-14 pb-24 flex flex-col items-center">
                <!-- Logo -->
                <div class="w-20 h-20 rounded-full flex items-center justify-center shadow-lg">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" />
                </div>

                <h1 class="text-white text-sm font-semibold mt-4 text-center leading-snug">
                    KEMENTERIAN PERTANIAN<br />
                    REPUBLIK INDONESIA
                </h1>
            </div>

            <!-- Card Login -->
            <div class="bg-white absolute bottom-0 w-full rounded-t-big px-6 pt-10 pb-8 shadow-2xl">
                <h2 class="text-center text-xl font-semibold text-gray-800">Login</h2>
                <p class="text-center text-sm text-gray-500 mt-2">
                    Belum punya akun?
                    <a href="#" class="text-primary font-medium"> Daftar </a>
                </p>

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    @error('failed')
                        {{ $message }}
                    @enderror
                    <!-- Input -->
                    <div class="mt-8">
                        <input type="text" name="email" placeholder="Email" class="w-full px-5 py-3 rounded-full border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                    </div>

                    <!-- Input -->
                    <div class="mt-6">
                        <input type="text" name="password" placeholder="Password" class="w-full px-5 py-3 rounded-full border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                    </div>

                    <!-- Button -->
                    <button class="w-full mt-6 text-white font-semibold py-3 rounded-full shadow-md transition-all bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark">
                        Masuk
                    </button>
                </form>
                <!-- Footer -->
                <p class="text-center text-xs text-gray-400 mt-10">
                    © 2026 Suri Salbi Teknologi
                </p>
            </div>
        </div>
  </body>
</html>
