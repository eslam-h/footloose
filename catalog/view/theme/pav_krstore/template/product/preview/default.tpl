<style>

    <?php echo $product_style; ?>

</style>


<?php
    $id = rand();
?>

<?php if ($thumb || $images['top']) { ?>

<div class="image-container thumbnails <?php echo $class; ?>">
    <?php if ($thumb) { ?>
    <div class="image thumbnail space-10 product-layout">

        <?php if( $special )  { ?>
            <span class="product-label sale-exist"><span class="product-label-special"><?php echo $objlang->get( 'text_sale' ); ?></span></span>
        <?php } ?>

        <?php

        $datetime1 = date_create($date_available);
        $datetime2 = date_create(date("Y-m-d"));
        $interval = date_diff($datetime1, $datetime2);
        $diff = $interval->format('%R%a days');
?>


<?php if ($quantity<1 && isset($text_out_of_stock) ) { ?>
    <div class="new-product-not-available">
    <p><?php echo $text_out_of_stock; ?></p>
    </div>
    <?php } else if($diff < 30) { ?>
    <div class="new-product">
        <p><?php echo $text_new; ?></p>
    </div>
    <?php } ?>

        <a id="mainImgA" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="imagezoom" >
            <img  src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" data-zoom-image="<?php echo $popup; ?>"   class="product-image-zoom img-responsive"/>
        </a>

    </div>
    <?php } ?>
     <div class="thumbs-preview thumbnails horizontal">
        <?php if ($images['top']) {        $icols = 3; $i= 0; ?>
         <div class="image-additional olw-carousel  owl-carousel-play" id="image-additional"   data-ride="owlcarousel">
             <div id="image-additional-carousel" class="owl-carousel" data-show="<?php echo $icols; ?>" data-pagination="false" data-navigation="true">
                <?php
                if( $productConfig['product_zoomgallery'] == 'slider' && $thumb ) {
                    $eimages = array( 0=> array( 'popup'=>$popup,'thumb'=> $thumb )  );
                    $images['top'] = array_merge( $eimages, $images['top'] );
                }
                 $id2 = 0;
                foreach ($images['top'] as  $image) { ?>
                    <div class="item clearfix">
                        <a id="a<?php echo $id2; ?>" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="imagezoom" data-zoom-image="<?php echo $image['popup']; ?>" data-image="<?php echo $image['popup'];?>" >
                            <img id="i<?php echo $id2++; ?>" src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" data-zoom-image="<?php echo $image['popup']; ?>" class="product-image-zoom img-responsive" />
                        </a>
                    </div>
                <?php

                } ?>
            </div>
            <!-- Controls -->
            <?php
            if(count($images['top'])>$icols){
            ?>
            <!-- <div class="carousel-controls"> -->
                <div class="carousel-controls carousel-controls-v4">
                    <a class="left carousel-control" href="#carousel-<?php echo $id; ?>" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="right carousel-control" href="#carousel-<?php echo $id; ?>" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            <!-- </div> -->
            <?php } ?>
        </div>

        <?php } ?>
    </div>
</div>
<?php } ?>

<script type="text/javascript" src=" catalog/view/javascript/jquery/elevatezoom/elevatezoom-min.js"></script>
<script type="text/javascript"><!--
    $('#image-additional-carousel a').on('click', function() {

        var src = $(this).attr('href');

        $('#mainImgA').attr('href', src);
        $('#image').attr('src', src);
        $('#image').attr('data-zoom-image', src);

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
            // Take the user to a different screen here.
        }
        else {
            $("#image").data('zoom-image', src).elevateZoom({
                responsive: true,
                scrollZoom: true,
                containLensZoom: true
            });
        }
        return false;
    });


    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
        // Take the user to a different screen here.
    }
    else {
        $("#image").elevateZoom({scrollZoom : true});
    }

    //--></script>
