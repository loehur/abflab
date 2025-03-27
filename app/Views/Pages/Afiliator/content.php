<div class="container-fluid border-0">
    <div class="container px-0" style="min-height: 500px;">
        <div class="row">
            <div class="col m-auto" style="max-width: 500px;">
                <label class="mb-2 fw-bold text-success"><small>Program Afiliasi</small></label>
                <div class="row mb-3">
                    <div class="col text-center">
                        <div class="form-floating">
                            <b>Bonus Afiliator</b>
                        </div>
                        <div class="">
                            <h5 class="fw-bold text-success fw-bold">Rp. <?= number_format($data['fee']) ?></h5>
                            <small class="text-sm"><i>Penarikan Minimal 50.000</i></small>
                        </div>
                    </div>
                </div>
                <?php if (isset($data['aff']['id'])) { ?>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                Bagikan kode promo & dapatkan keuntungan bersama teman Anda.
                            </div>
                            <div class="text-center alert alert-success">
                                <h4 class="p-0 m-0"><span class="fw-bold" style="letter-spacing: 1px; font-family:Arial, Helvetica, sans-serif"><?= $data['aff']['code'] ?></span></h4>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-floating mb-2">
                                Berikan kode promo, ajak teman menggunakan kode tersebut dan raih keuntungan bersama teman Anda.
                            </div>
                            <div class="text-center">
                                <button class="req_code btn btn-sm btn-primary">Dapatkan Kode</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col">
                        <?php if (count(PC::DISKON_AFILIATOR_ITEM) > 0) { ?>
                            <div class="form-floating mb-1">
                                Promo yang sedang berlangsung:
                            </div>
                            <div>
                                <?php foreach (PC::DISKON_AFILIATOR_ITEM as $key => $da) { ?>
                                    <ul>
                                        <li>Belanja Produk <b><?= $data['produk'][$key]['produk'] ?></b>, dapatkan Cashback <b><?= $da['FB'] ?>%</b> untuk pembeli, dan Bonus <b><?= $da['FA'] ?>%</b> untuk Afiliator.</li>
                                    </ul>
                                <?php } ?>
                            </div>
                        <?php } ?>
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

    $(".req_code").on("click", function(e) {
        $.ajax({
            url: "<?= PC::BASE_URL ?>Afiliator/get_code",
            data: [],
            type: "POST",
            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res);
                }
            },
        });
    });
</script>