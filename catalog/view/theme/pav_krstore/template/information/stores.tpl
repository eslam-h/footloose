<?php  echo $header; ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd9QTt9S_f_9FMJSNh9MeV7gttcvyVM1A"></script>
<script type="text/javascript" src="catalog/view/javascript/gmap/gmap3.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/gmap/gmap3.infobox.js"></script>

<script type="text/javascript">
    <?php $first = 'foot'; $all_stores = array(); foreach($locations as $old_type => $arr) { $type = str_replace(" ","_",$old_type); ?>

    <?php foreach($arr as $location) {
            $all_stores[$type][] = array(
                            'shop_name' => $location['name'],
                    'address'   => $location['address'],
                    'lat'       => $location['latitude'],
                    'lng'       => $location['longitude']
        );
        }

        echo ("var ".$type. " = " . json_encode($all_stores[$type])); ?>

    <?php } ?>


</script>

<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>

    <h1><?php echo $heading_title; ?></h1>

    <div class="panel panel-default" style="height: 700px">
        <div class="panel-body">
            <ul class="nav nav-pills">
                <?php $counter = 0;  $check = 0; foreach($locations as $old_type => $arr) { $type =
                str_replace(" ","_",$old_type); if($check == 0) { $check = 1; $first = $type; ?>
                <li class="tabs active" onclick="all_locations(<?php echo $type ; ?>);"><a href="#<?php echo($type); ?>" data-toggle="tab" ><?php echo($old_type); ?></a>
                </li>
                <?php } else { ?>
                <li class="tabs" onclick="all_locations(<?php echo $type ; ?>);""><a href="#<?php echo($type); ?>" data-toggle="tab" ><?php echo($old_type); ?></a></li>
                <?php } } ?>
            </ul>

            <br>

            <div class="row"></div>
            <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12" style="height: 100%; overflow: scroll; overflow-x:hidden; word-wrap: break-word;">
                <div class="tab-content">
                    <?php $check = 0; foreach($locations as $old_type => $arr) { $type = str_replace(" ","_",$old_type);
                    ?>
                    <?php if($check == 0) { $check = 1; $first = $type; ?>
                    <div class="tab-pane active" id="<?php echo($type); ?>" style="height: 550px; ">
                        <?php foreach($arr as $location) { ?>
                        <div class="address" style="border-bottom: 1px solid #ccc; cursor: pointer;" data-location="<?php echo $location['address']; ?>--<?php echo $location['latitude']; ?>--<?php echo $location['longitude']; ?>--<?php echo $location['name']; ?>" >
                            <p style="color: #0b0b0b; font-size: 20px;" > <?php echo($location['name']); ?> </p>
                            <?php echo($location['address']); ?> <br>
                            <p style="color: #0b0b0b; display: inline; font-size: 14px;"><?php echo $text_tele; ?></p> <p style="direction:ltr; display:inline-block"> <?php echo($location['telephone']); ?></p> <br>
                            <p <p style="display:block"> <?php echo($location['open']); ?> </p>
                            <br>
                        </div>
                        <br>
                        <?php } ?>
                    </div>
                    <?php } else { ?>
                    <div class="tab-pane" id="<?php echo($type); ?>" style="height: 550px;">

                        <?php foreach($arr as $location) { ?>
                        <div class="address" style="border-bottom: 1px solid #ccc; cursor: pointer;" data-location="<?php echo $location['address']; ?>--<?php echo $location['latitude']; ?>--<?php echo $location['longitude']; ?>--<?php echo $location['name']; ?>" >
                            <p style="color: #0b0b0b; font-size: 20px;" > <?php echo($location['name']); ?> </p>
                            <?php echo($location['address']); ?> <br>
                            <p style="color: #0b0b0b; display: inline; font-size: 14px;"><?php echo $text_tele; ?></p> <p style="direction:ltr; display:inline-block"> <?php echo($location['telephone']); ?></p> <br>
                            <p <p style="display:block"> <?php echo($location['open']); ?> </p>
                            <br>
                        </div>
                        <br>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <?php } ?>

                </div>
            </div>
            <div id="my-map" class="col-lg-8 col-md-9 col-sm-9 col-xs-12" style="height: 550px;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var markers = [];

    var lat = ( <?php echo $first; ?> [0]['lat'] );
    var lng = ( <?php echo $first; ?> [0]['lng'] );

    var myLatlng = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

    var map = new google.maps.Map(document.getElementById('my-map'), {
        zoom: 10,
        center:myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < <?php echo $first; ?>.length; i++) {

        marker = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $first; ?>[i]['lat'], <?php echo $first; ?>[i]['lng']),
        map: map
    });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent("<br>"+"<strong>"+<?php echo $first; ?>[i]['shop_name']+"</strong><br>"+<?php echo $first; ?>[i]['address'] );
                infowindow.open(map, marker);
            }
        })(marker, i));

        markers.push(marker);

    }



    function all_locations ( arr ) {

        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }

        markers = [];

        var lat = ( arr[0]['lat'] );
        var lng = ( arr[0]['lng'] );

        var myLatlng = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

        map.setCenter(myLatlng);

        for (i = 0; i < arr.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(arr[i]['lat'], arr[i]['lng']),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent("<br>"+"<strong>"+arr[i]['shop_name']+"</strong><br>"+arr[i]['address']);
                    infowindow.open(map, marker);
                }
            })(marker, i));

            markers.push(marker);
        }
    }

    $('.address').click(function() {

        var location = $(this).data('location').split('--');

        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }

        markers = [];

        var lat = ( location[1] );
        var lng = ( location[2] );

        var i = 0;

        var myLatlng = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

        map.setCenter(myLatlng);

        marker = new google.maps.Marker({
            position: new google.maps.LatLng(location[1], location[2]),
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent("<br>"+"<strong>"+location[3]+"</strong><br>"+location[0]);
                infowindow.open(map, marker);
            }
        })(marker, i));

        markers.push(marker);
    });
</script>

<?php //print_r($all_stores); ?>

<?php echo $footer; ?>