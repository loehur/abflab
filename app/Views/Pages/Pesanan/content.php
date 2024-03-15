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

<?php
$parse = $data['parse'];
switch ($parse) {
    case 'paid':
        $status = "Proses";
        break;
    case 'sent':
        $status = "Dikirim";
        break;
    case 'done':
        $status = "Selesai";
        break;
    case 'cancel':
        $status = "Dibatalkan";
        break;
    default:
        $status = "Belum Bayar";
        break;
}
?>

<div class="container mb-3 pt-2" style="min-height: 300px;">
    <nav class="tabbable">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a href="<?= $this->BASE_URL ?>Pesanan/index/bb" class="btn-sm nav-link <?= $parse == 'bb' ? 'active' : '' ?>">Belum Bayar</a>
            <a href="<?= $this->BASE_URL ?>Pesanan/index/paid" class="btn-sm nav-link <?= $parse == 'paid' ? 'active' : '' ?>">Proses</a>
            <a href="<?= $this->BASE_URL ?>Pesanan/index/sent" class="btn-sm nav-link <?= $parse == 'sent' ? 'active' : '' ?>">Dikirim</a>
            <a href="<?= $this->BASE_URL ?>Pesanan/index/done" class="btn-sm nav-link <?= $parse == 'done' ? 'active' : '' ?>">Selesai</a>
            <a href="<?= $this->BASE_URL ?>Pesanan/index/cancel" class="btn-sm nav-link <?= $parse == 'cancel' ? 'active' : '' ?>">Dibatalkan</a>
        </div>
    </nav>
    <div class="tab-content mx-1 mt-1">
        <div class="tab-pane show active">
            <?php
            foreach ($data['order'] as $key => $d) {
                $ref = $key;
            ?>
                <div class="row desktop">
                    <div class="col mx-2 border rounded pb-2 py-2 mb-2">
                        <u>Order Ref. <?= $ref ?></u> <span class="float-end text-warning"><small><?= $status ?></small></span>
                        <small>
                            <table class="table table-sm">
                                <?php
                                $total = 0;
                                foreach ($d as $da) {
                                    $subTotal = $da['total'];
                                    $total += $subTotal;
                                ?>
                                    <tr>
                                        <td><?= $da['product'] ?>, <?= $da['detail'] ?></td>
                                        <td class="text=danger"><small class="text-danger"><?= $da['note'] ?></small></td>
                                        <td class="text-end"><?= $da['qty'] ?>pcs</td>
                                        <td class="text-end">Rp<?= number_format($subTotal) ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                $where_d = "order_ref = '" . $ref . "'";
                                $deliv = $this->db(0)->get_where_row("delivery", $where_d);
                                ?>
                                <tr>
                                    <td>Pengiriman:</td>
                                    <td><?= $deliv['courier_company'] ?> <?= $deliv['courier_type'] ?></td>
                                    <td></td>
                                    <td class="text-end">Rp<?= number_format($deliv['price_paid']) ?></td>
                                </tr>
                            </table>
                        </small>
                        <?php
                        ?>
                        <span class="">
                            <?php if ($parse == "bb") {
                                $where_p = "order_ref = '" . $ref . "'";
                                $pay = $this->db(0)->get_where_row("payment", $where_p);
                            ?>
                                <a target="_blank" href="<?= $pay['redirect_url'] ?>" class="btn btn-sm btn-danger">Bayar</a>
                            <?php } ?>
                        </span>
                        <div class="float-end fw-bold me-1">Rp<?= number_format($total + $deliv['price_paid']) ?></div>
                    </div>
                </div>
                <div class="row mobile">
                    <div class="col mx-2 border rounded py-2 mb-2">
                        <small><u>Ref#<?= $ref ?></u></small> <small><span class="float-end text-warning"><?= $tab ?></span></small>
                        <small>
                            <table class="table table-sm table-borderless">
                                <?php
                                $total = 0;
                                foreach ($d as $da) {
                                    $subTotal = $da['total'];
                                    $total += $subTotal;
                                ?>
                                    <tr>
                                        <td><small><?= $da['product'] ?> <?= $da['detail'] ?></small><br>
                                            <small class="text-danger">
                                                <?= $da['note'] ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><?= $da['qty'] ?>pcs, Rp<?= number_format($subTotal) ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                                $where_d = "order_ref = '" . $ref . "'";
                                $deliv = $this->db(0)->get_where_row("delivery", $where_d);
                                ?>
                                <tr>
                                    <td>Pengiriman: <?= $deliv['courier_company'] ?> <?= $deliv['courier_type'] ?> <span class="float-end">Rp<?= number_format($deliv['total']) ?></span></td>
                                </tr>
                            </table>
                        </small>
                        <?php
                        ?>
                        <span class="">
                            <?php if ($parse == "bb") {
                                $where_p = "order_ref = '" . $ref . "'";
                                $pay = $this->db(0)->get_where_row("payment", $where_p);
                            ?>
                                <a target="_blank" href="<?= $pay['redirect_url'] ?>" class="btn btn-sm btn-danger">Bayar</a>
                            <?php } ?>
                        </span>
                        <div class="float-end fw-bold me-1">Rp<?= number_format($total + $deliv['total']) ?></div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        device();
        spinner(0);
    });
</script>