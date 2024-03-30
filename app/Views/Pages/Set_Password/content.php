<div class="container-fluid border-0">
    <div class="container px-0" style="min-height: 500px;">
        <div class="row">
            <div class="col m-auto" style="max-width: 500px;">
                <label class="mb-2"><small>Setup Password Baru</small></label>
                <form action="<?= PC::BASE_URL . $con ?>/update_pass" method="POST">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="number" value="<?= isset($_SESSION['log']) ? $_SESSION['log']['hp'] : "" ?>" required id="floatingInput">
                                <label for="floatingInput">Nomor Handphone yang terdaftar</label>
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
                    <div class="row">
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" name="pass1" required id="floatingInput">
                                <label for="floatingInput">Password Baru</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" name="pass2" required id="floatingInput">
                                <label for="floatingInput">Ulangi Password</label>
                            </div>
                        </div>
                    </div>
                    <a href="<?= PC::BASE_URL ?>"><button type="button" class="btn btn-secondary">Batal</button></a>
                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
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
        $.post("<?= PC::BASE_URL . $con ?>/req_otp", {
            number: no
        }, ).done(function(res) {
            alert(res);
        })
    })

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 1) {
                    alert("Sukses. Password di perbaharui");
                    window.location.href = "<?= PC::BASE_URL ?>";
                } else {
                    alert(res);
                }
            },
        });
    });
</script>