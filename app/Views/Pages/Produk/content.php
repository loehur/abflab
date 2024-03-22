<?php
$menu = $this->model("D_Group")->main();
?>

<div class="container mb-3 pt-2" style="min-height: 300px;">
    <nav>
        <ul class="nav nav-tabs">
            <?php
            foreach ($menu as $k => $m) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($k == $data['grup']) ? 'active' : '' ?>" href="<?= PC::BASE_URL . $con ?>/index/<?= $k ?>"><?= $m['name'] ?></a>
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
            <?php foreach ($data['produk'] as $dp) { ?>
                <tr>
                    <td class=""><a href="<?= PC::BASE_URL ?>Varian1/index/<?= $dp['produk_id'] ?>"><i class="fa-solid fa-bars-progress"></i></a></td>
                    <td><?= $dp['produk'] ?></td>
                    <td><?= $dp['img'] ?></td>
                    <td><?= $dp['img_detail'] ?></td>
                    <td>
                        <?php
                        if (strlen($dp['mal']) > 0) {
                            $mal = unserialize(($dp['mal']));
                            foreach ($mal as $m) { ?>
                                <span><?= $m ?></span>,
                        <?php }
                        } ?>
                    </td>
                    <td><?= $dp['link'] ?></td>
                    <td><?= $dp['target'] ?></td>
                    <td>
                        <?php $detail = unserialize($dp['detail']);
                        foreach ($detail as $dt) { ?>
                            <span><?= $dt['judul'] ?></span>: <span><?= $dt['konten'] ?></span>,
                        <?php }
                        ?>
                    </td>
                    <td><?= $dp['perlu_file'] ?></td>
                    <td class="text-end"><?= $dp['harga'] ?></td>
                    <td><?= $dp['berat'] ?></td>
                    <td><?= $dp['p'] ?></td>
                    <td><?= $dp['l'] ?></td>
                    <td><?= $dp['t'] ?></td>
                    <td><?= $dp['freq'] ?></td>
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
</script>