<div class="tab-pane">
  <div id="content">
    <table class="table settings_table">
      <tr>
        <td class="col-xs-3">
          <h5><strong><?php echo $entry_status; ?></strong></h5>
          <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?= $entry_status_help ?></span>
        </td>
        <td>
          <div class="col-xs-4">
            <select id="status" name="emailverification[enabled]" id="input-status" class="form-control">
              <?php  if(!empty($settings['emailverification']['enabled']) && $settings['emailverification']['enabled'] == '1') { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select>
          </div>
        </td>
      </tr>
    </table>
    <table id="showHideTable" class="table settings_table">
      <?php  $languageCount = count($languages); ?>
      <tr>
        <td class="col-xs-3">
          <h5><strong>Select customer group</strong></h5>
          <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?= $entry_customer_group_help ?></span>
        </td>
        <td>
          <div class="col-xs-4">
            <?php foreach($customerGroups as $customerGroup) { ?>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="emailverification[customerGroups][<?php echo $customerGroup['customer_group_id']?>]" <?php echo isset($settings['emailverification']['customerGroups'][$customerGroup['customer_group_id']]) && ($settings['emailverification']['customerGroups'][$customerGroup['customer_group_id']] == 'on') ? 'checked="checked"' : ''; ?>/> <?php echo $customerGroup['name'] ?>
              </label>
            </div>
            <?php } ?>
          </div>
        </td>
      </tr>
      <tr>
        <td class="col-xs-3">
          <div class="userMessageLegend">
            <h5><strong><span class="required">*</span> <?php echo $user_mail; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i><?php echo $user_mail_help; ?></span>
          </div>
        </td>
        <td>
          <div class="col-md-9">
            <ul class="nav nav-tabs mainMenuTabs">
              <?php $class="active"; foreach ($languages as $language) { ?>
              <li class="<?php  echo $class; ?>"><a href="#email_<?php echo $language['language_id'];?>" data-toggle="tab"><img src="<?php echo $language['flag_url'] ?>" title="<?php echo $language['name']; ?>" /></a></li>
              <?php  $class="";} ?>
            </ul>
          </div>
          <div class="tab-content">
            <?php  $class="active"; foreach ($languages as $language) { ?>
            <div class="emailLanguageWrapper row-fluid tab-pane <?php echo $class; ?>" id="email_<?php echo $language['language_id'];?>">
              
              <div class="col-md-9">
                <div class="form-group" style="padding-top:0;">
                  <label for="data['Settings'][subject][<?php echo $language['language_id']; ?>]">
                    <span class="required">*</span> <?php echo $subject_text;  ?> :
                  </label>
                  <input type="text" required="required" class="subject form-control" name="emailverification[subject][<?php echo $language['language_id']; ?>]" value="<?php if(!empty($settings['emailverification']['subject'][$language['language_id']])) { echo $settings['emailverification']['subject'][$language['language_id']]; } else { echo $default_subject; } ?>" />
                </div>
                
              </div>
              
              <br>
              <div class="col-md-9">
                <?php if(isset($error_subject[$language['language_id']])){ ?>
                <span class="error"><?php echo $error_subject[$language['language_id']]; ?></span>
                <?php } ?>
                <textarea name="emailverification[message][<?php echo $language['language_id']; ?>]"  class="form-control" id="message_<?php echo $language['language_id']; ?>">
                <?php if(!empty($settings['emailverification']['message'][$language['language_id']])) { echo $settings['emailverification']['message'][$language['language_id']]; } else { echo $default_message;  } ?>
                </textarea>
              </div>
              
            </div>
            <?php $class="";} ?>
          </div>
        </td>
      </div>
    </div>
  </tr>
</table>
<script type="text/javascript"><!--
    <?php foreach ($languages as $language) { ?>
    $("#message_<?php echo $language['language_id']; ?>").summernote({height: 300});
    <?php } ?>
</script> 
</div>
</div>  
</div>
<script>
    $(function() {
       var $typeSelector = $('#status');
       var $toggleArea = $('#showHideTable');
     if ($typeSelector.val() === '1') {
               $toggleArea.show(); 
           }
           else {
               $toggleArea.hide(); 
           }
       $typeSelector.change(function(){
           if ($typeSelector.val() === '1') {
               $toggleArea.show(400); 
           }
           else {
               $toggleArea.hide(400); 
           }
       });
    });
</script>