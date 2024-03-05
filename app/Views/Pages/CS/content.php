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
                if ($k == "tab") {
                    continue;
                }
                $tab = "";
                switch ($data['tab']) {
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
    <div class="tab-content" id="nav-tabContent">
        <?php foreach ($data as $k => $d) {
            if ($k == 'tab') continue ?>
            <div class="tab-pane <?= ($k == 'bb') ? 'show active' : '' ?>" id="nav-<?= $k ?>" role="tabpanel" aria-labelledby="nav-bb-tab">
                <div class="row">
                    <div class="col pt-2 px-3">
                        <?php
                        $ref = "";
                        foreach ($data[$k] as $d) {
                            $new_ref = $d['order_ref'];
                            $customer_id = $d['customer_id'];
                            $d_customer = $this->db(0)->get_where_row("customer", "customer_id = '" . $customer_id . "'");
                            $customer = $d_customer['name'];
                            if ($ref <> $new_ref) {
                                $ref = $new_ref;
                            } else {
                                continue;
                            }

                            $start_date = new DateTime($d['insertTime']);
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
                                                <td><?= $d['insertTime'] ?> <small class="text-dark"><b>(<?= $since_start->days ?> Hari, <?= $since_start->h ?> Jam)</b></small></td>
                                            </tr>
                                            <tr>
                                                <td>REF#<?= $ref ?></td>
                                            </tr>
                                            <span class="float-end text-warning"><?= $tab ?></span>
                                        </table>
                                    </small>
                                    <div class="border-top mt-2">
                                        <small>
                                            <table class="table table-sm desktop">
                                                <?php
                                                $total = 0;
                                                foreach ($data[$k] as $da) {
                                                    if ($da['order_ref'] == $ref) {
                                                        $subTotal = $da['total'];
                                                        $total += $subTotal;
                                                ?>
                                                        <tr>
                                                            <td style="width: 10px;"><a href="<?= $da['file'] ?>" download><i class="fa-regular fa-circle-down"></i></a></td>
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
                                                    <td></td>
                                                    <td>Pengiriman:</td>
                                                    <td><?= $deliv['courier'] ?> <?= $deliv['service'] ?></td>
                                                    <td></td>
                                                    <td class="text-end">Rp<?= number_format($deliv['total']) ?></td>
                                                </tr>
                                            </table>
                                            <table class="table table-sm table-borderless mobile">
                                                <?php
                                                $total = 0;
                                                foreach ($data[$k] as $da) {
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
                                                    <td>Pengiriman: <?= $deliv['courier'] ?> <?= $deliv['service'] ?> <span class="float-end">Rp<?= number_format($deliv['total']) ?></span></td>
                                                </tr>
                                            </table>
                                        </small>
                                    </div>
                                    <?php
                                    $total_ = $total + $deliv['total'];
                                    $where_p = "order_ref = '" . $ref . "'";
                                    $pay = $this->db(0)->get_where_row("payment", $where_p);
                                    ?>
                                    <div class="float-end fw-bold me-1">Rp<?= number_format($total_) ?></div>
                                    <div class="">
                                        <?php
                                        switch ($pay['payment_status']) {
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
        <?php } ?>
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
        $("#nav-<?= $data['tab'] ?>-tab").click();
        spinner(0);
    });

    function cs_detail(id) {
        $("#modal_content").load("<?= $this->BASE_URL ?>CS/load_cs_detail/" + id);
    }

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