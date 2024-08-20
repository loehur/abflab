<?php $total = 0; ?>
<div class="container mb-3" style="min-height: 300px;">
    <div class="row">
        <div class="col" style="min-width: 360px;">
            <div class="row mb-2 mt-2">
                <div class="col border rounded py-2">
                    <?php
                    if (isset($_SESSION['log'])) {
                        $d = $_SESSION['log']; ?>
                        <div class="row">
                            <div class="col mt-auto"><?= $d['name'] ?></div>
                            <div class="col text-end"><a href="<?= PC::BASE_URL ?>Daftar"><small>Ubah Data</small></a></div>
                        </div>
                        <div class="row">
                            <div class="col"><?= $d['hp'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><?= $d['area_name'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><?= $d['address'] ?></div>
                        </div>
                    <?php } else { ?>
                        <a class="btn btn-sm btn-primary shadow-none" href="<?= PC::BASE_URL ?>Daftar">Registrasi / Atur Alamat</a>
                        <a class="btn btn-sm btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#">Login</a>
                    <?php }
                    ?>
                </div>
            </div>
            <di class="row">
                <div class="col p-0">
                    <?php
                    if (isset($_SESSION['log'])) {
                        $d = $_SESSION['log'];
                        $str = $d['area_id'] . $d['latt'] . $d['longt'] . $_SESSION['cart_key'];
                        if (isset($_SESSION['ongkir'][$str])) {
                            $ongkir = $_SESSION['ongkir'][$str];
                        } else {
                            $ongkir = $this->model("Biteship")->cek_ongkir($d['area_id'], $d['latt'], $d['longt']);
                            $_SESSION['ongkir'][$str] = $ongkir;
                        }
                    ?>
                        <form id="bayar" action="<?= PC::BASE_URL ?>Checkout/ckout" method="POST">
                            <div class="form-floating mb-2">
                                <select class="form-select shadow-none" id="kurir" name="kurir" aria-label=".form-select-sm example" required>
                                    <option selected value=""></option>
                                    <option data-harga="0" value="abf|pickup">Jemput ke Toko Rp0</option>
                                    <?php
                                    foreach ($ongkir as $dp) { ?>
                                        <option data-harga="<?= $dp['price'] ?>" value="<?= $dp['company'] ?>|<?= $dp['type'] ?>"><?= $dp['courier_name'] ?> <?= $dp['courier_service_name'] ?> Rp<?= number_format($dp['price']) ?></option>
                                    <?php } ?>
                                </select>
                                <label for="provinsi">Pengiriman</label>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <button type="submit" class="btn btn-success px-4">Checkout</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </di>
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
                        <?php
                        $lj = 0;
                        $diskon_ongkir = 0;
                        foreach (PC::DISKON_ONGKIR as $key => $jumlah) {
                            if ($total >= $jumlah) {
                                if ($jumlah > $lj) {
                                    $diskon_ongkir = ($key / 100) * $total;
                                }
                            }
                            $lj = $jumlah;
                        }
                        ?>
                        <tr>
                            <td>Diskon Ongkir</td>
                            <td class="text-end" id="dis_ongkir">0</td>
                        </tr>
                    </table>
                </small>

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
        ongkir(0);
    });
    var sub = <?= $total ?>;
    var dis_ongkir = <?= $diskon_ongkir ?>;

    function ongkir(biaya) {
        if (parseInt(dis_ongkir) > parseInt(biaya)) {
            dis_ongkir = biaya;
        }
        $("td#ongkir").html("Rp" + addCommas(biaya));
        $("td#dis_ongkir").html("Rp" + addCommas(dis_ongkir));
        var new_total = parseInt(sub) + parseInt(biaya) - parseInt(dis_ongkir);
        $("#total").html("Rp" + addCommas(new_total))
    }

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

    $("#kurir").on("change", function() {
        if ($(this).val() == "") {
            ongkir(0);
        } else {
            biaya = parseInt($(this).find(':selected').data('harga'));
            ongkir(biaya);
        }
    })
</script>