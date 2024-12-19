const caridataaa = document.getElementById("caridataaa");
caridataaa.addEventListener("click", function () {
    const nopol = document.getElementById("nopol").value;
    console.log(nopol);
    fetch(`api/plat?plat=${nopol}`)
        .then((response) => response.json())
        .then((responseData) => {
            console.log("Response Received:", responseData);
            const alertContainer = document.getElementById("alert-container");
            const data = responseData.data;
            if (data) {
                document.getElementById("nama").value = data.nama;
                document.getElementById("alamat").value = data.alamat;
                document.getElementById("total_pajak").value = data.total_pajak;
                document.getElementById("keterangan").value = data.keterangan;
                alertContainer.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Data ditemukan
            </div>
        `;
            } else {
                document.getElementById("nama").value = "";
                document.getElementById("alamat").value = "";
                document.getElementById("total_pajak").value = "";
                document.getElementById("keterangan").value = "";
                alertContainer.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Data tidak ditemukan
            </div>
        `;
            }
        });
});
