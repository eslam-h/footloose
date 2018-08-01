<link href="catalog/view/theme/pav_krstore/template/information/slick/slick.css" rel="stylesheet" type="text/css">
<link href="catalog/view/theme/pav_krstore/template/information/slick/slick-theme.css" rel="stylesheet" type="text/css">

<style type="text/css">
/*
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
  }*/
</style>

<script src="catalog/view/theme/pav_krstore/template/information/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script>
/*  $(document).on('ready', function() {
    $(".regular").slick({
      dots:           true,
      infinite:       true,
      slidesToShow:   3,
      slidesToScroll: 1,
      autoplay:       true,
//            autoplaySpeed:  70000,
      responsive: [
        {
          breakpoint: 650,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 400,
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
*/
</script>


<div class="row" style="margin: 0 10% 0 10%" >


  <section class="regular slider" style="display: flex">


    <?php foreach ($banners as $banner) { ?>
      <?php if ($banner['link']) { ?>
      <a href="<?php echo $banner['link']; ?>" >
        <div style="margin: 5%">
          <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
        </div>
      </a>
      <?php } 
     } ?>

  </section>

</div>