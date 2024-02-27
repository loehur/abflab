<div class="container mb-3" style="min-height: 300px;">
    <div class="row">
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
                                <?php if ($image == true) { ?>
                                    <img style="object-fit: contain;" height="50px" src="<?= $c['file'] ?>">
                                <?php } else {
                                    if (strlen($c['file']) == 0) {
                                        echo "No File";
                                    } else {
                                        echo "...." . substr($c['file'], -10);
                                    }
                                } ?>
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

                <a href="<?= $this->BASE_URL ?>Cart/clear" class="btn btn-outline-secondary">Clear Cart</a>
                <a href="<?= $this->BASE_URL ?>Checkout" class="btn btn-success float-end">Checkout</a>
            <?php } else { ?>
                Tidak ada data keranjang
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        spinner(0);
    });

    function add(id, mode) {
        $.post("<?= $this->BASE_URL ?>Session/add_cart", {
                id: id,
                mode: mode
            },
            function() {
                content();
            });
    }
</script>