<br>
<?php foreach ($dv as $k_ => $dh) {
    $k1_ok = str_replace(' ', '-', $k_);
    $k1_ok = preg_replace('/[^A-Za-z0-9\-]/', '', $k1_ok);
?>
    <div onclick="varian('<?= $k0_ok ?>', '<?= $k1_ok ?>','<?= $k_ ?>')" class="var_<?= $k0_ok ?> var_<?= $k1_ok ?> me-1 mb-2 btn btn-sm btn-outline-success rounded-3"><?= $k_ ?></div>
<?php } ?>

<br>
<?php foreach ($v as $k2 => $v2) {
    $k1_ok = str_replace(' ', '-', $k2);
    $k1_ok = preg_replace('/[^A-Za-z0-9\-]/', '', $k1_ok);
?>
    <div onclick="varian('<?= $k0_ok ?>', '<?= $k1_ok ?>','<?= $k2 ?>')" class="var_<?= $k0_ok ?> var_<?= $k1_ok ?> me-1 mb-2 btn btn-sm btn-outline-success rounded-3"><?= $k2 ?></div>
<?php } ?>

<script>
    function varian(head, opt, opt_ori) {
        $('.var_' + head).each(function() {
            $(this).removeClass("btn-outline-success");
            $(this).removeClass("btn-success");
            if ($(this).hasClass("var_" + opt) == true) {
                $(this).addClass("btn-success");
            } else {
                $(this).addClass("btn-outline-success");
            }
        });

        $("select#sel_" + head).val(opt_ori).change();
    }
</script>