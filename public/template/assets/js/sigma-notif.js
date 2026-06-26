/* =========================================================
   SIGMA - Sistem Notifikasi Terpusat
   Semua halaman memanggil function dari sini agar konsisten.
   Membutuhkan: SweetAlert2 (swal) sudah termuat sebelum file ini.
   ========================================================= */

const SigmaNotif = {

    /**
     * Toast kecil di pojok kanan atas. Muncul sebentar, lalu hilang otomatis.
     * Dipakai setelah aksi BERHASIL (tambah, edit, hapus berhasil disimpan).
     */
    sukses(pesan = 'Data berhasil disimpan') {
        swal({
            icon: 'success',
            title: pesan,
            buttons: false,
            timer: 2200,
            className: 'swal-toast-3d',
        });
    },

    gagal(pesan = 'Terjadi kesalahan, silakan coba lagi') {
        swal({
            icon: 'error',
            title: pesan,
            buttons: false,
            timer: 2800,
            className: 'swal-toast-3d',
        });
    },

    info(pesan = '') {
        swal({
            icon: 'info',
            title: pesan,
            buttons: false,
            timer: 2200,
            className: 'swal-toast-3d',
        });
    },

    /**
     * Modal konfirmasi sebelum MENGHAPUS data.
     * Mengembalikan Promise; jika user klik "Ya, Hapus", form akan disubmit.
     *
     * Penggunaan:
     *   <form id="form-hapus-5" action="..." method="POST">@csrf @method('DELETE')</form>
     *   <button onclick="SigmaNotif.konfirmasiHapus('form-hapus-5')">Hapus</button>
     */
    konfirmasiHapus(idForm, opsi = {}) {
        swal({
            title: opsi.judul || 'Hapus Data Ini?',
            text: opsi.teks || 'Data yang sudah dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            buttons: {
                batal: {
                    text: 'Batal',
                    value: false,
                    className: 'swal-btn-cancel-3d',
                },
                hapus: {
                    text: 'Ya, Hapus',
                    value: true,
                    className: 'swal-btn-danger-3d',
                },
            },
            className: 'swal-modal-3d',
            dangerMode: true,
        }).then((konfirmasi) => {
            if (konfirmasi) {
                const form = document.getElementById(idForm);
                if (form) form.submit();
            }
        });
    },

    /**
     * Modal konfirmasi generik untuk aksi penting lain (misal: selesaikan opname,
     * pindahkan kelebihan kapasitas, retur barang, dll). Memanggil callback jika "Ya".
     *
     * Penggunaan:
     *   SigmaNotif.konfirmasi({
     *       judul: 'Selesaikan Opname?',
     *       teks: 'Stok sistem akan disesuaikan otomatis.',
     *   }, function() {
     *       document.getElementById('form-opname').submit();
     *   });
     */
    konfirmasi(opsi = {}, onYa = () => {}) {
        swal({
            title: opsi.judul || 'Anda Yakin?',
            text: opsi.teks || '',
            icon: opsi.icon || 'question',
            buttons: {
                batal: {
                    text: opsi.teksBatal || 'Batal',
                    value: false,
                    className: 'swal-btn-cancel-3d',
                },
                lanjut: {
                    text: opsi.teksLanjut || 'Ya, Lanjutkan',
                    value: true,
                    className: 'swal-btn-confirm-3d',
                },
            },
            className: 'swal-modal-3d',
        }).then((konfirmasi) => {
            if (konfirmasi) onYa();
        });
    },

    /**
     * Konfirmasi BATAL — dipakai saat user klik tombol "Batal" di tengah mengisi
     * form Tambah/Edit, untuk memastikan tidak salah klik dan kehilangan isian.
     * Jika dikonfirmasi, akan redirect ke halaman yang dituju (urlTujuan).
     *
     * Penggunaan:
     *   <button type="button" onclick="SigmaNotif.konfirmasiBatal('{{ route('produk.index') }}')">Batal</button>
     */
    konfirmasiBatal(urlTujuan, opsi = {}) {
        swal({
            title: opsi.judul || 'Batalkan Perubahan?',
            text: opsi.teks || 'Data yang sudah Anda isi tidak akan disimpan.',
            icon: 'warning',
            buttons: {
                batal: {
                    text: 'Tidak, Lanjutkan Isi',
                    value: false,
                    className: 'swal-btn-cancel-3d',
                },
                ya: {
                    text: 'Ya, Batalkan',
                    value: true,
                    className: 'swal-btn-danger-3d',
                },
            },
            className: 'swal-modal-3d',
        }).then((konfirmasi) => {
            if (konfirmasi) {
                window.location.href = urlTujuan;
            }
        });
    },
};

/* =========================================================
   Tampilkan otomatis notifikasi dari Laravel session flash
   (dipasang sekali di layout utama, baca dari Blade)
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {
    if (window.SIGMA_FLASH) {
        if (window.SIGMA_FLASH.success) {
            SigmaNotif.sukses(window.SIGMA_FLASH.success);
        }
        if (window.SIGMA_FLASH.error) {
            SigmaNotif.gagal(window.SIGMA_FLASH.error);
        }
    }
});
