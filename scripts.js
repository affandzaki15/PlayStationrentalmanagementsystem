// Fungsi untuk menampilkan elemen saat scroll
document.addEventListener("DOMContentLoaded", function () {
    const elemenScroll = document.querySelectorAll(".bingkai-foto");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("terlihat");
                }
            });
        },
        {
            threshold: 0.5, // Elemen akan terlihat jika 50% sudah masuk ke viewport
        }
    );

    elemenScroll.forEach((el) => observer.observe(el));
});
