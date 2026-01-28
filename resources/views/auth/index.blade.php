<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $title }} - APPS Penyuluhan</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
  </head>

  <body class="font-sans antialiased min-h-screen flex justify-center bg-gradient-to-b from-primary to-primaryDark">
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

                <form action="" method="post" onsubmit="handleSubmit()">
                    @csrf
                    @error('failed')
                        <!-- Alert statis -->
                        <div class="w-full max-w-sm mx-auto bg-amber-100 border border-amber-400 text-amber-800 px-4 py-3 rounded-full flex items-center space-x-3 mt-4" role="alert">
                            <!-- Icon -->
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"></path>
                            </svg>

                            <!-- Message -->
                            <span class="font-medium">{{ $message }}</span>
                        </div>

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
                    <button
                        id="loginBtn"
                        type="submit"
                        class="w-full mt-6 flex items-center justify-center gap-2
                            text-white font-semibold py-3 rounded-full shadow-md
                            transition-all duration-300
                            bg-gradient-to-r from-primary to-primaryDark
                            hover:from-primaryDark hover:to-primaryDark
                            disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <span id="btnText">Masuk</span>

                        <!-- Spinner -->
                        <svg
                            id="btnSpinner"
                            class="hidden w-5 h-5 animate-spin text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                            ></path>
                        </svg>
                    </button>

                </form>
                <!-- Footer -->
                <p class="text-center text-xs text-gray-400 mt-10">
                    © 2026 Suri Salbi Teknologi
                </p>
            </div>
        </div>

        <script>
            function handleSubmit() {
                const btn = document.getElementById('loginBtn');
                const text = document.getElementById('btnText');
                const spinner = document.getElementById('btnSpinner');

                btn.disabled = true;
                text.textContent = 'Sedang verifikasi...';
                spinner.classList.remove('hidden');
            }
        </script>


  </body>
</html>
