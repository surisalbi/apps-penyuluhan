<script>
    document.getElementById('uploadForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const files = document.getElementById('file-input').files;
        const kategori = this.kategori.value;

        if (!kategori) {
            showToast('error', 'Pilih kategori terlebih dahulu');
            return;
        }

        if (!files.length) {
            showToast('error', 'Pilih gambar terlebih dahulu');
            return;
        }

        if (files.length > 5) {
            showToast('error', 'Maksimal 5 gambar sekali upload');
            return;
        }

        const uploadBtn = document.getElementById('uploadBtn');
        uploadBtn.classList.add('hidden');

        const formData = new FormData();
        formData.append('kategori', kategori);
        formData.append('_token', '{{ csrf_token() }}');

        // Compress semua image
        for (const file of files) {
            const compressed = await compressImage(file, 0.7, 1280);
            formData.append('screenshot[]', compressed, compressed.name);
        }

        uploadAjax(formData);
    });
</script>

<script>
    function compressImage(file, quality = 0.7, maxWidth = 1280) {
        return new Promise((resolve) => {
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = (e) => {
                const img = new Image();
                img.src = e.target.result;

                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const scale = Math.min(maxWidth / img.width, 1);

                    canvas.width = img.width * scale;
                    canvas.height = img.height * scale;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob(
                        (blob) => {
                            const compressedFile = new File(
                                [blob],
                                file.name.replace(/\.(jpg|jpeg|png)$/i, '.jpg'),
                                { type: 'image/jpeg' }
                            );
                            resolve(compressedFile);
                        },
                        'image/jpeg',
                        quality
                    );
                };
            };
        });
    }
</script>

<script>
    function uploadAjax(formData) {
        const wrapper = document.getElementById('progressWrapper');
        const bar = document.getElementById('progressBar');
        const text = document.getElementById('progressText');
        const label = document.getElementById('progressLabel');

        wrapper.classList.remove('hidden');
        bar.style.width = '0%';
        text.innerText = '0%';
        label.innerText = 'Mengunggah...';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', "{{ route('upload.store') }}", true);

        // WAJIB untuk Laravel
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.onprogress = function (e) {
            if (!e.lengthComputable) return;

            const percent = Math.round((e.loaded / e.total) * 100);
            bar.style.width = percent + '%';
            text.innerText = percent + '%';
        };

        xhr.onload = function () {
            let res;

            try {
                res = JSON.parse(xhr.responseText);
            } catch (e) {
                showError();
                return;
            }

            if (xhr.status === 200 && res.status === 'success') {
                bar.style.width = '100%';
                text.innerText = '100%';
                label.innerText = 'Upload selesai';

                // animasi sukses
                bar.classList.remove('from-emerald-500', 'to-emerald-600');
                bar.classList.add('from-emerald-600', 'to-green-500');

                showToast('success', res.message ?? 'Upload berhasil');

                // hide smooth
                setTimeout(() => {
                    wrapper.classList.add('hidden');
                    bar.style.width = '0%';
                    text.innerText = '0%';
                    label.innerText = 'Mengunggah...';
                    window.location.href = "{{ route('upload') }}";
                }, 1500);

            } else {
                showError(res?.message);
                document.getElementById('uploadBtn').classList.remove('hidden');
            }
        };

        xhr.onerror = showError;

        xhr.send(formData);

        function showError(msg = 'Upload gagal') {
            label.innerText = 'Upload gagal';
            bar.classList.remove('from-emerald-500', 'to-emerald-600');
            bar.classList.add('bg-rose-500');
            showToast('error', msg);
            window.location.href = "{{ route('upload') }}";
        }
    }

</script>

<script>
    let toastTimeout;

    function showToast(type, message) {
        const toast = document.getElementById('toast');
        const toastMsg = document.getElementById('toast-message');
        const toastIcon = document.getElementById('toast-icon');

        // Reset timeout sebelumnya
        if (toastTimeout) clearTimeout(toastTimeout);

        // Reset state
        toast.classList.remove(
            'hidden',
            'opacity-0',
            '-translate-y-2',
            'bg-emerald-600',
            'bg-rose-600'
        );

        toastMsg.innerText = message;

        if (type === 'success') {
            toast.classList.add('bg-emerald-600');
            toastIcon.innerHTML = '<i class="fas fa-check"></i>';
        } else {
            toast.classList.add('bg-rose-600');
            toastIcon.innerHTML = '<i class="fas fa-times"></i>';
        }

        // Trigger show animation
        requestAnimationFrame(() => {
            toast.classList.add('opacity-100', 'translate-y-0');
        });

        // Auto hide
        toastTimeout = setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', '-translate-y-2');

            // benar-benar hilang dari layout
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300); // sesuai duration transition
        }, 3000);
    }
</script>

<script>
        document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("photo-modal");
        const modalImg = document.getElementById("modal-img");
        let currentPhotoId = null;

        if (!modal || !modalImg) return;

        document.querySelectorAll(".photo-item").forEach((img) => {
            img.addEventListener("click", () => {
                modalImg.src = img.src;
                currentPhotoId = img.dataset.id || null;
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            });
        });

        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
                currentPhotoId = null;
            }
        });

        // tombol delete langsung hapus tanpa confirm
        const deleteBtn = document.getElementById("delete-btn");
        if (deleteBtn) {
            deleteBtn.addEventListener("click", () => {
                if (!currentPhotoId) return;

                fetch(`/upload/${currentPhotoId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                })
                .then((res) => res.json())
                .then((res) => {
                    if (res.status === "success") {
                        // hapus elemen foto dari DOM
                        const imgToRemove = document.querySelector(
                            `.photo-item[data-id="${currentPhotoId}"]`
                        );
                        if (imgToRemove) imgToRemove.parentElement.remove();
                        currentPhotoId = null;
                        modal.classList.add("hidden");
                        modal.classList.remove("flex");
                        showToast("success", "Foto berhasil dihapus");
                    } else {
                        showToast("error", res.message ?? "Gagal hapus foto");
                    }
                })
                .catch(() => showToast("error", "Gagal hapus foto"));
            });
        }
    });

</script>


<div id="toast" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 hidden max-w-sm w-[calc(100%-2rem)] rounded-xl shadow-xl border border-white/20 transition-all duration-300 opacity-0 -translate-y-3">
    <div class="flex items-center gap-3 px-4 py-3">
        <div id="toast-icon" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white"></div>
        <p id="toast-message" class="flex-1 text-sm font-medium text-white"></p>
    </div>
</div>