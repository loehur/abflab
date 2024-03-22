<?php
foreach ($data['v'] as $v) {
    if (isset($v['vg'])) {
        $v2_ = $this->db(0)->get_where("varian_2", "v1_id = " . $data['id'] . " AND vg2_id = " . $v['vg2_id']);
?>
        <div class="col-auto pe-0 mb-1">
            <label class=""><small><?= $v['vg'] ?>:</small></label>
            <select name="v2_<?= $v['vg2_id'] ?>" id="sel_<?= $v['vg2_id'] ?>" class="form-select shadow-none opHarga" required>
                <option data-img="0" selected>-</option>
                <?php
                foreach ($v2_ as $v2) {
                    $v2h_name = "";
                    $v2_h = $this->db(0)->get_where("v2_head", "vg2_id = " . $v['vg2_id']);
                    foreach ($v2_h as $value) {
                        if ($value['v2_head_id'] == $v2['v2_head_id']) {
                            $v2h_name = $value['v2_head'];
                        }
                    }
                ?>
                    <option data-img="<?= (isset($v2['img'])) ? $v2['img'] : 0 ?>" value="<?= $v2['varian_id'] ?>" data-harga="<?= $v2['harga'] ?>"><?= $v2h_name ?></option>
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