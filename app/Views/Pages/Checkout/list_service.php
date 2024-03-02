<div class="form-floating">
    <select class="form-select" id="service" name="service">
        <option selected value=""></option>
        <?php
        foreach ($data['ori'] as $k => $d) { ?>
            <option data-harga="<?= $d['cost'][0]['value'] ?>" value="<?= $k ?>"><?= $d['service'] ?> <?= $d['cost'][0]['etd'] ?> Rp<?= number_format($d['cost'][0]['value']) ?></option>
        <?php } ?>
    </select>
    <label for="service">Service</label>
</div>

<script>
    $("#service").on("change", function() {
        harga = parseInt($(this).find(':selected').data('harga'));
        total(harga);
        $("input[name=ongkir]").val(harga);
    })
</script>