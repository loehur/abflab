<div class="container mb-3" style="min-height: 300px;">
    <div class="row desktop">
        <div class="col">
            <?php
            if (isset($_SESSION['cart'])) {
                $total = 0; ?>
                <table class="table table-sm">
                    <tr>
                        <th>File</th>
                        <th>Item</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-end">Total</th>
                    </tr>
                    <?php foreach ($_SESSION['cart'] as $k => $c) {
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
                                <?php
                                switch ($c['metode_file']) {
                                    case 1:
                                        if ($image == true) { ?>
                                            <img style="object-fit: contain;" height="50px" src="<?= $c['file'] ?>">
                                        <?php } else {
                                            if (strlen($c['file']) == 0) {
                                                echo "No File";
                                            } else {
                                                if (strlen($c['file']) > 10) {
                                                    echo ".." . substr($c['file'], -10);
                                                } else {
                                                    echo $c['file'];
                                                }
                                            }
                                        }
                                        break;
                                    case 2: ?>
                                        <a href="<?= $c['link_drive'] ?>" target="_blank">Link Drive</a>
                                <?php break;
                                    default:
                                        echo "No File";
                                        break;
                                }
                                ?>
                            </td>
                            <td>
                                <?= $c['produk'] ?>, <?= $c['detail'] ?><br>
                                <small><?= $c['note'] ?></small>
                            </td>
                            <td class="text-end"><?= number_format($c['harga']) ?></td>
                            <td class="text-end">
                                <span class="btn btn-sm btn-light py-0" onclick="add(<?= $k ?>, 0)">-</span>
                                <span class="btn btn-sm" id="j<?= $k ?>"><?= $c['jumlah'] ?></span>
                                <span class="btn btn-sm btn-light py-0" onclick="add(<?= $k ?>, 1)">+</span>
                            </td>
                            <td class="text-end"><?= number_format($c['total']) ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="text-end border-0" colspan="4"><b>TOTAL</b></td>
                        <td class="text-end border-0"><b><?= number_format($total) ?></b></td>
                    </tr>
                </table>

                <a href="<?= PC::BASE_URL ?>Cart/clear" class="text-secondary"><small>Kosongkan Keranjang</small></a>
                <a href="<?= PC::BASE_URL ?>Checkout" class="btn btn-primary float-end">Pilih Pengiriman</a>
            <?php } else { ?>
                Tidak ada data keranjang
            <?php } ?>
        </div>
    </div>
    <div class="row mobile">
        <div class="col">
            <?php
            if (isset($_SESSION['cart'])) {
                $total = 0; ?>
                <table class="table table-sm table-borderless">
                    <?php foreach ($_SESSION['cart'] as $k => $c) {
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
                                <small>
                                    <?php
                                    switch ($c['metode_file']) {
                                        case 1:
                                            if ($image == true) { ?>
                                                <img style="object-fit: contain;" height="50px" src="<?= $c['file'] ?>">
                                            <?php } else {
                                                if (strlen($c['file']) == 0) {
                                                    echo "No File";
                                                } else {
                                                    if (strlen($c['file']) > 10) {
                                                        echo ".." . substr($c['file'], -10);
                                                    } else {
                                                        echo $c['file'];
                                                    }
                                                }
                                            }
                                            break;
                                        case 2: ?>
                                            <a href="<?= $c['link_drive'] ?>" target="_blank">Link Drive</a>
                                    <?php break;
                                        default:
                                            echo "Email";
                                            break;
                                    }
                                    ?>
                                </small>
                            </td>
                            <td>
                                <small>
                                    <?= $c['produk'] ?>, <?= $c['detail'] ?><br>
                                    <span class="text-danger"><?= $c['note'] ?></span>
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="2">
                                <span class="btn btn-sm btn-light py-0" onclick="add(<?= $k ?>, 0)">-</span>
                                <span class="btn btn-sm" id="j<?= $k ?>"><?= $c['jumlah'] ?></span>
                                <span class="btn btn-sm btn-light py-0" onclick="add(<?= $k ?>, 1)">+</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end border-bottom"><small><?= number_format($c['total']) ?></small></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2">Total Pesanan <span class="float-end"><?= number_format($total) ?></span></b></td>
                    </tr>
                </table>

                <a href="<?= PC::BASE_URL ?>Cart/clear" class="text-secondary"><small>Kosongkan Keranjang</small></a>
                <a href="<?= PC::BASE_URL ?>Checkout" class="btn btn-sm btn-success float-end">Pilih Pengiriman</a>
            <?php } else { ?>
                Tidak ada data keranjang
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        device();
        spinner(0);
    });

    function add(id, mode) {
        $.post("<?= PC::BASE_URL ?>Session/add_cart", {
                id: id,
                mode: mode
            },
            function() {
                content();
            });
    }
</script>