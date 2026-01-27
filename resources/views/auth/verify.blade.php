<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-green-400 to-green-700 font-inter p-8">

    <!-- OTP Container -->
    <div class="bg-white/80 backdrop-blur-md rounded-3xl shadow-2xl p-8 w-full max-w-md">
        <!-- Header -->
        <div class="flex flex-col items-center mb-5">
            <!-- Logo -->
            <div class="w-20 h-20 rounded-full">
                <img src="{{ asset('assets/img/logo.png') }}" alt="logo" />
            </div>
        </div>
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-green-900 mb-2">Verifikasi OTP</h1>
            <p class="text-green-800/80">
                @php
                    if (!function_exists('maskEmailCommon')) {
                        function maskEmailCommon($email) {
                            $parts = explode('@', $email);
                            $name = $parts[0];
                            $domain = $parts[1];

                            $first = substr($name, 0, 2);
                            $maskedName = $first . str_repeat('*', max(strlen($name) - 1, 1));

                            return $maskedName . '@' . $domain;
                        }
                    }
                @endphp

                Kode OTP Anda telah dikirim ke alamat email <span class="fw-bolder">{{ maskEmailCommon(session('otp_email')) }}</span>.
            </p>
        </div>

        <!-- OTP Input -->
        <form action="{{ route('verify.process') }}" method="post" class="space-y-6">
            @csrf
            @error('failed')
                <!-- Alert statis -->
                <div class="w-full max-w-sm mx-auto bg-amber-100 border border-amber-400 text-amber-800 px-4 py-3 rounded-lg flex items-center space-x-3 mt-4" role="alert">
                    <!-- Icon -->
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"></path>
                    </svg>

                    <!-- Message -->
                    <span class="font-medium">{{ $message }}</span>
                </div>

            @enderror
            <div class="flex justify-between gap-1">
                <input autofocus type="text" maxlength="1" class="otp-input flex-1 max-w-[40px] h-10 text-center border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 text-lg font-semibold transition" />
                <input type="text" maxlength="1" class="otp-input flex-1 max-w-[40px] h-10 text-center border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 text-lg font-semibold transition" />
                <input type="text" maxlength="1" class="otp-input flex-1 max-w-[40px] h-10 text-center border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 text-lg font-semibold transition" />
                <input type="text" maxlength="1" class="otp-input flex-1 max-w-[40px] h-10 text-center border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 text-lg font-semibold transition" />
                <input type="text" maxlength="1" class="otp-input flex-1 max-w-[40px] h-10 text-center border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 text-lg font-semibold transition" />
                <input type="text" maxlength="1" class="otp-input flex-1 max-w-[40px] h-10 text-center border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-300 text-lg font-semibold transition" />
            </div>

            <input type="hidden" name="otp" id="otp-full">

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-500 to-green-700 text-white font-semibold rounded-xl shadow-lg hover:from-green-600 hover:to-green-800 transition">
                Verifikasi
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-green-800/70">Belum menerima kode? <a href="{{ route('login.resendOtp') }}" class="text-green-900 font-bold hover:underline">Kirim ulang</a></p>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const fullOtp = document.getElementById('otp-full');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                input.value = input.value.replace(/[^0-9]/g, '');

                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                fullOtp.value = [...inputs].map(i => i.value).join('');
            });

            input.addEventListener('paste', (e) => {
                const pasteData = e.clipboardData.getData('text').trim();
                if (pasteData.length === inputs.length) {
                    pasteData.split('').forEach((char, i) => inputs[i].value = char);
                }
                fullOtp.value = pasteData;
                e.preventDefault();
            });
        });
    </script>
</body>
</html>
