<div class="container-fluid border-0">
    <div class="container">
        <div id="carBanner" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carBanner" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carBanner" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carBanner" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
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
        height: 220px;
        overflow-x: auto;
        overflow-y: hidden;
        margin-bottom: 6px;
        cursor: pointer;
    }

    .wrapper::-webkit-scrollbar {
        display: none;
    }

    .wrapper .item {
        min-width: 180px;
        text-align: center;
    }
</style>
<!-- Fruits Shop Start-->

<div class="container-fluid py-3">
    <div class="container pb-2">
        <div id="mobile">
            <div class="mb-1">
                <label class="fw-bold">Produk Kami</label>
            </div>
            <div class="wrapper mb-2">
                <?php foreach ($data['product'] as $p) { ?>
                    <div class="rounded item me-1 my-1 shadow-sm me-2">
                        <a href="<?= ($p['link'] == 0) ? $this->BASE_URL . 'Detail/index/' . $p['id'] : $p['link'] ?>" target="<?= $p['target'] ?>">
                            <img class="w-100 rounded bg-light" id="image<?= $p['img'] ?>0" onerror="no_image(<?= $p['img'] ?>0)" src="<?= $this->ASSETS_URL ?>img/home_produk/<?= $p['img'] ?>.webp" alt="">
                            <div class="fw-bold py-1 text-dark"><?= $p['produk'] ?></div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="desktop">
            <div class="mb-1">
                <label class="fw-bold">Produk Kami</label>
            </div>
            <div class="row px-1 row-cols-auto">
                <?php foreach ($data['product'] as $k => $p) { ?>
                    <div class="col-sm-2 px-1 mb-2">
                        <div class="rounded img-zoom-border shadow-sm mx-1">
                            <a href="<?= ($p['link'] == 0) ? $this->BASE_URL . 'Detail/index/' . $k : $p['link'] ?>" target="<?= $p['target'] ?>">
                                <img id="image<?= $p['img'] ?>" onerror="no_image(<?= $p['img'] ?>)" src="<?= $this->ASSETS_URL ?>img/home_produk/<?= $p['img'] ?>.webp" class="img-zoom w-100 rounded-top" alt="">
                                <div class="w-100 fw-bold text-center text-dark py-2"><?= $p['produk'] ?></div>
                            </a>
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

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            $("#desktop").addClass("d-none");
        } else {
            $("#mobile").addClass("d-none");
        }

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