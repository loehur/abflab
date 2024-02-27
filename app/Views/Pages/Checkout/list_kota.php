<div class="form-floating">
    <select class="form-select" id="kota" name="kota">
        <option selected value=""></option>
        <?php
        foreach ($data as $dp) { ?>
            <option value="<?= $dp['city_id'] ?>"><?= $dp['city_name'] ?></option>
        <?php } ?>
    </select>
    <label for="kota">Kota</label>
</div>

<script>
    $("#kota").on("change", function() {
        var val = $("#kota").val()
        if (val != "") {
            $("#selKecamatan").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).load("<?= $this->BASE_URL ?>Checkout/kecamatan/" + val)
            })
        } else {
            $("#selKecamatan").load("<?= $this->BASE_URL ?>Load/Spinner/1", function() {
                $(this).html("");
            })
        }
        $("#selService").html("<small class='text-secondary'>Service</small>")
        $('#via').prop('selectedIndex', 0);
    })
</script>