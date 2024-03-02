<div class="form-floating">
    <select class="form-select" id="kecamatan" name="kecamatan">
        <option selected value=""></option>
        <?php
        foreach ($data as $dp) { ?>
            <option value="<?= $dp['subdistrict_id'] ?>"><?= $dp['subdistrict_name'] ?></option>
        <?php } ?>
    </select>
    <label for="kecamatan">Kecamatan</label>
</div>

<script>
    $("#kecamatan").on("change", function() {
        $("#selService").html("<small class='text-secondary'>Service</small>")
        $('#via').prop('selectedIndex', 0);
    })
</script>