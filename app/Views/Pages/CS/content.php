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
            <a href="<?= $this->BASE_URL ?>CS/index/bb" class="btn-sm nav-link <?= $parse == 'bb' ? 'active' : '' ?>">Belum Bayar</a>
            <a href="<?= $this->BASE_URL ?>CS/index/paid" class="btn-sm nav-link <?= $parse == 'paid' ? 'active' : '' ?>">Proses</a>
            <a href="<?= $this->BASE_URL ?>CS/index/sent" class="btn-sm nav-link <?= $parse == 'sent' ? 'active' : '' ?>">Dikirim</a>
            <a href="<?= $this->BASE_URL ?>CS/index/done" class="btn-sm nav-link <?= $parse == 'done' ? 'active' : '' ?>">Selesai</a>
            <a href="<?= $this->BASE_URL ?>CS/index/cancel" class="btn-sm nav-link <?= $parse == 'cancel' ? 'active' : '' ?>">Dibatalkan</a>
        </div>
    </nav>
    <div class="tab-content mx-1 mt-1">
        <div class="tab-pane show active">
            <div class="row">
                <div class="col pt-2 px-3">
                    <?php
                    foreach ($data['order'] as $key => $d) {
                        $ref = $key;
                        $customer_id = $data['step'][$key]['customer'];
                        $d_customer = $this->db(0)->get_where_row("customer", "customer_id = '" . $customer_id . "'");
                        $customer = $d_customer['name'];
                        $insertTime = $data['step'][$key]['time'];
                        $start_date = new DateTime($insertTime);
                        $since_start = $start_date->diff(new DateTime(date("Y-m-d H:i:s")));
                    ?>
                        <div class="row">
                            <div class="col mx-2 border rounded pb-2 mb-2">
                                <small>
                                    <table class="mt-1 table-light w-auto mt-2">
                                        <tr>
                                            <td><span style="cursor: pointer;" class="text-success" onclick="cs_detail(<?= $ref ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal_cs"><?= $customer ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><?= $insertTime ?> <small class="text-dark"><b>(<?= $since_start->days ?> Hari, <?= $since_start->h ?> Jam)</b></small></td>
                                        </tr>
                                        <tr>
                                            <td>REF#<?= $ref ?></td>
                                        </tr>
                                        <span class="float-end text-warning"><?= $status ?></span>
                                    </table>
                                </small>
                                <div class="border-top mt-2">
                                    <small>
                                        <table class="table table-sm desktop">
                                            <?php
                                            $total = 0;
                                            foreach ($d as $da) {
                                                if ($da['order_ref'] == $ref) {
                                                    $subTotal = $da['total'];
                                                    $total += $subTotal;
                                            ?>
                                                    <tr>
                                                        <td style="width: 10px;"><?= strlen($da['file']) > 0 ? '<a href="' . $da['file'] . '" download><i class="fa-regular fa-circle-down"></i></a>' : '' ?></td>
                                                        <td><?= $da['product'] ?>, <?= $da['detail'] ?></td>
                                                        <td><small class="text-danger"><?= $da['note'] ?></small></td>
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
                                                <td></td>
                                                <td>Pengiriman:</td>
                                                <td><?= $deliv['courier_company'] ?> <?= $deliv['courier_type'] ?></td>
                                                <td></td>
                                                <td class="text-end">Rp<?= number_format($deliv['price_paid']) ?>/<?= number_format($deliv['price']) ?></td>
                                            </tr>
                                        </table>
                                        <table class="table table-sm table-borderless mobile">
                                            <?php
                                            $total = 0;
                                            foreach ($d as $da) {
                                                if ($da['order_ref'] == $ref) {
                                                    $subTotal = $da['total'];
                                                    $total += $subTotal;
                                            ?>
                                                    <tr>
                                                        <td style="width: 10px;">
                                                            <a href="<?= $da['file'] ?>" download>
                                                                <i class="fa-regular fa-circle-down"></i>
                                                            </a> <small><?= $da['product'] ?>, <?= $da['detail'] ?><br><span class="text-danger"><?= $da['note'] ?></span></small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end"><?= $da['qty'] ?>pcs, Rp<?= number_format($subTotal) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border-top"></td>
                                                    </tr>
                                            <?php }
                                            }
                                            ?>
                                            <?php
                                            $where_d = "order_ref = '" . $ref . "'";
                                            $deliv = $this->db(0)->get_where_row("delivery", $where_d);
                                            ?>
                                            <tr>
                                                <td>Pengiriman: <?= $deliv['courier_company'] ?> <?= $deliv['courier_type'] ?> <span class="float-end">RpRp<?= number_format($deliv['price_paid']) ?>/<?= number_format($deliv['price']) ?></span></td>
                                            </tr>
                                        </table>
                                    </small>
                                </div>
                                <?php
                                $total_ = $total + $deliv['price_paid'];
                                $where_p = "order_ref = '" . $ref . "'";
                                $pay = $this->db(0)->get_where_row("payment", $where_p);
                                ?>
                                <div class="float-end fw-bold me-1">Rp<?= number_format($total_) ?></div>
                                <div class="">
                                    <?php
                                    switch ($pay['transaction_status']) {
                                        case 0:
                                        case 1: ?>
                                            <span data-ref="<?= $ref ?>" data-cust="<?= $da['customer_id'] ?>" class="btn btn-sm mb-1 btn-outline-success ms-2 terima">Terima Pembayaran</span>
                                            <span data-ref="<?= $ref ?>" data-cust="<?= $da['customer_id'] ?>" class="btn btn-sm mb-1 btn-outline-danger ms-2 batal">Batalkan Order</span>
                                        <?php
                                            break;
                                        case 2: ?>
                                            <span data-ref="<?= $ref ?>" data-cust="<?= $da['customer_id'] ?>" data-deliv="<?= $deliv['delivery'] ?>" data-mode="<?= $deliv['delivery'] ?>" class="btn btn-sm mb-1 btn-outline-success ms-2 selesai">Orderan Selesai</span>
                                            <span data-ref="<?= $ref ?>" data-cust="<?= $da['customer_id'] ?>" class="btn btn-sm mb-1 btn-outline-danger ms-2 batal">Batalkan Order</span>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="exampleModal_cs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Customer Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal_content">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        device();
        spinner(0);
    });

    $("span.batal").click(function() {
        var note = prompt("Alasan Dibatalkan", "");
        if (note === null) {
            return;
        }
        var cust_ = $(this).attr("data-cust");
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= $this->BASE_URL ?>CS/batalkan",
            data: {
                ref: ref,
                cust: cust_,
                cs_note: note
            },
            type: "POST",
            success: function(result) {
                content("b");
            },
        });
    });

    $("span.terima").click(function() {
        var cust_ = $(this).attr("data-cust");
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= $this->BASE_URL ?>CS/terima",
            data: {
                ref: ref,
                cust: cust_,
            },
            type: "POST",
            success: function(result) {
                content("p");
            },
        });
    });

    $("span.selesai").click(function() {
        var mode = $(this).attr("data-mode");
        var resi = "";
        if (mode == 3) {
            var resi = prompt("No. Resi Pengiriman", "");
            if (resi === null) {
                return;
            }
        }
        var deliv_ = $(this).attr("data-deliv");
        var cust_ = $(this).attr("data-cust");
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= $this->BASE_URL ?>CS/selesai",
            data: {
                ref: ref,
                cust: cust_,
                deliv: deliv_,
                resi: resi
            },
            type: "POST",
            success: function(result) {
                content("s");
            },
        });
    });
</script>