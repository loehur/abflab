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
        $status = "Batal";
        break;
    default:
        $status = "Belum Bayar";
        break;
}
?>

<div class="container mb-3 pt-2" style="min-height: 300px;">
    <nav class="tabbable">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a href="<?= PC::BASE_URL ?>CS/index/bb" class="btn-sm nav-link <?= $parse == 'bb' ? 'active' : '' ?>">Belum Bayar</a>
            <a href="<?= PC::BASE_URL ?>CS/index/paid" class="btn-sm nav-link <?= $parse == 'paid' ? 'active' : '' ?>">Proses</a>
            <a href="<?= PC::BASE_URL ?>CS/index/sent" class="btn-sm nav-link <?= $parse == 'sent' ? 'active' : '' ?>">Dikirim</a>
            <a href="<?= PC::BASE_URL ?>CS/index/done" class="btn-sm nav-link <?= $parse == 'done' ? 'active' : '' ?>">Selesai</a>
            <a href="<?= PC::BASE_URL ?>CS/index/cancel" class="btn-sm nav-link <?= $parse == 'cancel' ? 'active' : '' ?>">Batal</a>
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

                        $where_d = "order_ref = '" . $ref . "'";
                        $deliv = $this->db(0)->get_where_row("delivery", $where_d);
                        $pay = $this->db(0)->get_where_row("payment", $where_d);
                    ?>
                        <div class="row">
                            <div class="col mx-2 border rounded pb-2 mb-2">
                                <small>
                                    <table class="mt-1 table-light w-auto mt-2">
                                        <tr>
                                            <td><span style="cursor: pointer;" class="text-success" onclick="cs_detail(<?= $ref ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal_cs"><?= $customer ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><?= $insertTime ?>
                                                <?php if ($parse == "paid") { ?>
                                                    <small class="text-dark">
                                                        <b>(<?= $since_start->days ?> Hari, <?= $since_start->h ?> Jam)</b>
                                                    </small>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>REF#<?= $ref ?></td>
                                        </tr>
                                        <div class="float-end text-end">
                                            <span class="float-end text-warning"><?= $status ?></span><br>
                                            <?php switch ($parse) {
                                                case 'cancel': ?>
                                                    <span class="text-secondary"><?= $pay['transaction_status'] ?></span>
                                                <?php break;
                                                case 'bb': ?>
                                                    <span class="text-secondary">Batas Bayar: <?= $pay['expired_time'] ?></span>
                                            <?php break;
                                            }
                                            ?>
                                        </div>
                                    </table>
                                </small>
                                <div class="border-top mt-2">
                                    <small>
                                        <table class="table table-sm desktop mb-0">
                                            <?php
                                            $total = 0;
                                            foreach ($d as $da) {
                                                if ($da['order_ref'] == $ref) {
                                                    $subTotal = $da['total'];
                                                    $total += $subTotal;
                                            ?>
                                                    <tr>
                                                        <td style="width: 10px;"><?= strlen($da['file']) > 0 ? '<a href="' . $da['file'] . '" download><i class="fa-regular fa-circle-down"></i></a>' : '' ?></td>
                                                        <td style="width: 10px;"><?= strlen($da['link_drive']) > 0 ? '<a href="' . $da['link_drive'] . '" target="_blank"><i class="fa-solid fa-link"></i></a>' : '' ?></td>
                                                        <td><?= $da['product'] ?>, <?= $da['detail'] ?></td>
                                                        <td><small class="text-danger"><?= $da['note'] ?></small></td>
                                                        <td class="text-end"><?= $da['qty'] ?>pcs</td>
                                                        <td class="text-end">Rp<?= number_format($subTotal) ?></td>
                                                    </tr>
                                            <?php }
                                            }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td colspan="2">Pengiriman:
                                                    <span class="me-2 fw-bold"><?= $deliv['courier_company'] ?> <?= $deliv['courier_type'] ?></span>
                                                    <?php
                                                    if ($parse == "paid") {
                                                        if ($deliv['courier_company'] <> "abf") {
                                                            if (strlen($deliv['available_collection_method']) == 0) { ?>
                                                                <a class="send" href="<?= PC::BASE_URL . $con ?>/cek_kirim/<?= $deliv['order_ref'] ?>">Kirim</a>
                                                                <?php } else {
                                                                echo "Tersedia: ";
                                                                foreach (unserialize($deliv['available_collection_method']) as $acm) { ?>
                                                                    <a class="me-1 send" href="<?= PC::BASE_URL . $con ?>/kirim/<?= $deliv['order_ref'] ?>/<?= $acm ?>"><?= strtoupper($acm) ?></a>
                                                                <?php }
                                                                ?>
                                                            <?php }
                                                        } else { ?>
                                                            <a href="#">Selesai/Siap Jemput</a>
                                                    <?php }
                                                    } ?>
                                                </td>
                                                <td></td>
                                                <td class="text-end">Rp<?= number_format($deliv['price_paid']) ?>/<?= number_format($deliv['price']) ?></td>
                                            </tr>
                                        </table>
                                    </small>
                                </div>
                                <?php
                                $total_ = $total + $deliv['price_paid'];
                                ?>
                                <div class="fw-bold me-1 w-100 text-end mb-1"><span class="">Rp<?= number_format($total_) ?></span></div>
                                <div>
                                    <?php
                                    if ($parse == "sent") {
                                        $track = $this->model("Biteship")->tracking($deliv['tracking_id']);
                                        if (count($track['history']) == 0) { ?>
                                            <div class="alert alert-warning py-1 px-1 mb-1" role="alert">
                                                <small>
                                                    Courier has been ordered.
                                                </small>
                                            </div>
                                            <?php } else {
                                            foreach ($track['history'] as $h) { ?>
                                                <div class="alert alert-warning py-1 px-1 mb-1" role="alert">
                                                    <small>
                                                        <b><?= $h['status'] ?></b><br>
                                                        <?= $h['updated_at'] ?><br>
                                                        <?= $h['note'] ?>
                                                    </small>
                                                </div>
                                    <?php }
                                        }

                                        if ($track['status'] == "delivered") {
                                            $where = "delivery_id = '" . $track['id'] . "'";
                                            $set = "order_status = 3";
                                            $this->db(0)->update("order_step", $set, $where);
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        if ($parse == "sent") {
                            if ($track['status'] == "delivered") {
                                $where = "delivery_id = '" . $track['order_id'] . "'";
                                $set = "order_status = 3";
                                $up = $this->db(0)->update("order_step", $set, $where);
                                if ($up['errno'] <> 0) {
                                    $this->model('Log')->write("Pesanan client update Status delivered error: " . $up['error']);
                                }
                            }
                        }
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
                <h5 class="modal-title" id="exampleModalLabel">Delivery Detail</h5>
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

    function cs_detail(ref) {
        $("#modal_content").load("<?= PC::BASE_URL ?>CS/load_cs_detail/" + ref);
    }

    $(".send").click(function(e) {
        e.preventDefault();
        $.post($(this).attr('href'), function() {
            content('paid');
        });
    })

    $("span.batal").click(function() {
        var note = prompt("Alasan Dibatalkan", "");
        if (note === null) {
            return;
        }
        var cust_ = $(this).attr("data-cust");
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= PC::BASE_URL ?>CS/batalkan",
            data: {
                ref: ref,
                cust: cust_,
                cs_note: note
            },
            type: "POST",
            success: function(result) {
                content("cancel");
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
            url: "<?= PC::BASE_URL ?>CS/selesai",
            data: {
                ref: ref,
                cust: cust_,
                deliv: deliv_,
                resi: resi
            },
            type: "POST",
            success: function(result) {
                content("done");
            },
        });
    });
</script>