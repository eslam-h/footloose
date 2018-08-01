<?php echo $header; ?>

<div class="container">
	<ul class="breadcrumb space-30">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
	  <div class="panel-heading"><h1 class="panel-title panel-v2 space-20"><?php echo $heading_title; ?></h1></div>
      <?php if ($products) { ?>
      <?php   require( ThemeControlHelper::getLayoutPath( 'product/product_filter.tpl' ) );   ?>
       <?php require( ThemeControlHelper::getLayoutPath( 'common/product_collection.tpl' ) );  ?>
      <?php } else { ?>
      <p class="space-top-20 space-25"><?php echo $text_empty; ?></p>
      <div class="buttons space-40 clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-v1"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>