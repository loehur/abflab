<div class="container mb-3 pt-2" style="min-height: 300px;">
    <div class="row">
        <div class="col-auto m-auto alert alert-warning">
            Silahkan Transfer sejumlah Rp. <b><?= number_format($data['payment']) ?></b> <span class="text-danger">Tepat hingga 3 digit terakhir</span><br><br>

            Tujuan Rekening<br>
            <b>
                <?php
                foreach ($this->REKENING as $r) {
                    echo $r['bank'] . " ";
                    echo $r['no'] . " a/n. ";
                    echo $r['nama'];
                }
                ?>
            </b>
            <br><br>Klik tombol di bawah ini, jika sudah melakukan Transfer
            <br><br>
            <a class="btn btn-sm btn-primary" href="<?= $this->BASE_URL ?>Pesanan/konfirmasi_bayar/<?= $data['order_ref'] ?>">Saya sudah Transfer</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        spinner(0);
    });
</script>