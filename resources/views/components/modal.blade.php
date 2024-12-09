<style>
    /* Styling for the note */
    .note {
        font-size: 0.875rem;
        /* Lebih kecil sedikit dari ukuran default */
        /* Warna teks muted Bootstrap */
    }
</style>
<div {{ $attributes }} tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Tambah Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="container-fluid" id="alert-container"></div>
                    <form action="/storeData" method="post" id="formNotice">
                        @csrf
                        <input type="date" value={{ $tanggal }} name="tanggal" class="form-control"
                            class="mb-1" style="width: 150px;">
                        <div class="mb-3">
                            <label for="nama" class="form-label">No Notes</label>
                            <input type="number" class="form-control" id="no_notice" name="no_notice"
                                value={{ $notice }}>
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-4">
                                        <input type="checkbox" id="noticeBaru" name="baru">
                                        <label for="noticeBaru">Notes Baru</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="checkbox" id="noticeBatal" name="kondisi" value="rusak">
                                        <label for="noticeBatal">Notes Batal</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="checkbox" id="noticeRusak" name="rusak">
                                        <label for="noticeRusak">Notes Rusak</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mb-3 row align-items-end">
                            <div class="col-9">
                                <label for="nopol" class="form-label">No.Polisi</label>
                                <input type="text" class="form-control" id="nopol" name="nopol" value="">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-primary" id="caridataaa" type="button">(F4) Cari </button>
                            </div>
                            <small class="note d-block text-muted">Tekan F4 untuk cari data</small>

                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="">
                        </div>
                        <div class="mb-3">
                            <label for="total_pajak" class="form-label">Biaya Pajak</label>
                            <input type="number" class="form-control" id="total_pajak" name="total_pajak"
                                value="">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox1 = document.getElementById('noticeBatal');
        const nopol = document.getElementById('nopol');
        const nama = document.getElementById('nama');
        const alamat = document.getElementById('alamat');
        const total_pajak = document.getElementById('total_pajak');
        const keterangan = document.getElementById('keterangan');

        console.log(checkbox1, nopol, nama, alamat, total_pajak, keterangan); // Debugging output

        const toggleInputs = () => {
            console.log('Checkbox status:', checkbox1.checked); // Debugging output
            if (checkbox1.checked) {
                nama.value = "";
                nopol.value = "";
                alamat.value = "";
                total_pajak.value = "";
                keterangan.value = "";
                nama.readOnly = true;
                nopol.readOnly = true;
                alamat.readOnly = true;
                total_pajak.readOnly = true;
                keterangan.readOnly = true;
            } else {
                nama.readOnly = false;
                nopol.readOnly = false;
                alamat.readOnly = false;
                total_pajak.readOnly = false;
                keterangan.readOnly = false;
            }
        };

        checkbox1.addEventListener('change', toggleInputs);
        toggleInputs();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox1 = document.getElementById('noticeBatal');
        const nopol = document.getElementById('nopol');
        const nama = document.getElementById('nama');
        const alamat = document.getElementById('alamat');
        const total_pajak = document.getElementById('total_pajak');
        const keterangan = document.getElementById('keterangan');

        console.log(checkbox1, nopol, nama, alamat, total_pajak, keterangan); // Debugging output

        const toggleInputs = () => {
            console.log('Checkbox status:', checkbox1.checked); // Debugging output
            if (checkbox1.checked) {
                nama.value = "";
                nopol.value = "";
                alamat.value = "";
                total_pajak.value = "";
                keterangan.value = "";
                nama.readOnly = true;
                nopol.readOnly = true;
                alamat.readOnly = true;
                total_pajak.readOnly = true;
                keterangan.readOnly = true;
            } else {
                nama.readOnly = false;
                nopol.readOnly = false;
                alamat.readOnly = false;
                total_pajak.readOnly = false;
                keterangan.readOnly = false;
            }
        };

        checkbox1.addEventListener('change', toggleInputs);
        toggleInputs();
    });
</script>

<script src="assets/js/api.js"></script>
