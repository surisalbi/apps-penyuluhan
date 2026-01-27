document.addEventListener("DOMContentLoaded", () => {
    // =============================
    // MODAL
    // =============================
    window.openUploadModal = function () {
        const modal = document.getElementById("upload-modal");
        const panel = document.getElementById("upload-panel");

        if (!modal || !panel) return;

        modal.classList.remove("hidden");
        setTimeout(() => {
            panel.classList.remove("translate-y-full");
        }, 10);
    };

    window.closeUploadModal = function () {
        const modal = document.getElementById("upload-modal");
        const panel = document.getElementById("upload-panel");

        if (!modal || !panel) return;

        panel.classList.add("translate-y-full");
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 300);
    };

    // =============================
    // ELEMENT
    // =============================
    const fileInput = document.getElementById("file-input");
    const dropArea = document.getElementById("drop-area");
    const previewContainer = document.getElementById("preview-container");
    const previewGrid = document.getElementById("preview-grid");
    const addBtn = document.getElementById("add-btn");
    const clearBtn = document.getElementById("clear-btn");

    // Jika halaman bukan halaman upload → STOP
    if (!fileInput || !dropArea || !previewContainer || !previewGrid) return;

    /* 🔥 STATE FILE */
    let selectedFiles = [];

    /* =============================
     INPUT CHANGE
  ============================= */
    fileInput.addEventListener("change", () => {
        const newFiles = Array.from(fileInput.files);

        newFiles.forEach((file) => {
            if (
                file.type.startsWith("image/") &&
                !selectedFiles.some(
                    (f) => f.name === file.name && f.size === file.size,
                )
            ) {
                selectedFiles.push(file);
            }
        });

        syncInputFiles();
        renderPreview();
    });

    /* =============================
     SYNC FILE
  ============================= */
    function syncInputFiles() {
        const dt = new DataTransfer();
        selectedFiles.forEach((file) => dt.items.add(file));
        fileInput.files = dt.files;
    }

    /* =============================
     PREVIEW
  ============================= */
    function renderPreview() {
        previewGrid.innerHTML = "";

        if (!selectedFiles.length) {
            resetUpload();
            return;
        }

        dropArea.classList.add("hidden");
        previewContainer.classList.remove("hidden");

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const item = document.createElement("div");
                item.className = "relative rounded-xl overflow-hidden shadow";

                item.innerHTML = `
          <img src="${e.target.result}" class="w-full h-40 object-cover" />

          <button
            class="absolute top-2 right-2 bg-black/60 text-white
                   w-8 h-8 rounded-full flex items-center justify-center"
            onclick="removeImage(${index})"
          >
            <i class="fas fa-times text-sm"></i>
          </button>
        `;

                previewGrid.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }

    /* =============================
     HAPUS SATU
  ============================= */
    window.removeImage = function (index) {
        selectedFiles.splice(index, 1);
        syncInputFiles();
        renderPreview();
    };

    /* =============================
     TAMBAH FOTO
  ============================= */
    if (addBtn) {
        addBtn.addEventListener("click", () => {
            fileInput.click();
        });
    }

    /* =============================
     CLEAR
  ============================= */
    if (clearBtn) {
        clearBtn.addEventListener("click", resetUpload);
    }

    function resetUpload() {
        selectedFiles = [];
        fileInput.value = "";
        previewGrid.innerHTML = "";
        previewContainer.classList.add("hidden");
        dropArea.classList.remove("hidden");
    }
});
