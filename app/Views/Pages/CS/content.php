<div class="container mb-3 pt-2" style="min-height: 300px;">
    <div class="row">
        <div class="col">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link" id="nav-bb-tab" data-bs-toggle="tab" data-bs-target="#nav-bb" type="button" role="tab" aria-controls="nav-bb" aria-selected="true">Belum Bayar</button>
                    <button class="nav-link" id="nav-p-tab" data-bs-toggle="tab" data-bs-target="#nav-p" type="button" role="tab" aria-controls="nav-p" aria-selected="false">Dalam Proses</button>
                    <button class="nav-link" id="nav-s-tab" data-bs-toggle="tab" data-bs-target="#nav-s" type="button" role="tab" aria-controls="nav-s" aria-selected="false">Dikirim/Selesai</button>
                    <button class="nav-link" id="nav-b-tab" data-bs-toggle="tab" data-bs-target="#nav-b" type="button" role="tab" aria-controls="nav-b" aria-selected="false">Dibatalkan</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show" id="nav-bb" role="tabpanel" aria-labelledby="nav-bb-tab">
                    <div class="row">
                        <div class="col pt-2 px-3">
                            <?php
                            $ref = "";
                            foreach ($data['bb'] as $d) {
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
                                // echo $since_start->days . ' days total<br>';
                                // echo $since_start->y . ' years<br>';
                                // echo $since_start->m . ' months<br>';
                                // echo $since_start->d . ' days<br>';
                                // echo $since_start->h . ' hours<br>';
                                // echo $since_start->i . ' minutes<br>';
                                // echo $since_start->s . ' seconds<br>';
                            ?>
                                <div class="row">
                                    <div class="col mx-2 border rounded shadow-sm pb-2 mb-2">
                                        <small>
                                            <table class="mt-1 table-light w-auto">
                                                <tr>
                                                    <td>Customer</td>
                                                    <td>: <b><?= $customer ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td>: <?= $d['insertTime'] ?> <small class="text-dark"><b>(<?= $since_start->days ?> Hari, <?= $since_start->h ?> Jam)</b></small></td>
                                                </tr>
                                            </table>
                                        </small>
                                        <div class="border-top mt-2">
                                            <small>
                                                <table class="table table-sm">
                                                    <?php
                                                    $total = 0;
                                                    foreach ($data['bb'] as $da) {
                                                        if ($da['order_ref'] == $ref) {
                                                            $subTotal = $da['total'];
                                                            $total += $subTotal;
                                                    ?>
                                                            <tr>
                                                                <td style="width: 10px;"><a href="<?= $da['file'] ?>" download><i class="fa-regular fa-circle-down"></i></a></td>
                                                                <td><?= $da['product'] ?> <?= $da['detail'] ?></td>
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
                                                        <td>Ongkir</td>
                                                        <td><?= $deliv['courier'] ?> <?= $deliv['service'] ?></td>
                                                        <td></td>
                                                        <td class="text-end">Rp<?= number_format($deliv['total']) ?></td>
                                                    </tr>
                                                </table>
                                            </small>
                                        </div>
                                        <?php
                                        ?>
                                        <span class="">
                                            <?php
                                            $total_ = $total + $deliv['total'];
                                            $where_p = "order_ref = '" . $ref . "'";
                                            $pay = $this->db(0)->get_where_row("payment", $where_p); ?>

                                            <span data-ref="<?= $ref ?>" class="btn btn-sm btn-outline-success ms-2 terima">Terima Pembayaran</span>
                                            <span data-ref="<?= $ref ?>" class="btn btn-sm btn-outline-danger ms-2 batal">Batalkan Order</span>
                                        </span>
                                        <div class="float-end fw-bold me-1">Rp<?= number_format($total_) ?></div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-p" role="tabpanel" aria-labelledby="nav-p-tab">
                    <div class="row">
                        <div class="col pt-2 px-3">
                            <?php
                            $ref = "";
                            foreach ($data['p'] as $d) {
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
                                    <div class="col mx-2 border rounded shadow-sm pb-2 mb-2">
                                        <small>
                                            <table class="mt-1 table-light w-auto">
                                                <tr>
                                                    <td>Customer</td>
                                                    <td>: <b><?= $customer ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td>: <?= $d['insertTime'] ?> <small class="text-dark"><b>(<?= $since_start->days ?> Hari, <?= $since_start->h ?> Jam)</b></small></td>
                                                </tr>
                                            </table>
                                        </small>
                                        <div class="border-top mt-2">
                                            <small>
                                                <table class="table table-sm">
                                                    <?php
                                                    $total = 0;
                                                    foreach ($data['p'] as $da) {
                                                        if ($da['order_ref'] == $ref) {
                                                            $subTotal = $da['total'];
                                                            $total += $subTotal;
                                                    ?>
                                                            <tr>
                                                                <td style="width: 10px;"><a href="<?= $da['file'] ?>" download><i class="fa-regular fa-circle-down"></i></a></td>
                                                                <td><?= $da['product'] ?> <?= $da['detail'] ?></td>
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
                                                        <td>Ongkir</td>
                                                        <td><?= $deliv['courier'] ?> <?= $deliv['service'] ?></td>
                                                        <td></td>
                                                        <td class="text-end">Rp<?= number_format($deliv['total']) ?></td>
                                                    </tr>
                                                </table>
                                            </small>
                                        </div>
                                        <?php $total_ = $total + $deliv['total']; ?>
                                        <span class="">
                                            <span data-ref="<?= $ref ?>" data-mode="<?= $deliv['delivery'] ?>" class="btn btn-sm btn-outline-success ms-2 selesai">Orderan Selesai</span>
                                            <span data-ref="<?= $ref ?>" class="btn btn-sm btn-outline-danger ms-2 batal">Batalkan Order</span>
                                        </span>
                                        <div class="float-end fw-bold me-1">Rp<?= number_format($total_) ?></div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-s" role="tabpanel" aria-labelledby="nav-s-tab">
                    <div class="row">
                        <div class="col pt-2 px-3">
                            <?php
                            $ref = "";
                            foreach ($data['s'] as $d) {
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
                                    <div class="col mx-2 border rounded shadow-sm pb-2 mb-2">
                                        <small>
                                            <table class="mt-1 table-light w-auto">
                                                <tr>
                                                    <td>Customer</td>
                                                    <td>: <b><?= $customer ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td>: <?= $d['insertTime'] ?> <small class="text-dark"><b>(<?= $since_start->days ?> Hari, <?= $since_start->h ?> Jam)</b></small></td>
                                                </tr>
                                            </table>
                                        </small>
                                        <div class="border-top mt-2">
                                            <small>
                                                <table class="table table-sm">
                                                    <?php
                                                    $total = 0;
                                                    foreach ($data['s'] as $da) {
                                                        if ($da['order_ref'] == $ref) {
                                                            $subTotal = $da['total'];
                                                            $total += $subTotal;
                                                    ?>
                                                            <tr>
                                                                <td style="width: 10px;"><a href="<?= $da['file'] ?>" download><i class="fa-regular fa-circle-down"></i></a></td>
                                                                <td><?= $da['product'] ?> <?= $da['detail'] ?></td>
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
                                                        <td>Ongkir</td>
                                                        <td><?= $deliv['courier'] ?> <?= $deliv['service'] ?></td>
                                                        <td></td>
                                                        <td class="text-end">Rp<?= number_format($deliv['total']) ?></td>
                                                    </tr>
                                                </table>
                                            </small>
                                        </div>
                                        <?php $total_ = $total + $deliv['total']; ?>
                                        <span class="text-danger">
                                            <?= $deliv['resi'] ?>
                                        </span>
                                        <div class="float-end fw-bold me-1">Rp<?= number_format($total_) ?></div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-b" role="tabpanel" aria-labelledby="nav-b">
                    <div class="row">
                        <div class="col pt-2 px-3">
                            <?php
                            $ref = "";
                            foreach ($data['b'] as $d) {
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
                                    <div class="col mx-2 border rounded shadow-sm pb-2 mb-2">
                                        <small>
                                            <table class="mt-1 table-light w-auto">
                                                <tr>
                                                    <td>Customer</td>
                                                    <td>: <b><?= $customer ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal</td>
                                                    <td>: <?= $d['insertTime'] ?> <small class="text-dark"><b>(<?= $since_start->days ?> Hari, <?= $since_start->h ?> Jam)</b></small></td>
                                                </tr>
                                            </table>
                                        </small>
                                        <div class="border-top mt-2">
                                            <small>
                                                <table class="table table-sm">
                                                    <?php
                                                    $total = 0;
                                                    foreach ($data['b'] as $da) {
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
                                                        <td>Ongkir</td>
                                                        <td><?= $deliv['courier'] ?> <?= $deliv['service'] ?></td>
                                                        <td></td>
                                                        <td class="text-end">Rp<?= number_format($deliv['total']) ?></td>
                                                    </tr>
                                                </table>
                                            </small>
                                        </div>
                                        <?php $total_ = $total + $deliv['total']; ?>
                                        <span class="text-danger">
                                            <?= $d['cs_note'] ?>
                                        </span>
                                        <div class="float-end fw-bold me-1">Rp<?= number_format($total_) ?></div>
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
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#nav-<?= $data['tab'] ?>-tab").click();
        spinner(0);
    });

    $("span.batal").click(function() {
        var note = prompt("Alasan Dibatalkan", "");
        if (note === null) {
            return;
        }
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= $this->BASE_URL ?>CS/batalkan",
            data: {
                ref: ref,
                cs_note: note
            },
            type: "POST",
            success: function(result) {
                content("b");
            },
        });
    });

    $("span.terima").click(function() {
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= $this->BASE_URL ?>CS/terima",
            data: {
                ref: ref,
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
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= $this->BASE_URL ?>CS/selesai",
            data: {
                ref: ref,
                resi: resi
            },
            type: "POST",
            success: function(result) {
                content("s");
            },
        });
    });
</script>