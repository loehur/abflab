<div class="form-floating">
    <select class="form-select shadow-none" id="kota" name="kota" required>
        <option selected value=""></option>
        <?php
        foreach ($data as $dp) { ?>
            <option value="<?= base64_encode($dp) ?>"><?= str_replace("+", " ", $dp) ?></option>
        <?php } ?>
    </select>
    <label for="kota">Kota</label>
</div>

<script>
    $("#kota").on("change", function() {
        var val = $(this).val()
        if (val != "") {
            $("#selKecamatan").load("<?= PC::BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= PC::BASE_URL ?>Checkout/kecamatan/" + val)
            })
        } else {
            $("#selKecamatan").load("<?= PC::BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("");
            })
            $("#selKodePos").load("<?= PC::BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("");
            })
        }
    })
</script>