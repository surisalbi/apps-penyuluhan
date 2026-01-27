document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab-btn");
    const contents = document.querySelectorAll(".tab-content");

    if (!tabs.length || !contents.length) return;

    let currentTab = 0;

    function showTab(index) {
        tabs.forEach((tab) => {
            tab.classList.remove(
                "text-emerald-600",
                "borer-b-2",
                "border-[#2E7D32]",
                "font-semibold",
                "bg-gradient-to-t",
                "from-[#d9ffdb]",
                "to-white",
            );
            tab.classList.add("text-gray-500", "border-transparent");
        });

        contents.forEach((c) => c.classList.add("hidden"));

        tabs[index].classList.add(
            "text-emerald-600",
            "borer-b-2",
            "border-[#2E7D32]",
            "font-semibold",
            "bg-gradient-to-t",
            "from-[#d9ffdb]",
            "to-white",
        );
        tabs[index].classList.remove("text-gray-500", "border-transparent");

        contents[index].classList.remove("hidden");
        currentTab = index;
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", () => showTab(index));
    });

    showTab(0);

    // =========================
    // MODAL PREVIEW
    // =========================
    const modal = document.getElementById("photo-modal");
    const modalImg = document.getElementById("modal-img");

    // Modal tidak ada → STOP
    if (!modal || !modalImg) return;

    document.querySelectorAll(".photo-item").forEach((img) => {
        img.addEventListener("click", () => {
            modalImg.src = img.src;
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
    });

    modal.addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });
});
