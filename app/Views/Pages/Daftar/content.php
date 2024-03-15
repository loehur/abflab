<link rel="stylesheet" type="text/css" href="<?= $this->ASSETS_URL ?>plugins/openstreet/leaflet.css">

<?php
if (isset($_SESSION['log'])) {
    $log = $_SESSION['log'];
}
?>

<style>
    #map {
        width: 100%;
        height: 300px;
        border-radius: 5px;
    }
</style>
<form action="<?= $this->BASE_URL ?>Checkout/daftar" method="POST">
    <div class="container">
        <div style="max-width: 500px;">
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input type="text" class="form-control shadow-none" name="nama" required value="<?= isset($log['name']) ? $log['name'] : "" ?>" id="floatingInput">
                        <label for="floatingInput">Nama Lengkap</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input type="text" class="form-control shadow-none" <?= isset($log['hp']) ? "readonly" : "" ?> name="hp" required value="<?= isset($log['hp']) ? $log['hp'] : "" ?>" id="floatingInput1">
                        <label for="floatingInput1">Nomor HP (08..)</label>
                    </div>
                </div>
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input type="email" class="form-control shadow-none" name="email" required value="<?= isset($log['email']) ? $log['email'] : "" ?>" id="floatingInput1">
                        <label for="floatingInput1">Email</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input class="form-control shadow-none alamat" required name="alamat" value="<?= isset($log['address']) ? $log['address'] : "" ?>" id="floatingTextarea" />
                        <label for="floatingTextarea">Alamat (Jalan/No. Rumah)</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <select class="form-select" id="provinsi" name="provinsi" aria-label=".form-select-sm example" required>
                            <option selected value=""></option>
                            <?php
                            foreach ($data['provinsi'] as $dp) { ?>
                                <option value="<?= $dp['id'] ?>"><?= $dp['name'] ?></option>
                            <?php } ?>
                        </select>
                        <label for="provinsi">Provinsi</label>
                    </div>
                </div>
                <div class="col px-1 mb-1" id="selKota">
                    <div class="form-floating">
                        <small class='text-secondary'>Kota</small>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col px-1 mb-1" id="selKecamatan">
                    <small class='text-secondary'>Kecamatan</small>
                </div>
                <div class="col px-1 mb-1" id="selKodePos">
                    <small class='text-secondary'>Kode Pos</small>
                </div>
            </div>
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input readonly id="latitude" class="form-control shadow-none alamat" name="lat" value="<?= isset($log['latt']) ? $log['latt'] : "" ?>" required />
                        <label for="latitude">Latitude</label>
                    </div>
                </div>
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input readonly id="longitude" class="form-control shadow-none alamat" name="long" value="<?= isset($log['longt']) ? $log['longt'] : "" ?>" required />
                        <label for="longitude">Longitude</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col px-1 mb-1">
                <div id="map"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-auto px-1 mb-1">
                <a href="<?= $this->BASE_URL ?>Checkout"><button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button></a>
            </div>
            <div class="col px-1 mb-1">
                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
            </div>
        </div>

    </div>
</form>


<script src="<?= $this->ASSETS_URL ?>plugins/openstreet/leaflet.js"></script>
<script>
    var glat = <?= $data['geo']['lat'] ?>;
    var glong = <?= $data['geo']['long'] ?>;
    let mapOptions = {
        center: [glat, glong],
        zoom: 10
    }

    let map = new L.map('map', mapOptions);

    let layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
    map.addLayer(layer);

    $("div.leaflet-control-attribution").addClass("d-none");

    let marker = null;
    map.on('click', (event) => {

        if (marker !== null) {
            map.removeLayer(marker);
        }

        marker = L.marker([event.latlng.lat, event.latlng.lng]).addTo(map);

        document.getElementById('latitude').value = event.latlng.lat;
        document.getElementById('longitude').value = event.latlng.lng;

    })

    $(document).ready(function() {
        spinner(0);

        if (marker !== null) {
            map.removeLayer(marker);
        }

        marker = L.marker([glat, glong]).addTo(map);

        document.getElementById('latitude').value = event.latlng.lat;
        document.getElementById('longitude').value = event.latlng.lng;
    });

    $("#provinsi").on("change", function() {
        var val = $(this).val()
        if (val != "") {
            $("#selKota").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= $this->BASE_URL ?>Checkout/kota/" + val)
            })
        } else {
            $("#selKota").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("<small class='text-secondary'>Kota</small>");
            })
        }
        $("#selKecamatan").html("<small class='text-secondary'>Kecamatan</small>")
        $("#selKodePos").html("<small class='text-secondary'>Kode Pos</small>")
    })
</script>