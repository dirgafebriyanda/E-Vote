<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Multi Pilihan</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Google Fonts Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet" />
    <!-- bs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>
<style>
    * {
        font-family: "Poppins", sans-serif;
    }

    html {
        scroll-behavior: smooth;
    }

    .carousel-item {
        height: 38rem;
        background: #f1ecec;
    }

    .carousel-item>img {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100%;
        height: 38rem;
        /* filter: brightness(95%); */
    }

    .carousel-caption-left {
        position: absolute;
        left: 10%;
        top: 43%;
        transform: translateY(-50%);
        text-align: left;
    }

    .caption {
        font-size: 3.8em;
        margin-top: 0.1rem;
        margin-bottom: 0.1rem;
        font-weight: 700;
    }

    .caption-2 {
        font-size: 3em;
        margin-top: 0.1rem;
        margin-bottom: 0.1rem;
        font-weight: 700;
    }

    .text-slide {
        margin-top: 0.1rem;
        margin-bottom: 0.1rem;
    }

    #btn-back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        z-index: 1;
    }

    #whatsapp {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 1;
    }

    .btn-whatsapp {
        background-color: #25D366;
    }

    .btn-whatsapp:hover {
        background-color: #25D366;
    }

    /* Media query untuk versi mobile */
    @media (max-width: 768px) {
        .caption {
            font-size: 2.2em;
            /* Ukuran huruf yang lebih kecil untuk versi mobile */
        }

        .persuasif {
            font-size: 1.2em;
            /* Ukuran huruf yang lebih kecil untuk versi mobile */
        }
    }
</style>

<body>
    <!-- carousel -->
    <section id="home" class="">
        <div id="carouselExampleFade" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/banner_simpil.png') }}" class="w-100 d-none d-md-block"
                        alt="Banner-BSKreatif-1" />
                    <img src="/img/BBanner-BSKreatif-1.jpg" class="d-block d-md-none w-100" alt="Banner-BSKreatif-1" />
                    <div class="carousel-caption-left text-dark">
                        <h1 class="caption ">SISTEM MULTI PILIHAN</h1>
                        <h3 class="caption-2 text-danger">MAKSIMAL 3 PILIHAN</h3>
                        <h4 class="fw-bold text-danger">
                            <span id="typed3 py-4"></span>
                        </h4>
                        <br>
                        <p class="fw-bold text-slide">
                            <i class="fas fa-check me-2 text-success"></i>Sistem Terbaru
                        </p>
                        <p class="fw-bold text-slide">
                            <i class="fas fa-check me-2 text-success"></i>Garansi Uang
                            Kembali
                        </p>
                        <p class="fw-bold text-slide">
                            <i class="fas fa-check me-2 text-success"></i>Garansi Ganti Baru
                        </p>
                        <p class="fw-bold text-slide">
                            <i class="fas fa-check me-2 text-success"></i>Bantuan
                            Pelanggan 24/7
                        </p>
                        <br>
                        <a href="https://wa.me/6285266528221?text=Halo%2C%20saya%20tertarik%20dengan%20buku%20Sistem%20multi%20pilihan%20ini"
                            class="btn btn-danger rounded-pill mt-4">
                            <span class="mx-4">Pesan Sekarang</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-dark rounded-pill mt-4">
                            <span class="mx-4">Coba Sistem</span>
                        </a>

                    </div>
                </div>

            </div>
    </section>
    <!-- carousel -->

    <!-- Footer -->
    {{-- <button class="btn btn-whatsapp btn-sm rounded-circle" id="whatsapp">
        <a class="fab fa-whatsapp text-light fa-2x text-center text-decoration-none"
            href="https://wa.me/6285709033274"></a>
    </button> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 2000,
        });
    </script>
</body>

</html>
