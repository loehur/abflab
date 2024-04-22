<link rel="stylesheet" type="text/css" href="<?= PC::ASSETS_URL ?>plugins/openstreet/leaflet.css">

<?php if (isset($_SESSION['log'])) $log = $_SESSION['log']; ?>

<style>
    #map {
        width: 100%;
        height: 300px;
        border-radius: 5px;
    }
</style>

<form action="<?= PC::BASE_URL ?>Daftar/daftar" method="POST">
    <div class="container">
        <div style="max-width: 600px;" class="m-auto">
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input readonly id="latitude" class="form-control shadow-none alamat" name="lat" value="<?= isset($log['latt']) ? $log['latt'] : "" ?>" required />
                        <label for="latitude">Koordinat (Lat)</label>
                    </div>
                </div>
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input readonly id="longitude" class="form-control shadow-none alamat" name="long" value="<?= isset($log['longt']) ? $log['longt'] : "" ?>" required />
                        <label for="longitude">Koordinat (Long)</label>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col px-1 mb-1">
                    <div id="map"></div>
                </div>
            </div>
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input type="text" class="form-control shadow-none" name="nama" required value="<?= isset($log['name']) ? $log['name'] : "" ?>" id="floatingInput456">
                        <label for="floatingInput456">Nama Lengkap</label>
                    </div>
                </div>
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input type="text" class="form-control shadow-none" <?= isset($log['hp']) ? "readonly" : "" ?> name="number" required value="<?= isset($log['hp']) ? $log['hp'] : "" ?>" id="floatingInput1654">
                        <label for="floatingInput1654">Nomor HP (08..)</label>
                    </div>
                </div>
            </div>
            <?php if (!isset($_SESSION['log'])) { ?>
                <div class="row">
                    <div class="col px-1 mb-1">
                        <div class="form-floating">
                            <input type="password" class="form-control shadow-none" required name="pw1" id="floatingTextareasdf" />
                            <label for="floatingTextareasdf">Password</label>
                        </div>
                    </div>
                    <div class="col px-1 mb-1">
                        <div class="form-floating">
                            <input type="password" type="email" class="form-control shadow-none" name="pw2" required id="floatingInput1sdfasd">
                            <label for="floatingInput1sdfasd">Ulangi Password</label>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col px-1 mb-1">
                    <div class="form-floating">
                        <input class="form-control shadow-none" required name="alamat" value="<?= isset($log['address']) ? $log['address'] : "" ?>" id="floatingTextarea" />
                        <label for="floatingTextarea">Alamat</label>
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
                        <select class="form-select" id="provinsi" name="provinsi" aria-label=".form-select-sm example" required>
                            <option selected value=""></option>
                            <?php
                            foreach ($data['provinsi'] as $dp) { ?>
                                <option value="<?= base64_encode($dp) ?>"><?= str_replace("+", " ", $dp) ?></option>
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
            <div class="row">
                <div class="col px-1 mb-1" id="selKecamatan">
                    <small class='text-secondary'>Kecamatan</small>
                </div>
                <div class="col px-1 mb-1" id="selKodePos">
                    <small class='text-secondary'>Kode Pos</small>
                </div>
            </div>
            <div class="row mt-1 pt-2">
                <?php if (!isset($_SESSION['log'])) { ?>
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control shadow-none" required name="otp" placeholder="OTP" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="button" id="otp">Minta OTP</button>
                        </div>
                    </div>
                <?php } ?>
                <div class="col px-1 mb-1">
                    <button type="submit" class="btn bg-light shadow-sm w-100">
                        <?php if (!isset($_SESSION['log'])) { ?>
                            Register
                        <?php } else { ?>
                            Simpan
                        <?php } ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


<script src="<?= PC::ASSETS_URL ?>plugins/openstreet/leaflet.js"></script>
<script>
    var glat = <?= $data['geo']['lat'] ?>;
    var glong = <?= $data['geo']['long'] ?>;

    $(document).ready(function() {
        let mapOptions = {
            center: [glat, glong],
            zoom: 15
        }

        let map = new L.map('map', mapOptions);
        let layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        let marker = null;
        map.addLayer(layer);

        if (marker !== null) {
            map.removeLayer(marker);
        }
        marker = L.marker([glat, glong]).addTo(map);
        document.getElementById('latitude').value = glat;
        document.getElementById('longitude').value = glong;

        $("div.leaflet-control-attribution").addClass("d-none");

        map.on('click', (event) => {

            if (marker !== null) {
                map.removeLayer(marker);
            }

            marker = L.marker([event.latlng.lat, event.latlng.lng]).addTo(map);

            document.getElementById('latitude').value = event.latlng.lat;
            document.getElementById('longitude').value = event.latlng.lng;

        })

        spinner(0);
    });

    $("#provinsi").on("change", function() {
        var val = $(this).val()
        if (val != "") {
            $("#selKota").load("<?= PC::BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= PC::BASE_URL ?>Checkout/kota/" + val)
            })
        } else {
            $("#selKota").load("<?= PC::BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("<small class='text-secondary'>Kota</small>");
            })
        }
        $("#selKecamatan").html("<small class='text-secondary'>Kecamatan</small>")
        $("#selKodePos").html("<small class='text-secondary'>Kode Pos</small>")
    })

    $("#otp").click(function() {
        no = $("input[name=number]").val();
        if (no == "") {
            alert("Isi nomor dulu");
            return;
        }
        $.post("<?= PC::BASE_URL . $con ?>/req_otp", {
            number: no
        }, ).done(function(res) {
            alert(res);
        })
    })

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 0) {
                    alert("Success!");
                    window.location.href = "<?= PC::BASE_URL ?>Checkout";
                } else if (res == 1) {
                    window.location.href = "<?= PC::BASE_URL ?>Home";
                } else {
                    alert(res)
                }
            },
        });
    });
</script>