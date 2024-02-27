<div class="container mb-3 pt-2" style="min-height: 300px;">
    <div class="row">
        <div class="col">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-bb-tab" data-bs-toggle="tab" data-bs-target="#nav-bb" type="button" role="tab" aria-controls="nav-bb" aria-selected="true">Belum Bayar</button>
                    <button class="nav-link" id="nav-p-tab" data-bs-toggle="tab" data-bs-target="#nav-p" type="button" role="tab" aria-controls="nav-p" aria-selected="false">Dalam Proses</button>
                    <button class="nav-link" id="nav-s-tab" data-bs-toggle="tab" data-bs-target="#nav-s" type="button" role="tab" aria-controls="nav-s" aria-selected="false">Dikirim/Selesai</button>
                    <button class="nav-link" id="nav-b-tab" data-bs-toggle="tab" data-bs-target="#nav-b" type="button" role="tab" aria-controls="nav-b" aria-selected="false">Dibkan</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-bb" role="tabpanel" aria-labelledby="nav-bb-tab">
                    <div class="row">
                        <div class="col pt-2 px-3">
                            <?php
                            $ref = "";
                            foreach ($data['bb'] as $d) {
                                $new_ref = $d['order_ref'];

                                if ($ref <> $new_ref) {
                                    $ref = $new_ref;
                                } else {
                                    continue;
                                }
                            ?>
                                <div class="row">
                                    <div class="col mx-2 shadow-sm pb-2 mb-2">
                                        <u>Order Ref. <?= $ref ?></u>
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
                                        <span class="text-danger"></span>
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
        spinner(0);
    });
</script>