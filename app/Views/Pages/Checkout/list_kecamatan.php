<div class="form-floating mb-2">
    <select class="form-select shadow-none" id="kecamatan" name="kecamatan" required>
        <option selected value=""></option>
        <?php
        foreach ($data as $dp) { ?>
            <option value="<?= base64_encode($dp['name']) ?>"><?= strtoupper($dp['name']) ?></option>
        <?php } ?>
    </select>
    <label for="kecamatan">Kecamatan</label>
</div>

<script>
    $("#kecamatan").on("change", function() {
        var val = $(this).val()
        if (val != "") {
            $("#selKodePos").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= $this->BASE_URL ?>Checkout/kode_pos/" + val)
            })
        } else {
            $("#selKodePos").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("");
            })
        }
    })
</script>