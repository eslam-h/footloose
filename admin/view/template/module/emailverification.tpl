<?php echo $header ?>
<?php echo $column_left ?>

<div id="content">
	<div class="page-header">
        <div class="container-fluid">
          <h1><i class="fa fa-check"></i>&nbsp;<?php echo $module_title; ?></h1>
          <ul class="breadcrumb">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
  	</div>	

  	<div class="container-fluid">
  		<div class="panel panel-default">
  			<div class="panel-heading">  			 	
  				<h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;"><?= $text_module_settings ?></span></h3>
  				<div id="storeSwitcher" class="storeSwitcherWidget" style="position: absolute;right: 18px;top: -8px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><?php echo $store['name']; if($store['store_id'] == 0) echo " <strong>(".$text_default.")</strong>"; ?>&nbsp;<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach ($stores  as $st) { ?>
                                <li><a href="index.php?route=module/emailverification&store_id=<?php echo $st['store_id'];?>&token=<?php echo $token; ?>"><?php echo $st['name']; ?></a></li>
                            <?php } ?> 
                        </ul>
                    </div>
                </div>
  			</div>
  			<div class="panel-body">
  				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>" />
  					<div class="tabbable">
  						<div class="tab-navigation form-inline">
  							<ul class="nav nav-tabs mainMenuTabs" id="settingsTab">
  								<li class="active"><a href="#emailverification_settings" data-toggle="tba"><i class="fa fa-cogs">&nbsp;</i><?php echo $text_tab_settings ?></a></li>
  							</ul>
  							<div class="tab-buttons">
	                            <button type="submit" class="btn btn-success save-changes"><i class="fa fa-check"></i>&nbsp;<?php echo $button_save?></button>
	                            <a onclick="location = '<?php echo $cancel; ?>'" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;<?php echo $button_cancel?></a>
                        	 </div> 
  						</div>  
  						<div class="tab-content">
  							<div id="emailverification_settings" class="tab-pane fade in active"><?php require(DIR_APPLICATION.'view/template/module/emailverification/tab_settings.php') ?></div>
  						</div>						
  					</div>  					
  				</form>
  			</div>
  		</div>  		
  	</div>
</div>

<style type="text/css">
	.tab-buttons{
		position: absolute;
    	right: 37px;
    	top: 180px;
	}
	#storeSwitcher{
		position: absolute;
	    right: 18px;
	    top: 10px;
	}
</style>