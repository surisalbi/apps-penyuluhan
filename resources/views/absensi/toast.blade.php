<div id="toast" class="fixed top-5 left-1/2 z-50 hidden max-w-sm w-[calc(100%-2rem)] -translate-x-1/2 rounded-xl shadow-xl border border-white/20 transition-all duration-300 opacity-0 scale-95">
    <div class="flex items-center gap-3 px-4 py-3">
        <!-- Icon -->
        <div id="toast-icon" class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white/20 text-white text-sm"></div>
        <!-- Message -->
        <div class="flex-1 text-sm font-medium leading-snug text-white">
            <p id="toast-message" class="break-words"></p>
        </div>
    </div>
</div>

<script>
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const msg = document.getElementById('toast-message');
        const icon = document.getElementById('toast-icon');

        msg.innerText = message;
        icon.innerHTML = icons[type] ?? '';

        toast.classList.remove(
            'hidden',
            'opacity-0',
            'scale-95',
            'bg-green-500',
            'bg-red-500'
        );

        toast.classList.add(
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        );

        // show
        requestAnimationFrame(() => {
            toast.classList.add('opacity-100', 'scale-100');
        });

        // hide
        setTimeout(() => {
            toast.classList.remove('opacity-100', 'scale-100');
            toast.classList.add('opacity-0', 'scale-95');
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
    }

</script>
<script>
    const icons = {
        success: `<i class="fas fa-check"></i>`,
        error: `<i class="fas fa-times"></i>`,
        warning: `<i class="fas fa-exclamation-triangle"></i>`
    };
</script>