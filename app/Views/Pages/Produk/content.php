<?php
$menu = $this->model("D_Group")->main();
?>

<div class="container mb-3 pt-2" style="min-height: 300px;">
    <nav>
        <ul class="nav nav-tabs">
            <?php
            foreach ($menu as $k => $m) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($k == $data['grup']) ? 'active' : '' ?>" href="<?= PC::BASE_URL . $con ?>/index/<?= $k ?>"><?= $m['name'] ?> <small>#<?= $k ?></small></a>
                </li>
            <?php
            } ?>
        </ul>
    </nav>
    <div class="border p-2 pt-3 border-top-0">
        <table class="mb-0 table table-sm" style="font-size: small;">
            <tr>
                <th></th>
                <th><span class="text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal"><small>Produk (+)</small></span></th>
                <th>Grup</th>
                <th>Image</th>
                <th>Image Detail</th>
                <th>Mal</th>
                <th>Link</th>
                <th>Target</th>
                <th>Detail</th>
                <th>File</th>
                <th class="text-end">Harga</th>
                <th>Berat</th>
                <th>P</th>
                <th>L</th>
                <th>T</th>
                <th>Freq</th>
            </tr>
            <?php foreach ($data['produk'] as $dp) {
                $attr = 'class="cell_edit" data-tb="produk" data-primary="produk_id" data-id="' . $dp['produk_id'] . '"';
                $attr_des = 'class="cell_edit_des" data-tb="produk" data-primary="produk_id" data-id="' . $dp['produk_id'] . '"';
                $attr_mal = 'class="cell_edit_mal" data-tb="produk" data-primary="produk_id" data-id="' . $dp['produk_id'] . '"';
                $attr_grup = 'class="cell_edit_grup" data-tb="produk" data-primary="produk_id" data-id="' . $dp['produk_id'] . '"';
            ?>
                <tr>
                    <td class=""><a href="<?= PC::BASE_URL ?>Varian1/index/<?= $dp['produk_id'] ?>"><i class="fa-solid fa-bars-progress"></i></a></td>
                    <td><span <?= $attr ?> data-col="produk" data-tipe="text"><?= $dp['produk'] ?></span></td>
                    <td class="text-end"><span <?= $attr_grup ?> data-col="grup" data-tipe="number"><?= $dp['grup'] ?></span></td>
                    <td><span <?= $attr ?> data-col="img" data-tipe="text"><?= $dp['img'] ?></span></td>
                    <td><span <?= $attr ?> data-col="img_detail" data-tipe="text"><?= $dp['img_detail'] ?></span></td>
                    <td>
                        <span <?= $attr_mal ?> data-col="mal" data-tipe="text"><?php if (strlen($dp['mal']) > 0) {
                                                                                    $mal = unserialize(($dp['mal']));
                                                                                    foreach ($mal as $m) { ?><?= $m ?>,<?php }
                                                                                                                } else {
                                                                                                                    echo "_";
                                                                                                                } ?></span>
                    </td>
                    <td><span <?= $attr ?> data-col="link" data-tipe="text"><?= $dp['link'] ?></span></td>
                    <td><span <?= $attr ?> data-col="target" data-tipe="text"><?= $dp['target'] ?></span></td>
                    <td>
                        <span <?= $attr_des ?> data-col="detail" data-tipe="text"><?php $detail = unserialize($dp['detail']);
                                                                                    foreach ($detail as $dt) { ?><?= $dt['judul'] ?>|<?= $dt['konten'] ?>, <?php } ?>
                        </span>
                    </td>
                    <td><span <?= $attr ?> data-col="perlu_file" data-tipe="number"><?= $dp['perlu_file'] ?></span></td>
                    <td class="text-end"><span <?= $attr ?> data-col="harga" data-tipe="number"><?= $dp['harga'] ?></span></span></td>
                    <td class="text-end"><span <?= $attr ?> data-col="berat" data-tipe="number"><?= $dp['berat'] ?></span></td>
                    <td class="text-end"><span <?= $attr ?> data-col="p" data-tipe="number"><?= $dp['p'] ?></span></td>
                    <td class="text-end"><span <?= $attr ?> data-col="l" data-tipe="number"><?= $dp['l'] ?></span></td>
                    <td class="text-end"><span <?= $attr ?> data-col="t" data-tipe="number"><?= $dp['t'] ?></span></td>
                    <td class="text-end"><?= $dp['freq'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="modal" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Produk</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajax" action="<?= PC::BASE_URL . $con ?>/tambah" method="POST">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <label>Nama Produk</label>
                            <input required type="text" class="form-control form-control-sm shadow-none" name="produk">
                        </div>
                        <div class="col">
                            <label>Produk Group</label>
                            <select class="form-select form-select-sm" name="grup" aria-label="Default select example" required>
                                <option selected></option>
                                <?php foreach ($this->model("D_Group")->main() as $key => $dg) { ?>
                                    <option <?= $key == $data['grup'] ? 'selected' : '' ?> value="<?= $key ?>"><?= $dg['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Harga</label>
                            <input required type="number" min="0" class="form-control form-control-sm shadow-none" name="harga">
                        </div>
                        <div class="col">
                            <label>Mal | <small class="text-danger">ex: mal_cd.rar,mal_apg.rar</small></label>
                            <input type="text" class="form-control form-control-sm shadow-none" name="mal">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Deskripsi | <small class="text-danger">ex: Ukuran|ukuran_cetak,Deskripsi|detail_cetak</small></label>
                            <input required type="text" class="form-control form-control-sm shadow-none" name="deskripsi">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Img Utama (home_produk/file)</label>
                            <input required type="text" class="form-control form-control-sm shadow-none" name="img_utama">
                        </div>
                        <div class="col">
                            <label>Img Detail (produk_detail/folder)</label>
                            <input required type="text" class="form-control form-control-sm shadow-none" name="img_detail">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Link <small>(0 Jika internal)</small></label>
                            <input type="text" value="0" class="form-control form-control-sm shadow-none" name="link" required>
                        </div>
                        <div class="col">
                            <label>Target Link</label>
                            <select class="form-select form-select-sm" aria-label="Default select example" name="target" required>
                                <option value="_self" selected>_self (internal)</option>
                                <option value="_self">_blank (diluar <?= PC::APP_NAME ?>)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Perlu File?</label>
                            <select class="form-select form-select-sm" name="perlu_file" aria-label="Default select example" required>
                                <option value="1" selected>Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Berat (gram)</label>
                            <input required type="number" min="0" class="form-control form-control-sm shadow-none" name="berat">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Panjang (mm)</label>
                            <input required type="number" min="0" class="form-control form-control-sm shadow-none" name="p">
                        </div>
                        <div class="col">
                            <label>Lebar (mm)</label>
                            <input required type="number" min="0" class="form-control form-control-sm shadow-none" name="l">
                        </div>
                        <div class="col">
                            <label>Tinggi (mm)</label>
                            <input required type="number" min="0" class="form-control form-control-sm shadow-none" name="t">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        device();
        spinner(0);
    });

    $("form.ajax").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 1) {
                    $(".btn-close").click();
                    reload_content();
                } else {
                    alert(res);
                }
            },
        });
    });

    var click = 0;
    $(".cell_edit").on('dblclick', function() {
        click = click + 1;
        if (click != 1) {
            return;
        }

        var id = $(this).attr('data-id');
        var primary = $(this).attr('data-primary');
        var col = $(this).attr('data-col');
        var tb = $(this).attr('data-tb');
        var tipe = $(this).attr('data-tipe');
        var value = $(this).html();
        var value_before = value;
        var el = $(this);
        var width = el.parent().width();
        var align = "left";
        if (tipe == "number") {
            align = "right";
        }

        el.parent().css("width", width);
        el.html("<input required type=" + tipe + " style='outline:none;border:none;width:" + width + ";text-align:" + align + "' id='value_' value='" + value + "'>");

        $("#value_").focus();
        $("#value_").focusout(function() {
            var value_after = $(this).val();
            if (value_after === value_before) {
                el.html(value);
                click = 0;
            } else {
                $.ajax({
                    url: '<?= PC::BASE_URL ?>Functions/updateCell',
                    data: {
                        'id': id,
                        'value': value_after,
                        'col': col,
                        'primary': primary,
                        'tb': tb
                    },
                    type: 'POST',
                    dataType: 'html',
                    success: function(res) {
                        click = 0;
                        reload_content();
                    },
                });
            }
        });
    });

    $(".cell_edit_des").on('dblclick', function() {
        click = click + 1;
        if (click != 1) {
            return;
        }

        var id = $(this).attr('data-id');
        var primary = $(this).attr('data-primary');
        var col = $(this).attr('data-col');
        var tb = $(this).attr('data-tb');
        var tipe = $(this).attr('data-tipe');
        var value = $(this).html();
        var value_before = value;
        var el = $(this);
        var width = el.parent().width();
        var align = "left";
        if (tipe == "number") {
            align = "right";
        }

        el.parent().css("width", width);
        el.html("<input required type=" + tipe + " style='outline:none;border:none;width:" + width + ";text-align:" + align + "' id='value_' value='" + value + "'>");

        $("#value_").focus();
        $("#value_").focusout(function() {
            var value_after = $(this).val();
            if (value_after === value_before) {
                el.html(value);
                click = 0;
            } else {
                $.ajax({
                    url: '<?= PC::BASE_URL ?>Functions/updateCell_des',
                    data: {
                        'id': id,
                        'value': value_after,
                        'col': col,
                        'primary': primary,
                        'tb': tb
                    },
                    type: 'POST',
                    dataType: 'html',
                    success: function(res) {
                        click = 0;
                        reload_content();
                    },
                });
            }
        });
    });

    $(".cell_edit_mal").on('dblclick', function() {
        click = click + 1;
        if (click != 1) {
            return;
        }

        var id = $(this).attr('data-id');
        var primary = $(this).attr('data-primary');
        var col = $(this).attr('data-col');
        var tb = $(this).attr('data-tb');
        var tipe = $(this).attr('data-tipe');
        var value = $(this).html();
        var value_before = value;
        var el = $(this);
        var width = el.parent().width();
        var align = "left";
        if (tipe == "number") {
            align = "right";
        }

        el.parent().css("width", width);
        el.html("<input required type=" + tipe + " style='outline:none;border:none;width:" + width + ";text-align:" + align + "' id='value_' value='" + value + "'>");

        $("#value_").focus();
        $("#value_").focusout(function() {
            var value_after = $(this).val();
            if (value_after === value_before) {
                el.html(value);
                click = 0;
            } else {
                $.ajax({
                    url: '<?= PC::BASE_URL ?>Functions/updateCell_mal',
                    data: {
                        'id': id,
                        'value': value_after,
                        'col': col,
                        'primary': primary,
                        'tb': tb
                    },
                    type: 'POST',
                    dataType: 'html',
                    success: function(res) {
                        click = 0;
                        reload_content();
                    },
                });
            }
        });
    });

    $(".cell_edit_grup").on('dblclick', function() {
        click = click + 1;
        if (click != 1) {
            return;
        }

        var id = $(this).attr('data-id');
        var primary = $(this).attr('data-primary');
        var col = $(this).attr('data-col');
        var tb = $(this).attr('data-tb');
        var tipe = $(this).attr('data-tipe');
        var value = $(this).html();
        var value_before = value;
        var el = $(this);
        var width = el.parent().width();
        var align = "left";
        if (tipe == "number") {
            align = "right";
        }

        el.parent().css("width", width);
        el.html("<input required type=" + tipe + " style='outline:none;border:none;width:" + width + ";text-align:" + align + "' id='value_' value='" + value + "'>");

        $("#value_").focus();
        $("#value_").focusout(function() {
            var value_after = $(this).val();
            if (value_after === value_before) {
                el.html(value);
                click = 0;
            } else {
                $.ajax({
                    url: '<?= PC::BASE_URL ?>Functions/updateCell_grup',
                    data: {
                        'id': id,
                        'value': value_after,
                        'col': col,
                        'primary': primary,
                        'tb': tb
                    },
                    type: 'POST',
                    dataType: 'html',
                    success: function(res) {
                        click = 0;
                        reload_content();
                    },
                });
            }
        });
    });
</script>