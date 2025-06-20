<div class="container mb-3 pt-2" style="min-height: 300px;">
    <div class="row">
        <div class="col m-auto" style="max-width: 500px;">
            <label class="mb-2"><small>Login menggunakan Nomor HP <b>Admin Produk</b> yang terdaftar</small></label>
            <form action="<?= PC::BASE_URL ?>Produk/login" class="login_produk" method="POST">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="number" required id="floatingInput">
                            <label for="floatingInput">Phone Number (08xx)</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" required name="otp" placeholder="Kode OTP" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="button" id="otp">Minta OTP</button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-end">Login</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        spinner(0);
    });

    $("#otp").click(function() {
        no = $("input[name=number]").val();
        if (no == "") {
            alert("Isi nomor CS dulu");
            return;
        }
        $.post("<?= PC::BASE_URL ?>Produk/req_otp", {
            number: no
        }, ).done(function(res) {
            alert(res);
        })
    })

    $("form.produk").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 1) {
                    location.reload(true);
                } else {
                    alert(res);
                }
            },
        });
    });
</script>