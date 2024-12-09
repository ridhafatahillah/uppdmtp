<div {{ $attributes }}tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="container-fluid" id="alert-containerr"></div>
                    <form method="post" id="formEdit" action="updateData">
                        @csrf
                        <input type="date" value='' name="tanggal" id="tanggal" hidden>
                        <input type="number" name="id" id="idUpdate" value="" hidden>
                        <div class="mb-3">
                            <label for="nama" class="form-label">No Notes</label>
                            <input type="number" class="form-control" id="no_noticee" name="no_notice" value=""
                                readonly>
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-4">
                                        <input type="checkbox" id="noticeBaruu" name="baru">
                                        <label for="noticeBaruu">Notes Baru</label>
                                    </div>
                                    <div class="col-4">
                                        <input type="checkbox" id="noticeBatall" name="kondisi" value="rusak">
                                        <label for="noticeBatall">Notes Batal</label>
                                    </div>
                                    {{-- <div class="col-4">
                                    <input type="checkbox" id="noticeRusak" name="rusak">
                                    <label for="noticeRusak">Notes Rusak</label>
                                </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-end">
                            <div class="col-9">
                                <label for="nopol" class="form-label">No.Polisi</label>
                                <input type="text" class="form-control" id='nopoll' name="nopol" value="">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-primary" id="caridataa" type="button">Cari data</button>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="namaa" name="nama" value="">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamatt" name="alamat" value="">
                            </div>
                            <div class="mb-3">
                                <label for="total_pajak" class="form-label
                            ">Biaya
                                    Pajak</label>
                                <input type="number" class="form-control" id="total_pajakk" name="total_pajak"
                                    value="">
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangann" name="keterangan"
                                    value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalEdit = document.getElementById('modalEdit');
            modalEdit.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('id1');
                var no_notice = button.getAttribute('no-notice');
                var nopol = button.getAttribute('no-polisi');
                var nama = button.getAttribute('nama');
                var alamat = button.getAttribute('alamat');
                var total_pajak = button.getAttribute('total-pajak');
                var keterangan = button.getAttribute('ket');
                var kondisi = button.getAttribute('kondisi');
                var updateData = button.getAttribute('update');
                var baru = button.getAttribute('baru');
                var tanggal = button.getAttribute('tanggal');

                console.log(no_notice, nopol, nama, alamat, total_pajak, keterangan,
                    kondisi, updateData); // Debugging output

                var formId = document.getElementById('idUpdate');
                var formNama = document.getElementById('namaa');
                var formNopol = document.getElementById('nopoll');
                var formAlamat = document.getElementById('alamatt');
                var formTotalPajak = document.getElementById('total_pajakk');
                var formKeterangan = document.getElementById('keterangann');
                var formNoNotice = document.getElementById('no_noticee');
                var formKondisi = document.getElementById('noticeBatall');
                var formBaru = document.getElementById('noticeBaruu');
                var formTanggal = document.getElementById('tanggal');

                formId.value = id;
                formNama.value = nama;
                formNopol.value = nopol;
                formAlamat.value = alamat;
                formTotalPajak.value = total_pajak;
                formKeterangan.value = keterangan;
                formNoNotice.value = no_notice;
                formKondisi.checked = kondisi == 'rusak';
                formBaru.checked = baru == 'on';
                formTanggal.value = tanggal;


                if (formKondisi.checked) {
                    formNama.readOnly = true;
                    formNopol.readOnly = true;
                    formAlamat.readOnly = true;
                    formTotalPajak.readOnly = true;
                    formKeterangan.readOnly = true;
                } else {
                    formNama.readOnly = false;
                    formNopol.readOnly = false;
                    formAlamat.readOnly = false;
                    formTotalPajak.readOnly = false;
                    formKeterangan.readOnly = false;
                }


            });
        });
        // Select the checkbox and input field
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox1 = document.getElementById('noticeBatall');
            const nopol = document.getElementById('nopoll');
            const nama = document.getElementById('namaa');
            const alamat = document.getElementById('alamatt');
            const total_pajak = document.getElementById('total_pajakk');
            const keterangan = document.getElementById('keterangann');

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
        const caridataa = document.getElementById("caridataa");
        caridataa.addEventListener("click", function() {
            const nopol = document.getElementById("nopoll").value;
            console.log(nopol);
            fetch(`api/plat?plat=${nopol}`)
                .then((response) => response.json())
                .then((responseData) => {
                    console.log("Response Received:", responseData);
                    const alertContainer = document.getElementById("alert-containerr");
                    const data = responseData.data;
                    if (data) {
                        document.getElementById("namaa").value = data.nama;
                        document.getElementById("alamatt").value = data.alamat;
                        document.getElementById("total_pajakk").value = data.total_pajak;
                        document.getElementById("keterangann").value = data.keterangan;
                        alertContainer.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data ditemukan
            </div>
        `;
                    } else {
                        document.getElementById("namaa").value = "";
                        document.getElementById("alamatt").value = "";
                        document.getElementById("total_pajakk").value = "";
                        document.getElementById("keterangann").value = "";
                        alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data tidak ditemukan
            </div>
        `;
                    }
                });
        });
    </script>
