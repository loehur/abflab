<?php
$id_produk = $data['produk'];
$main_img = "m";
$d = $data['data'][$id_produk];
?>

<div class="container mb-4">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-auto" style="max-width: 320px;">
                    <div id="carBanner" class="carousel" data-interval="false" data-bs-ride="carousel">
                        <div class="carousel-inner rounded-3">
                            <?php
                            $no = 0;
                            $files = scandir(__DIR__ . "/../../../../assets/img/produk_detail/" . $d['img_detail']);
                            foreach ($files as $f) {
                                if (str_contains($f, ".webp")) {
                                    $no += 1; ?>
                                    <div style="cursor: zoom-in;" class="carousel-item <?= substr($f, 0, -5) ?> <?= ($main_img == substr($f, 0, -5)) ? 'active' : '' ?> zoom">
                                        <img id="image<?= $f ?>" onerror="no_image(<?= $f ?>)" style="max-width: 300px; max-height: 300px" src="<?= $this->ASSETS_URL ?>img/produk_detail/<?= $d['img_detail'] ?>/<?= $f ?>">
                                    </div>
                            <?php }
                            } ?>
                        </div>
                        <small>
                            <div class="text-center text-secondary" id="img_varian"></div>
                        </small>
                        <?php if ($no > 1) { ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carBanner" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carBanner" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        <?php } ?>
                    </div>
                </div>
                <div class="col mt-2">
                    <form class="upload me-0 pe-0 form-floating" action="<?= $this->BASE_URL ?>Detail/upload" method="POST">
                        <h5 class="text-dark"><b><?= $d['produk'] ?></b></h5>
                        <div class="row mb-2">
                            <div class="col-auto">
                                <div class="text-start border rounded border-light shadow-sm border-start-0 px-3 py-1">
                                    <span class="text-success">Harga</span>
                                    <br>
                                    Rp <input name="harga" value="<?= $d['harga'] ?>" class="border-0 opHarga" style="pointer-events: none;" type="text" readonly id="harga" />
                                </div>
                            </div>
                        </div>
                        <hr class="border-light mb-2 mt-3">
                        <?php
                        $varian = $this->varian($d['varian'])->main();;
                        foreach ($varian as $k => $dv) {
                            $k0_ok = str_replace(' ', '-', $k);
                            $k0_ok = preg_replace('/[^A-Za-z0-9\-]/', '', $k0_ok);
                        ?>
                            <div class="row mb-1">
                                <div class="col-auto pe-0">
                                    <label class="fw-bold"><?= $k ?>:</label>
                                    <select name="v1_<?= $k ?>" id="sel_<?= $k0_ok ?>" class="form-select opHarga selVarian" data-id="v<?= $k ?>" required>
                                        <option data-img="0" value="" selected>-</option>
                                        <?php foreach ($dv as $k_ => $dh) { ?>
                                            <option data-img="<?= (isset($dh['img'])) ? $dh['img'] : 0 ?>" value="<?= $k_ ?>" data-harga="<?= $dh['harga'] ?>" data-v='<?= base64_encode(serialize($dh)) ?>'><?= $k_ ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-1" id="v<?= $k ?>"></div>
                        <?php
                        } ?>
                        <input name="produk" type="hidden" value="<?= $id_produk ?>">
                        <div class="row">
                            <div class="col-auto">
                                <label>File Max. 25MB</label> <small class="text-danger">.jpg .jpeg .png .zip .rar</small>
                                <div class="mb-3">
                                    <input id="file" name="order" class="form-control form-control-sm" type="file">
                                    <small>Upload process <span id="persen">0</span><b> %</b></small>
                                </div>
                            </div>
                            <?php if (isset($d['mal']) && is_array($d['mal'])) { ?>
                                <div class="col-auto">
                                    <label class="fw-bold">Template/Mal</label>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Download <i class="fa-regular fa-circle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <?php foreach ($d['mal'] as $m) { ?>
                                                <li><a class="dropdown-item" href="<?= $this->ASSETS_URL ?>img/mal/<?= $m ?>" download=""><?= $m ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <div class="form-floating">
                                    <textarea class="form-control form-control-sm" name="note" id="floatingTextarea"></textarea>
                                    <label for="floatingTextarea">Tinggalkan catatan disini...</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <table>
                                    <tr>
                                        <td colspan="3" class="text-center"> <label>Jumlah (pcs)</label></td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 cursor-pointer" onclick="gantiJumlah(0)">-</td>
                                        <td><input required id="jumlah" name="jumlah" type="number" min="1" class="form form-control text-center" value="1" style="width: 100px;" /></td>
                                        <td class="px-2 cursor-pointer" onclick="gantiJumlah()">+</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col text-end">
                                <span class="text-success">Total Harga</span><br>
                                <b>Rp <span id="harga_total">0</span></b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <div class="">
                                    <button type="submit" id="add_cart" class="btn btn-success">Tambahkan ke Keranjang</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <?php
                if (is_array($d['detail'])) {
                    foreach ($d['detail'] as $dd) { ?>
                        <div class="col shadow-sm border rounded-3 p-2 me-2">
                            <small id="<?= $dd ?>"></small>
                        </div>
                <?php }
                } else {
                    echo "Invalid Detail Format!";
                } ?>
            </div>
        </div>
    </div>
    <script src="<?= $this->ASSETS_URL ?>js/jquery.zoom.js"></script>
    <script>
        $(document).ready(function() {
            totalHarga();
            var detail = <?= (is_array($d['detail'])) ? json_encode($d['detail']) : 0 ?>;

            if (detail != 0) {
                for (const x in detail) {
                    $("#" + detail[x]).load("<?= $this->BASE_URL ?>Load/Produk_Deskripsi/" + detail[x]);
                }
            }

            $('.zoom').zoom({
                magnify: 1,
            });
            spinner(0);
        });

        function no_image(x) {
            $("#image" + x).prop("src", "<?= $this->ASSETS_URL ?>img/guide/no_image.webp");
        }

        $("form.upload").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var file = $('#file')[0].files[0];
            formData.append('file', file);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            $('#persen').html('<b>' + Math.round(percentComplete) + '</b>');
                        }
                    }, false);
                    return xhr;
                },
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: "application/octet-stream",
                enctype: 'multipart/form-data',

                contentType: false,
                processData: false,

                beforeSend: function() {
                    $("#add_cart").hide();
                },

                success: function(dataRespon) {
                    if (dataRespon == 1) {
                        alert("Berhasil menambah order ke keranjang!");
                        cart_count();
                        content(<?= $id_produk ?>);
                    } else {
                        alert(dataRespon);
                    }
                },
            });
        });

        $('select.opHarga').change(function() {
            totalHarga();
            ubahGambar();
        });

        function ubahGambar() {
            var img = "<?= $main_img ?>";
            $('select.opHarga').each(function() {
                img_each = $(this).find(':selected').data('img');
                if (img_each != 0) {
                    img += "_" + img_each;
                }
            })

            $("div#img_varian").html(img);

            if ($(".carousel-item").hasClass(img)) {
                $(".carousel-item").each(function() {
                    $(this).removeClass("active");
                });

                $("." + img).addClass("active");
            }

            $('.carousel').carousel({
                interval: false,
            });
        }

        function totalHarga() {
            var total = 0;
            var qty = $("input#jumlah").val();
            var val = $('select.opHarga').val();

            var harga_awal = <?= $d['harga'] ?>;
            total += (harga_awal * qty);

            if (val != '') {
                $('.opHarga').each(function() {
                    val_each = $(this).find(':selected').data('harga');
                    if (Number.isInteger(val_each) == true) {
                        total += val_each;
                    }
                })
            }

            harga(total);
        }

        $('select.selVarian').change(function() {
            var id_ = $(this).attr('data-id');
            var data_ = $(this).find(':selected').data('v')

            if ($(this).val() == "") {
                $("div#" + id_).html("");
            } else {
                $("div#" + id_).html("");
                $("div#" + id_).load("<?= $this->BASE_URL ?>Detail/loadVarian", {
                    data: data_
                });
            }
        });

        function harga(total) {
            var qty = $("input#jumlah").val();
            var harga = $("input#harga").val();
            $("input#harga").val(addCommas(total));
            $("span#harga_total").html(addCommas(total * qty));
        }

        function gantiJumlah(mode = 1) {
            qty = $("input#jumlah").val()

            if (mode == 0) {
                qty -= 1;
            } else {
                qty = parseInt(qty) + 1;
            }

            $("input#jumlah").val(qty);

            totalHarga();
        }

        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>