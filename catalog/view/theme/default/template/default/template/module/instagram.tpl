<link href="catalog/view/theme/pav_krstore/template/information/slick/slick.css" rel="stylesheet" type="text/css"
      xmlns="http://www.w3.org/1999/html">
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
<script>
    $(document).on('ready', function() {
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 6,
            slidesToScroll: 6,
            rtl : <?php echo $rtl; ?>
    });
    });

</script>



<style type="text/css">
    .img1{
       <?php echo $stylesheet; ?>
    }
</style>


<div >
<?php
if($is_error){
?>
<div class="row">
    <h4><?php echo $error; ?><h4>
</div>
<?php
}else{
?>
<div class="row">
    <h3 style="text-align: center; padding-right:5%"><?php echo $title; ?></h3>
    <section class="regular slider">
    <?php foreach ($images as $image){
        echo '<div class="img1">';
        echo '<img src="'.$image.'"/>';
        echo '</div>';
    }
    ?>

<?php } ?>
    </section>
</div>
</div>
