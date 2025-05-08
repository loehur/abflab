<?php $total = 0; ?>
<div class="container mb-3" style="min-height: 300px;">
    <div class="row mx-0">
        <div class="col px-1" style="min-width: 300px;">
            <div class="row mx-0 mb-2 mt-2">
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
            <di class="row mx-0">
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
                        } ?>
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
        <div class="col px-1 pb-5">
            <?php if (isset($_SESSION['cart'])) {
                $berat_total = 0; ?>
                <?php if ($_SESSION['new_user'] == true) {
                    if (count(PC::DISKON_NEW_USER) > 0) { ?>
                        <?php foreach (PC::DISKON_NEW_USER as $key => $d) { ?>
                            <?php if ($d['EX'] >= date("Ymd")) { ?>
                                <div class="alert alert-success">Promo Pelanggan Baru!<br>
                                    <b>Rp<?= $d['P'] ?></b> Item <?= $data['produk'][$key]['produk'] ?>. <small>(Maksimal Belanja <?= number_format($d['M']) ?>)</small>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>

                <u><small>Rincian Belanja</small></u>
                <small>
                    <table class="table table-sm">
                        <?php
                        $diskon_belanja = 0;
                        foreach ($_SESSION['cart'] as $key => $c) {

                            if ($_SESSION['new_user'] == true) {
                                if (isset(PC::DISKON_NEW_USER[$c['produk_id']])) {
                                    $dn = PC::DISKON_NEW_USER[$c['produk_id']];
                                    if ($c['total'] > $dn['P']) {
                                        if (!isset($_SESSION['diskon_new'])) {
                                            if ($c['total'] >= $dn['M']) {
                                                $diskon_new = $dn['M'] - $dn['P'];
                                            } else {
                                                $diskon_new = $c['total'] - $dn['P'];
                                            }
                                            $_SESSION['diskon_new'][$key] = $diskon_new;
                                        }
                                    }
                                }
                            }

                            $berat_total += $c['berat'];
                            $image = false;
                            $imageExt = array('png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');

                            foreach ($imageExt as $ie) {
                                if (str_contains($c['file'], $ie)) {
                                    $image = true;
                                }
                            }

                            $diskon = 0;
                            if (isset($_SESSION['diskon_new'][$key])) {
                                $diskon = $_SESSION['diskon_new'][$key];
                            }

                            $total += ($c['total'] - $diskon); ?>

                            <tr>
                                <td>
                                    <small><?= $c['produk'] ?>, <?= $c['detail'] ?></small><br>
                                    <small class="text-danger"><?= $c['note'] ?></small>
                                </td>
                                <td class="text-end"><?= $c['jumlah'] ?>pcs <?= isset($_SESSION['diskon_new'][$key]) ? "<s>Rp" . number_format($c['total']) . "</s>" : "" ?> Rp<?= number_format($c['total'] - $diskon) ?></td>
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

                        //DISKON BELANJA
                        $_SESSION['diskon_belanja'] = 0;
                        $lj2 = 0;
                        foreach (PC::DISKON_BELANJA as $key => $jumlah) {
                            if ($total >= $jumlah) {
                                if ($jumlah > $lj2) {
                                    $diskon_belanja = ($key / 100) * $total;
                                }
                            }
                            $lj2 = $jumlah;
                        }

                        $_SESSION['diskon_belanja'] = $diskon_belanja;
                        ?>

                        <tr>
                            <td>Diskon Ongkir</td>
                            <td class="text-end" id="dis_ongkir">0</td>
                        </tr>
                        <tr>
                            <td>Diskon Belanja</td>
                            <td class="text-end" id="dis_belanja">0</td>
                        </tr>
                        <tr>
                            <?php
                            $diskon_aff = 0;
                            $code_used = ""
                            ?>
                            <?php if (isset($_SESSION['diskon_aff']) && count($_SESSION['diskon_aff'])) {
                                foreach ($_SESSION['diskon_aff'] as $da) {
                                    $diskon_aff += $da['diskon_buyer'];
                                    $code_used = $da['code'];
                                } ?>
                            <?php } ?>

                            <td>
                                <?php if (isset($_SESSION['diskon_aff']) && count($_SESSION['diskon_aff'])) { ?>
                                    <span class="text-success">Diskon Promo (<b><?= $code_used ?></b>)</span>
                                <?php } else { ?>
                                    <div class="text-sm text-success" data-bs-toggle="modal" data-bs-target="#exampleModalPromo" style="cursor: pointer;">Masukkan Kode Promo</div>
                                <?php } ?>
                            </td>
                            <td class="text-end">
                                <?php if (isset($_SESSION['diskon_aff']) && count($_SESSION['diskon_aff'])) { ?>
                                    <span class="text-success">Rp<?= number_format($diskon_aff) ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </small>

                <div class="text-end border-0 fw-bold float-end pe-1" id="total"></div>
            <?php } else { ?>
                Tidak ada data keranjang
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal" id="exampleModalPromo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukkan Kode Promo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= PC::BASE_URL ?>Afiliator/cek_promo" class="ajax" method="POST">
                <div class="modal-body">
                    <div class="form-floating mb-2">
                        <input type="text" style="text-transform: uppercase;" class="form-control" name="code" required id="floatingInput11">
                        <label for="floatingInput11">Kode Promo</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" data-bs-dismiss="modal">Cek</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        spinner(0);
        ongkir(0);
    });
    var sub = <?= $total ?>;

    $("form.ajax").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res)
                }
            },
        });
    });

    function ongkir(biaya) {
        var dis_ongkir = <?= $diskon_ongkir ?>;
        var dis_belanja = <?= $diskon_belanja ?>;
        var dis_aff = <?= $diskon_aff ?>;

        if (dis_ongkir > biaya) {
            dis_ongkir = biaya;
        }
        $("td#ongkir").html("Rp" + addCommas(biaya));
        $("td#dis_ongkir").html("Rp" + addCommas(dis_ongkir));
        $("td#dis_belanja").html("Rp" + addCommas(dis_belanja));
        var new_total = parseInt(sub) + parseInt(biaya) - parseInt(dis_ongkir) - parseInt(dis_belanja) - parseInt(dis_aff);
        $("#total").html("Rp" + addCommas(new_total));
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