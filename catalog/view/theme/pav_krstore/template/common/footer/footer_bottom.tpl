<div >
	<div class="container">
		<div class="row">
			<div class="col-left col-lg-4 col-md-4 col-sm-5 col-xs-12">
				<div class="space-15 space-top-15">
					<?php
						if($content=$helper->getLangConfig('widget_about_us')){
							echo $content;
						}
					?>
				</div>
				<div class="space-15 space-top-15">
					<?php
						if($content=$helper->getLangConfig('widget_business_hours')){
							echo $content;
						}
					?>
				</div>

				<div style="margin-top: -10%; font-size: 12px; " >
					<?php echo $text_develop; ?> <a style="color: #ffffff;" href="<?php echo $geek ?>"> <?php echo $text_geek; ?> </a> <br>

					<?php if($lang_id == 1) { ?>
					<?php echo $text_copy; ?> <span style="color: #ffffff;"> <?php echo $text_foot; ?> </span> <?php echo $text_rights; ?>
					<?php } else { ?>
					<?php echo $text_rights; ?> <span style="color: #ffffff;"> <?php echo $text_foot; ?> </span>
					<?php } ?>
					<br>

				</div>

				<br>

			</div>
			<div class="col-right col-lg-8 col-md-8 col-sm-7 col-xs-12">
				<div class="row">

					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title" style="color: #ffffff;"><?php echo $text_home; ?></h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?php echo $aboutUs; ?>"><?php echo $text_aboutUs;?></a></li>
							<li><a href="<?php echo $lifestyle; ?>"><?php echo $text_lifestyle;?></a></li>
							<li><a href="<?php echo $stores; ?>"><?php echo $text_stores;?></a></li>
							<li><a href="<?php echo $special; ?>"><?php echo $text_special;?></a></li>
						</ul>
					</div>

					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title" style="color: #ffffff;"><?php echo $text_categories; ?></h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?php echo $men; ?>"><?php echo $text_men;?></a></li>
							<li><a href="<?php echo $women; ?>"><?php echo $text_women;?></a></li>
							<li><a href="<?php echo $boys; ?>"><?php echo $text_boys;?></a></li>
							<li><a href="<?php echo $girls; ?>"><?php echo $text_girls;?></a></li>
						</ul>
					</div>

					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15" style=" display:none;">
						<div class="panel-heading">
							<h4 class="panel-title" style="color: #ffffff;"><?php echo $text_usefulLinks; ?></h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer;?></a></li>
							<li><a href="<?php echo $special; ?>"><?php echo $text_special;?></a></li>
							<li><a href="<?php echo $newArrivals; ?>"><?php echo $text_newArrivals;?></a></li>
							<li><a href="<?php echo $newsAndEvents; ?>"><?php echo $text_newsAndEvents;?></a></li>
						</ul>
					</div>


					<div class="column col-lg-3 col-md-3 col-sm-6 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title" style="color: #ffffff;"><?php echo $text_customerService;?></h4>
						</div>
						<ul class="list-unstyled">
							<li><a href="<?php echo $faqs; ?>"><?php echo $text_faqs;?></a></li>
							<li><a href="<?php echo $contact; ?>"><?php echo $text_contact;?></a></li>
							<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap;?></a></li>
						</ul>
					</div>





				</div>


				<style>
                    a.fa {
                        padding: 10px;
                        font-size: 30px;
                        width: 50px;
                        height: 50px;
                        text-align: center;
                        text-decoration: none;
                        margin: 5px 2px;
                        border-radius: 50%;
                    }

                    a.fa:hover {
                        opacity: 0.7;
                    }

                    a.fa-facebook {
                        background: #3B5998;
                        color: white;
                    }

                    a.fa-youtube {
                        background: #bb0000;
                        color: white;
                    }

                    a.fa-instagram {
                        background: #125688;
                        color: white;
                    }

                </style>
				<div class="row">
					<div class="column col-lg-6 col-md-6 col-sm-12 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title" style="color: #ffffff;"><?php echo $text_followFootloose;?></h4>
                            <a href="https://www.facebook.com/FootlooseStores/" class="fa fa-facebook" target="_blank"></a>
                            <a href="#" class="fa fa-youtube" style=" display:none;"></a>
                            <a href="https://www.instagram.com/footloose_stores/" class="fa fa-instagram" target="_blank"></a>
						</div>
					</div>

					<div class="column col-lg-6 col-md-6 col-sm-12 col-xs-12 space-15 space-top-15">
						<div class="panel-heading">
							<h4 class="panel-title" style="color: #ffffff;"><?php echo $text_followCrocs; ?></h4>
                            <a href="https://www.facebook.com/crocsegypt/?fref=ts" class="fa fa-facebook" target="_blank"></a>
                            <a href="https://www.youtube.com/channel/UCZHpz31R6hQMjC7113p4-mQ" class="fa fa-youtube" target="_blank"></a>
                            <a href="https://www.instagram.com/crocs/?hl=en" class="fa fa-instagram" target="_blank"></a>
						</div>
					</div>
				</div>

					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a style="color: #ffffff;" href="<?php echo $DeliveryTermsConditions; ?>"><?php echo $text_DeliveryTermsConditions;?></a>,
                            <a style="color: #ffffff;" href="<?php echo $privacyPolicy; ?>"><?php echo $text_privacyPolicy;?></a>
						</div>


						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<img alt="" src="image/catalog/demo/NBE_logo.png" />
						</div>

					</div>
				</div>
		</div>
	</div>
</div>
