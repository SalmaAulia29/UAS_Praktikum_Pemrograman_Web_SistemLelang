document.addEventListener('DOMContentLoaded', () => {
    console.log('Laporan system loaded');

    // Tampilkan indikator sederhana saat export laporan
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            if (this.href && (this.href.includes('pdf') || this.href.includes('csv'))) {
                this.innerText = 'Memproses...';
                this.style.pointerEvents = 'none';
            }
        });
    });
});
