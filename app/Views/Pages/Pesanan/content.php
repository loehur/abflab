<style>
    .tabbable .nav-tabs {
        overflow-x: auto;
        overflow-y: hidden;
        flex-wrap: nowrap;
    }

    .tabbable .nav-tabs .nav-link {
        white-space: nowrap;
    }
</style>

<div class="container mb-3 pt-2" style="min-height: 300px;">
    <nav class="tabbable">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <?php foreach ($data as $k => $d) {
                $tab = "";
                switch ($k) {
                    case 'p':
                        $tab = "Dalam Proses";
                        break;
                    case 's':
                        $tab = "Dikirim/Selesai";
                        break;
                    case 'b':
                        $tab = "Dibatalkan";
                        break;
                    default:
                        $tab = "Belum Bayar";
                        break;
                }
            ?>
                <button class="btn-sm nav-link <?= ($k == 'bb') ? 'active' : '' ?>" id="nav-<?= $k ?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?= $k ?>" type="button" role="tab" aria-controls="nav-<?= $k ?>" aria-selected="true"><?= $tab ?></button>
            <?php } ?>
        </div>
    </nav>
    <div class="tab-content mx-1 mt-1" id="nav-tabContent">
        <?php foreach ($data as $k => $d) { ?>
            <div class="tab-pane <?= ($k == 'bb') ? 'show active' : '' ?>" id="nav-<?= $k ?>" role="tabpanel" aria-labelledby="nav-<?= $k ?>-tab">
                <?php
                $ref = "";
                foreach ($data[$k] as $d) {
                    $new_ref = $d['order_ref'];

                    if ($ref <> $new_ref) {
                        $ref = $new_ref;
                    } else {
                        continue;
                    }
                ?>
                    <div class="row desktop">
                        <div class="col mx-2 border rounded pb-2 py-2 mb-2">
                            <u>Order Ref. <?= $ref ?></u>
                            <small>
                                <table class="table table-sm">
                                    <?php
                                    $total = 0;
                                    foreach ($data[$k] as $da) {
                                        if ($da['order_ref'] == $ref) {
                                            $subTotal = $da['total'];
                                            $total += $subTotal;
                                    ?>
                                            <tr>
                                                <td><?= $da['product'] ?>, <?= $da['detail'] ?></td>
                                                <td>Note: <?= $da['note'] ?></td>
                                                <td class="text-end"><?= $da['qty'] ?>pcs</td>
                                                <td class="text-end">Rp<?= number_format($subTotal) ?></td>
                                            </tr>
                                    <?php }
                                    }
                                    ?>
                                    <?php
                                    $where_d = "order_ref = '" . $ref . "'";
                                    $deliv = $this->db(0)->get_where_row("delivery", $where_d);
                                    ?>
                                    <tr>
                                        <td>Ongkir</td>
                                        <td><?= $deliv['courier'] ?> <?= $deliv['service'] ?></td>
                                        <td></td>
                                        <td class="text-end">Rp<?= number_format($deliv['total']) ?></td>
                                    </tr>
                                </table>
                            </small>
                            <?php
                            ?>
                            <span class="">
                                <?php
                                $where_p = "order_ref = '" . $ref . "'";
                                $pay = $this->db(0)->get_where_row("payment", $where_p);
                                switch ($pay['payment_status']) {
                                    case 0: ?>
                                        <a href="<?= $this->BASE_URL ?>Bayar/index/<?= $ref ?>" class="btn btn-sm btn-danger">Bayar</a>
                                        <span class="text-warning ps-2"><small>Menunggu Pembayaran</small></span>
                                    <?php
                                        break;
                                    case 1: ?>
                                        <span class="text-info"><small>Dalam Pengecekan</small></span>
                                <?php }
                                ?>
                            </span>
                            <div class="float-end fw-bold me-1">Rp<?= number_format($total + $deliv['total']) ?></div>
                        </div>
                    </div>
                    <div class="row mobile">
                        <div class="col mx-2 border rounded py-2 mb-2">
                            <small><u>Order Ref. <?= $ref ?></u></small>
                            <small>
                                <table class="table table-sm">
                                    <?php
                                    $total = 0;
                                    foreach ($data[$k] as $da) {
                                        if ($da['order_ref'] == $ref) {
                                            $subTotal = $da['total'];
                                            $total += $subTotal;
                                    ?>
                                            <tr>
                                                <td><?= $da['product'] ?> <?= $da['detail'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-end"><?= $da['qty'] ?>pcs</td>
                                            </tr>
                                            <tr>
                                                <td class="text-end">Rp<?= number_format($subTotal) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Note: <?= $da['note'] ?></td>
                                            </tr>
                                    <?php }
                                    }
                                    ?>
                                    <?php
                                    $where_d = "order_ref = '" . $ref . "'";
                                    $deliv = $this->db(0)->get_where_row("delivery", $where_d);
                                    ?>
                                    <tr>
                                        <td>Ongkir <?= $deliv['courier'] ?> <?= $deliv['service'] ?>, <span class="float-end">Rp<?= number_format($deliv['total']) ?></span></td>
                                    </tr>
                                </table>
                            </small>
                            <?php
                            ?>
                            <span class="">
                                <?php
                                $where_p = "order_ref = '" . $ref . "'";
                                $pay = $this->db(0)->get_where_row("payment", $where_p);
                                switch ($pay['payment_status']) {
                                    case 0: ?>
                                        <a href="<?= $this->BASE_URL ?>Bayar/index/<?= $ref ?>" class="btn btn-sm btn-danger">Bayar</a>
                                        <span class="text-warning ps-2"><small>Menunggu Pembayaran</small></span>
                                    <?php
                                        break;
                                    case 1: ?>
                                        <span class="text-info"><small>Dalam Pengecekan</small></span>
                                <?php }
                                ?>
                            </span>
                            <div class="float-end fw-bold me-1">Rp<?= number_format($total + $deliv['total']) ?></div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        device();
        spinner(0);
    });
</script>