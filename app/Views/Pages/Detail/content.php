<?php
$id_produk = $data['data']['produk_id'];
$main_img = "m";
$d = $data['data'];

$varian = $this->db(0)->get_where("varian_grup_1", "produk_id = " . $id_produk);
?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="container mb-4">
    <button type="button" class="btn d-none btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Launch modal
    </button>
    <!-- Modal -->
    <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 mx-auto" id="staticBackdropLabel">Mengunggah file</h1>
                </div>
                <div class="modal-body">
                    <div class="text-center fw-bold text-success py-2">
                        <h4 class="fw-bold"><span id="persen">0 </span>%</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4 px-1 mb-2">
            <div id="carBanner" class="carousel" data-bs-interval="false">
                <div class="carousel-inner rounded-3 border">
                    <?php
                    $no = 0;
                    $files = scandir(__DIR__ . "/../../../../assets/img/produk_detail/" . $d['img_detail']);
                    foreach ($files as $f) {
                        if (str_contains($f, ".webp")) {
                            $no += 1; ?>
                            <div style="cursor: zoom-in;" class="carousel-item <?= substr($f, 0, -5) ?> <?= ($main_img == substr($f, 0, -5)) ? 'active' : '' ?> zoom">
                                <img id="image<?= $f ?>" onerror="no_image(<?= $f ?>)" class="d-block w-100" src="<?= PC::ASSETS_URL ?>img/produk_detail/<?= $d['img_detail'] ?>/<?= $f ?>">
                            </div>
                    <?php }
                    } ?>
                </div>
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
        <div class="col p-2 mx-1">
            <form class="upload me-0 pe-0 form-floating" action="<?= PC::BASE_URL ?>Detail/upload" method="POST">
                <h6 class="text-success"><b><?= $d['produk'] ?></b></h6>
                <div class="row mb-2 d-none">
                    <div class="col-auto">
                        <div class="text-start border rounded border-light shadow-sm border-start-0 px-3 py-1">
                            <span class="text-success">Harga</span>
                            <br>
                            Rp <input name="harga" value="<?= $d['harga'] ?>" class="border-0 opHarga" style="pointer-events: none;" type="text" readonly id="harga" />
                        </div>
                    </div>
                </div>
                <?php
                foreach ($varian as $dv) {
                ?>
                    <div class="row mb-1">
                        <div class="col-auto pe-0">
                            <label class=""><small><?= $dv['vg'] ?>:</small></label>
                            <select name="v1_<?= $dv['vg1_id'] ?>" id="sel_<?= $dv['vg1_id'] ?>" class="form-select shadow-none opHarga selVarian" data-id="v<?= $dv['vg1_id'] ?>" required>
                                <option data-img="0" value="" selected>-</option>
                                <?php
                                $varian_choice = $this->db(0)->get_where("varian_1", "vg1_id = " . $dv['vg1_id']);
                                foreach ($varian_choice as $dh) {
                                    $v2_post = serialize(["vg1_id" => $dv['vg1_id'], "v1_id" => $dh['varian_id']])
                                ?>
                                    <option data-img="<?= (isset($dh['img'])) ? $dh['img'] : 0 ?>" value="<?= $dh['varian_id'] ?>" data-harga="<?= $dh['harga'] ?>" data-v='<?= $v2_post ?>'><?= $dh['varian'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1" id="v<?= $dv['vg1_id'] ?>"></div>
                <?php
                } ?>
                <input name="produk" type="hidden" value="<?= $id_produk ?>">

                <?php if ($d['perlu_file'] == 1) { ?>
                    <span class=""><small>Pengiriman File:</small></span>
                    <div class="border border-success shadow-sm rounded-3 px-3 mb-2 py-2" style="max-width: 600px;">
                        <div class="row mb-1">
                            <div class="col" style="min-width: 250px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metode_file" value="1" checked>
                                    <label class="form-check-label">
                                        <small>Upload disini</small>
                                    </label>
                                    <div id="radio_1" class="radio_">
                                        <label><small class="text-danger">Max. <b>400MB</b></small></label> <small class="text-danger">(.jpg .jpeg .png .zip .rar)</small>
                                        <div class="">
                                            <input id="file" name="order[]" class="form-control form-control-sm" max="30" type="file" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col" style="min-width: 250px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="metode_file" value="2">
                                    <label class="form-check-label">
                                        <small>Share File, Link Drive</small>
                                    </label>
                                    <div id="radio_2" class="d-none radio_">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-sm shadow-sm" name="link_drive">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else { ?>
                    <input id="file" name="order" class="form-control form-control-sm" max="30" type="hidden">
                <?php }
                if (strlen($d['mal']) <> 0) { ?>
                    <div class="row mb-2">
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Download Mal/Template <i class="fa-regular fa-circle-down"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <?php foreach (unserialize($d['mal']) as $m) { ?>
                                        <li><a class="dropdown-item" href="<?= PC::ASSETS_URL ?>img/mal/<?= $m ?>" download=""><?= $m ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row mb-2">
                    <div class="col mb-2" style="min-width: 250px;">
                        <label><small>Catatan:</small></label>
                        <textarea class="form-control form-control-sm shadow-none" name="note" id="floatingTextarea"></textarea>
                        <label><small class="text-danger">Harap konfirmasi dan masukkan ke catatan jika cetak ukuran khusus! </small></label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <table class="">
                            <tr>
                                <td colspan="3" class="text-center"> <label>Jumlah (pcs)</label></td>
                            </tr>
                            <tr class="border">
                                <td class="px-2 cursor-pointer prevent-select" onclick="gantiJumlah(0)">-</td>
                                <td><input required id="jumlah" name="jumlah" type="number" min="1" class="form form-control shadow-none form-control-sm text-center border-0" value="1" style="width: 70px;" /></td>
                                <td class="px-2 cursor-pointer prevent-select" onclick="gantiJumlah()">+</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-auto me-3">
                        <span class="text-success">Total Harga</span><br>
                        <b>Rp <span id="harga_total">0</span></b>
                    </div>
                </div>
                <div class="row desktop">
                    <div class="col-auto text-end">
                        <div class="">
                            <button type="submit" id="add_cart" class="btn btn-success">(+) Tambah ke Keranjang</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php $detail_ = unserialize($d['detail']) ?>
    <div class="row">
        <div class="col px-1">
            <ul class="nav nav-tabs" id="pills-tab" role="tablist">
                <?php
                if (is_array($detail_)) {
                    $tab = 0;
                    foreach ($detail_ as $k => $dd) {
                        $tab += 1; ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= ($tab == 1) ? 'active' : '' ?>" id="pills-<?= $k ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?= $k ?>" type="button" role="tab" aria-controls="pills-<?= $k ?>" aria-selected="true"><small><?= $dd['judul'] ?></small></button>
                        </li>
                <?php }
                }
                ?>
            </ul>
            <div class="tab-content p-2 border-start border-end border-bottom" id="pills-tabContent">
                <?php
                $tab = 0;
                foreach ($detail_ as $k => $dd) {
                    $tab += 1; ?>
                    <div class="tab-pane <?= ($tab == 1) ? 'show active' : '' ?>" id="pills-<?= $k ?>" role="tabpanel" aria-labelledby="pills-<?= $k ?>-tab">
                        <p align="justify">
                            <small id="detail_<?= $k ?>"></small>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="mobile fix-menu-detail bg-white" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
    <div class="row px-2">
        <div class="col px-0 py-1">
            <span class="btn btn-sm shadow-none">
                <a href="https://api.whatsapp.com/send?phone=<?= PC::SETTING['wa_float'] ?>&text=Halo <?= PC::APP_NAME ?>, Saya ingin informasi mengenai produk *<?= $d['produk'] ?>*" class="text-dark" target="_blank">
                    <i class="fa-brands fa-whatsapp"></i><br>
                    Tanyakan Produk
                </a>
            </span>
        </div>
        <div class="col px-0 bg-success py-1">
            <span class="btn btn-sm shadow-none text-light" id="tambah_keranjang">
                <i class="fa-solid fa-cart-plus"></i><br>
                Tambahkan ke Keranjang
            </span>
        </div>
    </div>
</div>

<a href="<?= PC::HOST_LINK ?>" class="float-back text-decoration-none text-light mobile">
    <i class="fa-solid fa-arrow-left"></i>
</a>

<script src="<?= PC::ASSETS_URL ?>js/jquery.zoom.js"></script>
<script>
    $(document).ready(function() {
        device();
        totalHarga();
        $('.fix-menu').addClass('d-none');
        var detail = <?= (is_array($detail_)) ? json_encode($detail_) : 0 ?>;

        if (detail != 0) {
            for (const x in detail) {
                $("#detail_" + x).load("<?= PC::BASE_URL ?>Load/Produk_Deskripsi/" + detail[x]['konten']);
            }
        }

        $('.zoom').zoom({
            magnify: 1,
        });
        spinner(0);
    });

    function copy(text) {
        var temp = $("<input id=temp />");
        $("body").append(temp);
        temp.val(text)
        temp.select();
        document.execCommand("copy");
        temp.remove();

        $("span#span_copy").fadeIn(200);
        $("span#span_copy").fadeOut(1000);
    }

    $('input:radio[name=metode_file]').change(function() {
        $(".radio_").each(function() {
            if ($(this).hasClass("d-none") == false) {
                $(this).addClass("d-none");
            }
        })
        if ($(this).is(':checked')) {
            $("#radio_" + $(this).val()).removeClass("d-none");
        }
    });

    function no_image(x) {
        $("#image" + x).prop("src", "<?= PC::ASSETS_URL ?>img/guide/no_image.webp");
    }

    $("form.upload").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var file = $('#file')[0].files[0];

        var $fileUpload = $("input[type='file']");
        if (parseInt($fileUpload.get(0).files.length) > 25) {
            alert("Maksimal 25 File");
            return;
        }

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
                $("#staticBackdrop").show();
                $('body').css("pointer-events", "none");
                $("#add_cart").hide();
            },

            success: function(dataRespon) {
                $("#staticBackdrop").hide();
                $('body').css("pointer-events", "auto");

                if (dataRespon == 1) {
                    alert("Berhasil menambah order ke keranjang!");
                    cart_count();
                    content(<?= $id_produk ?>);
                } else {
                    alert(dataRespon);
                    $("#add_cart").show();
                }
            },
        });
    });

    $("#tambah_keranjang").click(function() {
        $("#add_cart").click();
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

        //$("div#img_varian").html(img);

        if ($(".carousel-item").hasClass(img)) {
            $(".carousel-item").each(function() {
                $(this).removeClass("active");
            });

            $("." + img).addClass("active");
        }
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
            $("div#" + id_).load("<?= PC::BASE_URL ?>Detail/loadVarian/", {
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
            if (qty > 1) {
                qty -= 1;
            }
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