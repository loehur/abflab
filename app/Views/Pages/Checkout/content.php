<?php $total = 0; ?>
<div class="container mb-3" style="min-height: 300px;">
    <div class="row">
        <div class="col" style="min-width: 360px;">
            <form id="bayar" action="<?= $this->BASE_URL ?>Pesanan/bayar" method="POST">
                <div class="row border-bottom mb-2 shadow-sm mt-2">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control nama" name="nama" required value="<?= (isset($_SESSION['nama'])) ? $_SESSION['nama'] : "" ?>" id="floatingInput">
                                    <label for="floatingInput">Nama Lengkap</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control hp" name="hp" required value="<?= (isset($_SESSION['hp'])) ? $_SESSION['hp'] : "" ?>" id="floatingInput1">
                                    <label for="floatingInput1">Nomor Handphone</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <input class="form-control form-control-sm alamat" required name="alamat" value="<?= (isset($_SESSION['alamat'])) ? $_SESSION['alamat'] : "" ?>" id="floatingTextarea" />
                                    <label for="floatingTextarea">Alamat Lengkap</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div class="form-check">
                            <input class="form-check-input radio_" type="radio" name="radio_kirim" value="1" data-val="0" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Jemput ke Toko
                            </label>
                            <div class="mt-1 px-2" id="jemput">
                                <span class="text-secondary"><small>Asia Baru Foto. Jl. Jend. Sudirman. No. 331 Pekanbaru. Telp. 0761 21883.</small></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <div class="row">
                                <div class="col">
                                    <input class="form-check-input radio_" type="radio" name="radio_kirim" data-val="<?= $this->SETTING['ongkir_toko'] ?>" value="2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Pengiriman via Kurir Toko <small class="text-danger">(Dalam Kota)</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="radio_kirim" value="3" data-val="">
                    <label class=" form-check-label" for="flexRadioDefault3">
                        Pengiriman via Ekspedisi
                    </label>
                    <div class="shadow-sm d-none border rounded mt-1 px-2 pt-2" id="antar">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <select class="form-select" id="provinsi" name="provinsi" aria-label=".form-select-sm example">
                                        <option selected value=""></option>
                                        <?php
                                        foreach ($data['provinsi'] as $dp) { ?>
                                            <option value="<?= $dp['province_id'] ?>"><?= $dp['province'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="provinsi">Provinsi</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col" id="selKota">
                                <div class="form-floating mb-2">
                                    <small class='text-secondary'>Kota</small>
                                </div>
                            </div>
                            <div class="col" id="selKecamatan">
                                <small class='text-secondary'>Kecamatan</small>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-floating mb-2">
                                    <select class="form-select" name="via" id="via">
                                        <option value="" selected></option>
                                        <?php foreach ($this->KURIR as $k) { ?>
                                            <option value="<?= $k ?>"><?= strtoupper($k)  ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="via">Pengiriman via</label>
                                </div>
                            </div>
                            <div class="col" id="selService">
                                <small class='text-secondary'>Service</small>
                            </div>
                        </div>
                    </div>
                </div>
                <input value="" type="hidden" name="ongkir" required>
                <button type="submit" id="submit_form" class="d-none"></button>
            </form>
        </div>
        <div class="col">
            <?php if (isset($_SESSION['cart'])) {
                $berat_total = 0; ?>
                <u><small>Rincian Belanja</small></u>
                <small>
                    <table class="table table-sm">
                        <?php
                        foreach ($_SESSION['cart'] as $c) {
                            $berat_total += $c['berat'];
                            $image = false;
                            $total += $c['total'];
                            $imageExt   = array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');

                            foreach ($imageExt as $ie) {
                                if (str_contains($c['file'], $ie)) {
                                    $image = true;
                                }
                            }
                        ?>
                            <tr>
                                <td>
                                    <small><?= $c['produk'] ?>, <?= $c['detail'] ?></small><br>
                                    <small class="text-danger"><?= $c['note'] ?></small>
                                </td>
                                <td class="text-end"><?= $c['jumlah'] ?>pcs, Rp<?= number_format($c['total']) ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Biaya Pengiriman</td>
                            <td class="text-end" id="ongkir"></td>
                        </tr>
                    </table>
                </small>

                <span id="submit_form" class="btn btn-outline-success px-4">Bayar</span>
                <div class="text-end border-0 fw-bold float-end" id="total"></div>
            <?php } else { ?>
                Tidak ada data keranjang
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        spinner(0);
        total("");
        $("input[name=ongkir]").val(0);
    });

    $('input:radio').change(function() {
        var data_val = $(this).attr("data-val");
        $("input[name=ongkir]").val(data_val);
        total(data_val);

        if ($(this).val() == 3) {
            $("#antar").removeClass("d-none");
            var luar_kota = $("select#service").val()
        }
    });


    var sub = <?= $total ?>;

    $(".alamat").on("change", function() {
        $.post("<?= $this->BASE_URL ?>Session/set", {
            name: "alamat",
            value: $(this).val()
        }, )
    })

    $(".nama").on("change", function() {
        $.post("<?= $this->BASE_URL ?>Session/set", {
            name: "nama",
            value: $(this).val()
        }, )
    })

    $(".hp").on("change", function() {
        $.post("<?= $this->BASE_URL ?>Session/set", {
            name: "hp",
            value: $(this).val()
        }, )

    })

    function total(ongkir) {
        if (ongkir == "") {
            $("td#ongkir").html("Rp0");
            ongkir = 0;
        } else {
            $("td#ongkir").html("Rp" + addCommas(ongkir));
        }
        var new_total = parseInt(sub) + parseInt(ongkir);
        $("#total").html("Rp" + addCommas(new_total))
    }

    $('.radio_').click(function() {
        $("#antar").addClass("d-none");
    })

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    $("#provinsi").on("change", function() {
        var val = $("#provinsi").val()
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
        $("#selService").html("<small class='text-secondary'>Service</small>")
        $('#via').prop('selectedIndex', 0);
    })

    $("#via").on("change", function() {
        var kec = $("#kecamatan").val()
        if (kec == undefined) {
            return;
        }
        var destination = $("#kecamatan").val()
        var courier = $(this).val()
        if (destination != "" && courier != "") {
            $("#selService").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= $this->BASE_URL ?>Checkout/cost/" + destination + "/" + courier + "/" + <?= $berat_total ?>)
            })
        }
    })

    $("span#submit_form").click(function(e) {
        if ($("input[name=ongkir]").val() == "") {
            alert("Data pengiriman tidak Valid");
            return;
        } else {
            $("button#submit_form").click();
        }
    });
</script>