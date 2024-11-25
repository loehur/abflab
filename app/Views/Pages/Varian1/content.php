<?php
$vg1_d = $data['grup'];
$produk_id = $data['produk']['produk_id'];
$produk_name = $data['produk']['produk'];
$produk_grup = $data['produk']['grup'];
$produk_grup_name = "";

$grup_list = PC::Group;
foreach ($grup_list as $k => $m) {
    if ($k == $produk_grup) {
        $produk_grup_name = $m['name'];
    }
}
?>

<div class="container mb-3 pt-2" style="min-height: 300px;">
    <h6 class="pb-2">
        <b><a class="border rounded px-2 me-1 border-warning" href="<?= PC::BASE_URL ?>Produk/index/<?= $produk_grup ?>"><?= $produk_grup_name ?></a></b>
        <span><b class="text-secondary"><?= $produk_name ?></b></span>
    </h6>
    <nav>
        <label class="mb-1"><small><b>Head</b> | Varian 1</small></label>
        <table class="p-0 mb-2 w-100">
            <tr>
                <?php
                foreach ($vg1_d as $m) {
                ?>
                    <td>
                        <span class="cell_edit me-2" data-tb="varian_grup_1" data-primary="vg1_id" data-id="<?= $m['vg1_id'] ?>" data-col="vg" data-tipe="text"><?= $m['vg'] ?></span>
                    </td>
                <?php
                } ?>
            </tr>
        </table>
        <ul class="nav nav-tabs">
            <?php
            foreach ($vg1_d as $m) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($m['vg1_id'] == $data['gid']) ? 'active' : '' ?>" href="<?= PC::BASE_URL . $con ?>/index/<?= $produk_id ?>/<?= $m['vg1_id'] ?>"><?= $m['vg'] ?></a>
                </li>
            <?php
            } ?>
            <li class="nav-item py-2">
                <span class="px-2 text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal202"><small>Head (+)</small></span>
            </li>
        </ul>
    </nav>
    <div class="border p-2 pt-3 border-top-0">
        <?php if (count($vg1_d) > 0) { ?>
            <table class="mb-0 table table-sm" style="font-size: small;">
                <tr>
                    <th></th>
                    <th><span class="text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal"><small>Varian (+)</small></span></th>
                    <th class="text-end">Harga</th>
                    <th>Img</th>
                    <th class="text-end">Berat</th>
                    <th class="text-end">P</th>
                    <th class="text-end">L</th>
                    <th class="text-end">T</th>
                </tr>
                <?php
                foreach ($data['varian1'] as $dp) {
                    $parse = [
                        "v1_id" => $dp['varian_id'],
                        "vg1_id" => $dp['vg1_id'],
                        "produk_id" => $produk_id
                    ];

                    $parse = serialize($parse);
                    $parse = base64_encode($parse);

                    $attr = 'class="cell_edit" data-tb="varian_1" data-primary="varian_id" data-id="' . $dp['varian_id'] . '"';
                ?>
                    <tr>
                        <td>
                            <a href="<?= PC::BASE_URL ?>Varian2/index/<?= $parse ?>"><i class="fa-solid fa-bars-progress"></i></a>
                        </td>
                        <td>
                            <span <?= $attr ?> data-col="varian" data-tipe="text"><?= $dp['varian'] ?></span>
                        </td>
                        <td class="text-end">
                            <span <?= $attr ?> data-col="harga" data-tipe="number"><?= $dp['harga'] ?></span>
                        </td>
                        <td>
                            <span <?= $attr ?> data-col="img" data-tipe="text"><?= $dp['img'] == '' ? "_" : $dp['img'] ?></span>
                        </td>
                        <td class="text-end">
                            <span <?= $attr ?> data-col="berat" data-tipe="number"><?= $dp['berat'] ?></span>
                        </td>
                        <td class="text-end">
                            <span <?= $attr ?> data-col="p" data-tipe="number"><?= $dp['p'] ?></span>
                        </td>
                        <td class="text-end">
                            <span <?= $attr ?> data-col="l" data-tipe="number"><?= $dp['l'] ?></span>
                        </td>
                        <td class="text-end">
                            <span <?= $attr ?> data-col="t" data-tipe="number"><?= $dp['t'] ?></span>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</div>

<div class="modal" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Varian</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajax" action="<?= PC::BASE_URL ?>Varian1/tambah/<?= $data['gid'] ?>" method="POST">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <label>Varian</label>
                            <input required type="text" class="form-control form-control-sm shadow-none" name="varian">
                        </div>
                        <div class="col">
                            <label>Harga</label>
                            <input required type="number" min="0" value="0" class="form-control form-control-sm shadow-none" name="harga">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Image</label>
                            <input type="text" class="form-control form-control-sm shadow-none" name="image">
                        </div>
                        <div class="col">
                            <label>Berat (gram)</label>
                            <input required type="number" min="0" value="0" class="form-control form-control-sm shadow-none" name="berat">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>Panjang (mm)</label>
                            <input required type="number" min="0" value="0" class="form-control form-control-sm shadow-none" name="p">
                        </div>
                        <div class="col">
                            <label>Lebar (mm)</label>
                            <input required type="number" min="0" value="0" class="form-control form-control-sm shadow-none" name="l">
                        </div>
                        <div class="col">
                            <label>Tinggi (mm)</label>
                            <input required type="number" min="0" value="0" class="form-control form-control-sm shadow-none" name="t">
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

<div class="modal" id="exampleModal202" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Varian</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajax" action="<?= PC::BASE_URL ?>Varian1/tambah_head/<?= $produk_id ?>" method="POST">
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <label>Head Varian 1</label>
                            <input required type="text" class="form-control form-control-sm shadow-none" name="name">
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
</script>