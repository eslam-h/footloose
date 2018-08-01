</div>
<?php if( !($helper->getConfig('enable_pagebuilder') && $helper->isHomepage())  ){ ?>
	<?php
	  $blockid = 'mass_bottom';
	  $blockcls = '';
	  $ospans = array(1=>12);
	  $tmcols = 'col-sm-12 col-xs-12';
	  require( ThemeControlHelper::getLayoutPath( 'common/block-cols.tpl' ) );
	?>
<?php } ?>

<br>

<footer id="footer" class="nostylingboxs" style="background-color:#363b3f">
	<?php
		$blockid = 'footer_bottom';
		$blockcls = '';
		$ospans = array(1=>3,2=>3,3=>3,4=>3);
		$tmcols = 'col-sm-4 col-xs-12';
		require( ThemeControlHelper::getLayoutPath( 'common/block-footcols.tpl' ) );
		if( count($modules) <=0 ){
			$footer_layout = $helper->getConfig('footer_layout','theme');
			if($footer_layout == "default") {
				require( ThemeControlHelper::getLayoutPath( 'common/footer/default.tpl' ) );
			} 
			else {
				require( ThemeControlHelper::getLayoutPath( 'common/footer/footer_bottom.tpl' ) );
			}
		}
	?>
</footer>
<div id="back-to-top"><a class="scrollup" href="#" style="display:none"><i class="fa fa-angle-up" ></i><?php echo 'TOP';?></a></div>
 
<?php if( $helper->getConfig('enable_paneltool',0) ){  ?>
  <?php  echo $helper->renderAddon( 'panel' );?>
<?php } ?>
<?php
  $offcanvas = $helper->getConfig('offcanvas','category');
  if($offcanvas == "megamenu") {
      echo $helper->renderAddon( 'offcanvas');
  } else {
      echo $helper->renderAddon( 'offcanvas-category');
  }

  ?> 

</div>
<?php
  $offcanvas = $helper->getConfig('offcanvas','category');
  if($offcanvas == "megamenu") {
      echo $helper->renderAddon( 'offcanvas');
  } else {
      echo $helper->renderAddon( 'offcanvas-category');
  }
?>

</body></html>

<script type="text/javascript">
	




</script>
