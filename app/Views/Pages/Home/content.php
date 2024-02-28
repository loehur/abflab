<div class="container-fluid border-0">
    <div class="container px-0">
        <div id="carBanner" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded-3">
                <?php
                for ($x = 1; $x <= $data['banner']; $x++) { ?>
                    <div class="carousel-item <?= ($x == 1) ? 'active' : '' ?>">
                        <img src="<?= $this->ASSETS_URL ?>img/banner/<?= $x ?>.webp" class="d-block w-100">
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carBanner" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carBanner" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<style>
    .wrapper {
        display: flex;
        height: auto;
        overflow-x: auto;
        overflow-y: hidden;
        margin-bottom: 6px;
        cursor: pointer;
    }

    .wrapper::-webkit-scrollbar {
        display: none;
    }

    .wrapper .item {
        min-width: 100px;
        max-width: 120px;
        text-align: center;
    }
</style>
<!-- Fruits Shop Start-->

<div class="container-fluid py-3">
    <div class="container pb-2 px-0">
        <div class="mobile">
            <?php
            $menu = $this->model("D_Group")->main();
            $produk = $this->model("D_Produk")->main();
            ?>

            <?php foreach ($menu as $k => $m) { ?>
                <div>
                    <label class="fw-bold"><small><?= $m['name'] ?></small></label>
                </div>
                <div class="wrapper rounded mb-2">
                    <?php foreach ($produk as $pk => $p) {
                        if ($p['group'] == $k) { ?>
                            <div class="rounded border item me-1 my-1 me-2">
                                <a href="<?= ($p['link'] == 0) ? $this->BASE_URL . 'Detail/index/' . $k : $p['link'] ?>" target="<?= $p['target'] ?>">
                                    <img class="w-100 rounded bg-light" id="image<?= $p['img'] ?>0" onerror="no_image(<?= $p['img'] ?>0)" src="<?= $this->ASSETS_URL ?>img/home_produk/<?= $p['img'] ?>.webp" alt="">
                                    <div class="py-1 px-1 text-dark"><small><?= $p['produk'] ?></small></div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
            <?php } ?>

        </div>
        <div class="desktop">
            <ul class="nav nav-tabs mb-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">Semua</button>
                </li>
                <?php foreach ($menu as $k => $m) { ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-<?= $m['aktif'] ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?= $m['aktif'] ?>" type="button" role="tab" aria-controls="pills-<?= $m['aktif'] ?>" aria-selected="true"><?= $m['name'] ?></button>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <div class="row px-2 row-cols-auto">
                        <?php foreach ($data['product'] as $k => $p) { ?>
                            <div class="col-sm-2 mb-2 px-1 rounded">
                                <div class="rounded border">
                                    <div class="img-zoom-border">
                                        <a href="<?= ($p['link'] == 0) ? $this->BASE_URL . 'Detail/index/' . $k : $p['link'] ?>" target="<?= $p['target'] ?>">
                                            <img id="image<?= $p['img'] ?>" onerror="no_image(<?= $p['img'] ?>)" src="<?= $this->ASSETS_URL ?>img/home_produk/<?= $p['img'] ?>.webp" class="img-zoom w-100 rounded-top" alt="">
                                        </a>
                                    </div>
                                    <div class="w-100 fw-bold text-center text-dark py-2"><?= $p['produk'] ?></div>
                                </div>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
                <?php foreach ($menu as $km => $m) { ?>
                    <div class="tab-pane" id="pills-<?= $m['aktif'] ?>" role="tabpanel" aria-labelledby="pills-<?= $m['aktif'] ?>-tab">
                        <div class="row px-2 row-cols-auto">
                            <?php foreach ($data['product'] as $k => $p) {
                                if ($p['group'] == $km) { ?>
                                    <div class="col-sm-2 mb-2 px-1 rounded">
                                        <div class="rounded img-zoom-border border">
                                            <a href="<?= ($p['link'] == 0) ? $this->BASE_URL . 'Detail/index/' . $k : $p['link'] ?>" target="<?= $p['target'] ?>">
                                                <img id="image<?= $p['img'] ?>" onerror="no_image(<?= $p['img'] ?>)" src="<?= $this->ASSETS_URL ?>img/home_produk/<?= $p['img'] ?>.webp" class="img-zoom w-100 rounded-top" alt="">
                                                <div class="w-100 fw-bold text-center text-dark py-2"><?= $p['produk'] ?></div>
                                            </a>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Fruits Shop End-->

<script>
    $(document).ready(function() {
        spinner(0);

        device();

        var myCarousel = document.querySelector('#carBanner')
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 4000,
            wrap: true
        })
    });

    function no_image(x) {
        $("#image" + x).prop("src", "<?= $this->ASSETS_URL ?>img/guide/no_image.webp");
    }

    const slider = document.querySelector(".wrapper");
    const preventClick = (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();
    }
    let isDown = false;
    let isDragged = false;
    let startX;
    let scrollLeft;

    slider.addEventListener("mousedown", e => {
        isDown = true;
        slider.classList.add("active");
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener("mouseleave", () => {
        isDown = false;
        slider.classList.remove("active");
    });
    slider.addEventListener("mouseup", (e) => {
        isDown = false;
        const elements = document.querySelectorAll("a");
        if (isDragged) {
            for (let i = 0; i < elements.length; i++) {
                elements[i].addEventListener("click", preventClick);
            }
        } else {
            for (let i = 0; i < elements.length; i++) {
                elements[i].removeEventListener("click", preventClick);
            }
        }
        slider.classList.remove("active");
        isDragged = false;
    });
    slider.addEventListener("mousemove", e => {
        if (!isDown) return;
        isDragged = true;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
        console.log(walk);
    });
</script>