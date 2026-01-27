document.addEventListener("DOMContentLoaded", () => {
    const clockEl = document.getElementById("clock");
    const tanggalEl = document.getElementById("tanggal");

    function updateClock() {
        if (!clockEl) return;

        const now = new Date();
        const jam = String(now.getHours()).padStart(2, "0");
        const menit = String(now.getMinutes()).padStart(2, "0");
        const detik = String(now.getSeconds()).padStart(2, "0");

        clockEl.innerText = `${jam}:${menit}:${detik}`;
    }

    function tampilTanggal() {
        if (!tanggalEl) return;

        const now = new Date();
        const tanggal = now.toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });

        tanggalEl.innerText = tanggal;
    }

    // panggil langsung
    updateClock();
    tampilTanggal();

    // interval hanya jika elemennya ada
    if (clockEl) {
        setInterval(updateClock, 1000);
    }

    if (tanggalEl) {
        setInterval(tampilTanggal, 60000);
    }
});
