<div class="form-floating">
    <select class="form-select shadow-none" id="kecamatan" name="kecamatan" required>
        <option selected value=""></option>
        <?php
        foreach ($data as $key => $dp) { ?>
            <option value="<?= $key ?>"><?= str_replace("+", " ", $key) ?></option>
        <?php } ?>
    </select>
    <label for="kecamatan">Kecamatan</label>
</div>

<script>
    $("#kecamatan").on("change", function() {
        var val = $(this).val()
        if (val != "") {
            $("#selKodePos").load("<?= PC::BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= PC::BASE_URL ?>Checkout/kode_pos", {
                    input: val
                })
            })
        } else {
            $("#selKodePos").load("<?= PC::BASE_URL ?>Load/Spinner/1", function() {
                $("#selKodePos").html("<small class='text-secondary'>Kode Pos</small>")
            })
        }
    })
</script>