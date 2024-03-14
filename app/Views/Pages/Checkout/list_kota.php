<div class="form-floating mb-2">
    <select class="form-select shadow-none" id="kota" name="kota" required>
        <option selected value=""></option>
        <?php
        foreach ($data as $dp) { ?>
            <option value="<?= $dp['id'] ?>"><?= $dp['name'] ?></option>
        <?php } ?>
    </select>
    <label for="kota">Kota</label>
</div>

<script>
    $("#kota").on("change", function() {
        var val = $(this).val()
        if (val != "") {
            $("#selKecamatan").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= $this->BASE_URL ?>Checkout/kecamatan/" + val)
            })
        } else {
            $("#selKecamatan").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("");
            })
            $("#selKodePos").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("");
            })
        }
    })
</script>