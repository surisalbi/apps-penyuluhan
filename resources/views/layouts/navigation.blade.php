<!-- BOTTOM NAVIGATION -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-lg safe-bottom safe-bottom-area">
    <div class="flex items-stretch">
        <!-- Home (Active) -->
        <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center justify-center py-3 {{ request()->is('/') ? 'border-t-[3.5px] border-primary rounded-b-xl bg-gradient-to-b from-[#d9ffdb] to-white text-primaryDark shadow-inner' : 'text-gray-500 hover:bg-gray-100' }}">
            <i class="fas fa-home mb-2"></i>
            <span class="text-xs font-medium">Home</span>
        </a>

        <!-- Absensi -->
        <a href="{{ route('absensi') }}" class="flex-1 flex flex-col items-center justify-center py-3 {{ request()->is('absensi*') ? 'border-t-[3.5px] border-primary rounded-b-xl bg-gradient-to-b from-[#d9ffdb] to-white text-primaryDark shadow-inner' : 'text-gray-500 hover:bg-gray-100' }}">
            <i class="fas fa-clock mb-2"></i>
            <span class="text-xs">Absensi</span>
        </a>

        <!-- Upload -->
        <a href="{{ route('upload') }}" class="flex-1 flex flex-col items-center justify-center py-3 {{ request()->is('upload*') ? 'border-t-[3.5px] border-primary rounded-b-xl bg-gradient-to-b from-[#d9ffdb] to-white text-primaryDark shadow-inner' : 'text-gray-500 hover:bg-gray-100' }}">
            <i class="fas fa-upload mb-2"></i>
            <span class="text-xs">Upload</span>
        </a>

        <!-- Akun -->
        <a href="{{ route('akun') }}" class="flex-1 flex flex-col items-center justify-center py-3 {{ request()->is('akun*') ? 'border-t-[3.5px] border-primary rounded-b-xl bg-gradient-to-b from-[#d9ffdb] to-white text-primaryDark shadow-inner' : 'text-gray-500 hover:bg-gray-100' }}">
            <i class="fas fa-user mb-2"></i>
            <span class="text-xs">Akun</span>
        </a>
    </div>
</nav>