<?php
$menu = $this->model("D_Group")->main();
?>

<div class="container mb-3 pt-2" style="min-height: 300px;">
    <nav>
        <ul class="nav nav-tabs">
            <?php
            foreach ($menu as $k => $m) { ?>
                <li class="nav-item">
                    <a class="nav-link cekGrup <?= ($k == $data['grup']) ? 'active' : '' ?>" data-grup="<?= $k ?>" href="#"><?= $m['name'] ?></a>
                </li>
            <?php
            } ?>
        </ul>
    </nav>
    <div class="border p-2 pt-3 border-top-0">
        <table class="mb-0 table table-sm" style="font-size: small;">
            <tr>
                <th></th>
                <th>Produk</th>
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
                    <td class=""><a href="<?= $this->BASE_URL ?>Varian1/index/<?= $dp['produk_id'] ?>"><i class="fa-solid fa-bars-progress"></i></a></td>
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
<script>
    $(document).ready(function() {
        device();
        spinner(0);
    });

    $(".cekGrup").click(function() {
        var id = $(this).attr("data-grup");
        content(id);
    })
</script>