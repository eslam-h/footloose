<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-location" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-location" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-latitude"><?php echo $entry_latitude; ?></label>
            <div class="col-sm-10">
              <input type="number" name="latitude" value="<?php echo $latitude; ?>" placeholder="<?php echo $entry_latitude; ?>" id="input-latitude" class="form-control" />
              <?php if ($error_latitude) { ?>
              <div class="text-danger"><?php echo $error_latitude; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-longitude"><?php echo $entry_longitude; ?></label>
            <div class="col-sm-10">
              <input type="number" name="longitude" value="<?php echo $longitude; ?>" placeholder="<?php echo $entry_longitude; ?>" id="input-longitude" class="form-control" />
              <?php if ($error_longitude) { ?>
              <div class="text-danger"><?php echo $error_longitude; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
            <div class="col-sm-10">
              <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
              <?php if ($error_telephone) { ?>
              <div class="text-danger"><?php echo $error_telephone; ?></div>
              <?php  } ?>
            </div>
          </div>


          <br>
          <ul class="nav nav-tabs" id="language">
            <?php foreach ($languages as $language) { ?>
            <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <?php foreach ($languages as $language) { ?>





            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="location[<?php echo $language['language_id']; ?>][name] ?>" value="<?php echo isset($location[$language['language_id']]) ? $location[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address<?php echo $language['language_id']; ?>"><?php echo $entry_address; ?></label>
                <div class="col-sm-10">
                  <textarea type="text" name="location[<?php echo $language['language_id']; ?>][address] ?>" placeholder="<?php echo $entry_address; ?>" rows="2" id="input-address" class="form-control"><?php echo isset($location[$language['language_id']]) ? $location[$language['language_id']]['address'] : ''; ?></textarea>
                  <?php if (isset($error_address[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_address[$language['language_id']]; ?></div>
                  <?php } ?>
                </div>
              </div>

              <?php if ($language['language_id'] == 2 ) { ?>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_type; ?></label>
                  <div class="col-sm-10">
                    <select id = "input-name" class="form-control" name="location[<?php echo $language['language_id']; ?>][type] ?>">
                      <option value = "<?php echo $ar_text_footloose; ?>"><?php echo $ar_text_footloose; ?></option>
                      <option value = "<?php echo $ar_text_crocs_concept; ?>"><?php echo $ar_text_crocs_concept; ?></option>
                      <option value = "<?php echo $ar_text_crocs_outlet; ?>"><?php echo $ar_text_crocs_outlet; ?></option>
                    </select>
                    <?php if ($error_type) { ?>
                    <div class="text-danger"><?php echo $error_type; ?></div>
                    <?php } ?>
                  </div>
                </div>
              <?php } else { ?>
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_type; ?></label>
                  <div class="col-sm-10">
                    <select id = "input-name" class="form-control" name="location[<?php echo $language['language_id']; ?>][type] ?>">
                      <option value = "<?php echo $text_footloose; ?>"><?php echo $text_footloose; ?></option>
                      <option value = "<?php echo $text_crocs_concept; ?>"><?php echo $text_crocs_concept; ?></option>
                      <option value = "<?php echo $text_crocs_outlet; ?>"><?php echo $text_crocs_outlet; ?></option>
                    </select>
                    <?php if ($error_type) { ?>
                    <div class="text-danger"><?php echo $error_type; ?></div>
                    <?php } ?>
                  </div>
                </div>

              <?php } ?>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-open<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" data-container="#content" title="<?php echo $help_open; ?>"><?php echo $entry_open; ?></span></label>
                <div class="col-sm-10">
                  <textarea name="location[<?php echo $language['language_id']; ?>][open] ?>" rows="2" placeholder="<?php echo $entry_open; ?>" id="input-open" class="form-control"><?php echo isset($location[$language['language_id']]) ? $location[$language['language_id']]['open'] : ''; ?></textarea>
                </div>
              </div>











            </div>
            <?php } ?>
          </div>




        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

<script type="text/javascript"><!--
  $('#language a:first').tab('show');
  //--></script></div>