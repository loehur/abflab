<?php if (isset($data['ori'])) { ?>
    <div class="form-floating">
        <select class="form-select" id="service" name="service" required>
            <option selected value=""></option>
            <?php
            foreach ($data['ori'] as $d) { ?>
                <option data-harga="<?= $d['cost'][0]['value'] ?>" value="<?= $d['service'] ?>"><?= $d['service'] ?> <?= $d['cost'][0]['etd'] ?> Rp<?= number_format($d['cost'][0]['value']) ?></option>
            <?php } ?>
        </select>
        <label for="service">Service</label>
    </div>
<?php } else { ?>
    <div class="form-floating">
        <select class="form-select" id="service" name="service" required>
            <option selected value=""></option>
            <?php
            foreach ($data['db'] as $d) {
                $etd = strtoupper($d['etd']);
            ?>
                <option data-harga="<?= $d['cost_weight'] ?>" value="<?= $d['service'] ?>"><?= $d['service'] ?> <?= $etd ?> Rp<?= number_format($d['cost_weight']) ?></option>
            <?php } ?>
        </select>
        <label for="service">Service</label>
    </div>
<?php } ?>

<script>
    $("#service").on("change", function() {
        harga = parseInt($(this).find(':selected').data('harga'));
        total(harga);
    })
</script>