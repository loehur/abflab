<?php
if (isset($data['varian'])) {

    foreach ($data['varian'] as $k => $v) {
        $k0_ok = str_replace(' ', '-', $k);
        $k0_ok = preg_replace('/[^A-Za-z0-9\-]/', '', $k0_ok);
?>
        <div class="col-auto pe-0">
            <label class="fw-bold"><?= $k ?>:</label>
            <select name="v2_<?= $k ?>" id="sel_<?= $k0_ok ?>" class="form-select opHarga">
                <option data-img="0" value="0" selected>-</option>
                <?php foreach ($v as $k2 => $v2) { ?>
                    <option data-img="<?= (isset($v2['img'])) ? $v2['img'] : 0 ?>" value="<?= $k2 ?>" data-harga="<?= $v2['harga'] ?>"><?= $k2 ?></option>
                <?php } ?>
            </select>
        </div>
<?php }
}
?>

<script>
    $('select.opHarga').change(function() {
        totalHarga();
        ubahGambar();
    });
</script>