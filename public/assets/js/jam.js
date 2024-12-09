function updateClock() {
    var now = new Date();
    var jam = now.getHours();
    var menit = now.getMinutes();
    var detik = now.getSeconds();

    // Tambahkan nol di depan jika nilai jam, menit, atau detik kurang dari 10
    jam = padZero(jam);
    menit = padZero(menit);
    detik = padZero(detik);

    // Update elemen HTML dengan waktu yang baru
    document.getElementById("clock").textContent =
        jam + ":" + menit + ":" + detik;

    // Panggil fungsi ini lagi setiap detik untuk update real-time
    setTimeout(updateClock, 1000);
}

function padZero(value) {
    return value < 10 ? "0" + value : value;
}

// Panggil fungsi updateClock() saat halaman telah dimuat
window.onload = function () {
    updateClock();
};
