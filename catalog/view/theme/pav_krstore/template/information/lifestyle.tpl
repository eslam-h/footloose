
<?php  echo $header; ?>

<link href="catalog/view/theme/pav_krstore/template/information/lightbox2-master/dist/css/lightbox.css" rel="stylesheet">

<link href="catalog/view/theme/pav_krstore/template/information/slick/slick.css" rel="stylesheet" type="text/css">
<link href="catalog/view/theme/pav_krstore/template/information/slick/slick-theme.css" rel="stylesheet" type="text/css">

<style type="text/css">

    .pp_description {
        display: none !important;
    }

    html, body {
        margin: 0;
        padding: 0;
    }

    * {
        box-sizing: border-box;
    }

    .slider {
        width: 100%;
        margin: 100px auto;
    }

    .slick-slide {
        margin: 0px 20px;
    }

    .slick-slide img {
        width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
        color: black;
    }
</style>

<script src="catalog/view/theme/pav_krstore/template/information/slick/slick.js" type="text/javascript" charset="utf-8"></script>

<script src="catalog/view/theme/pav_krstore/template/information/lightbox2-master/dist/js/lightbox.js"></script>
<script>
    lightbox.option({
        wrapAround : true,
        positionFromTop : 50
    });



    $(document).on('ready', function() {
        $(".regular").slick({
            dots:           true,
            infinite:       true,
            slidesToShow:   3,
            slidesToScroll: 1,
            autoplay:       true,
//            autoplaySpeed:  70000,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1008,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }

            ],
            rtl:            <?php echo $rtl; ?>
        });
    });

    $(window).resize(function () {
        $('.regular').slick('resize');
    });

    $(window).on('orientationchange', function () {
        $('.regular').slick('resize');
    });

</script>


<div class="main-columns container">

        <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
        </ul>




    <?php $i=0; foreach($pictures as $manufacturer => $pics) { ?>
        <h3> <?php echo $manufacturer; ?> </h3>

    <section class="regular slider">
        <?php foreach($pics as $picture) { ?>
                <a href="<?php echo $picture; ?>" data-lightbox="<?php echo $i; ?>" data-title="<?php echo $manufacturer; ?>" >

                    <div>
                    <img  style="margin-bottom: 30px; border-radius: 20px" width="100%" height="236" src="<?php echo $picture; ?>"">
                    </div>

                </a>
        <?php } ?>

        <?php $veds = $videos[$manufacturer]; ?>

            <?php foreach($veds as $video) { ?>
            <div>
                <iframe style="margin-bottom: 30px;" width="100%" height="236" src="<?php echo $video; ?>" frameborder="2" allowfullscreen></iframe>
            </div>
            <?php } ?>

    </section>

    <?php $i++; } ?>
</div>

<?php echo $footer; ?>
