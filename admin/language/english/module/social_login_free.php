<?php
// Heading
$_['heading_title']             = ' <span>Social Login Free</span> <span style="color:#449DD0; font-weight:bold">Please PayPal Donate - rinkuyadav999@gmail.com</span>';
$_['heading_title_main']        = 'Social Login Free';
$_['text_edit']                 = 'Edit Module - <span style="color:#449DD0; font-weight:bold">Please PayPal Donate - rinkuyadav999@gmail.com</span>';

// Tab
$_['text_module']               = 'Modules';
$_['text_setting']              = 'Settings';
$_['text_instruction']          = 'Instructions';

// Modules
$_['entry_size']                = 'Button Size:';
$_['entry_status']              = 'Status:';

$_['text_icons']                = 'Icons';
$_['text_small']                = 'Small';
$_['text_medium']               = 'Medium';
$_['text_large']                = 'Large';
$_['text_huge']                 = 'Huge';

// Settings
$_['text_setting_basic']        = 'Basic';
$_['text_setting_field']        = 'Social buttons & Fields';
$_['text_setting_provider']     = 'API settings';

$_['entry_name']                = 'Module name';
$_['entry_config_files']        = 'Config files';

$_['entry_version_check']       = '';
$_['text_no_update']            = '';
$_['text_new_update']           = '';
$_['text_error_update']         = '';
$_['text_error_failed']         = '';
$_['button_version_check']      = '';

$_['entry_return_page']         = 'Return Page';
$_['entry_base_url_index']      = 'Activate index route';
$_['entry_background_img']      = 'Background of last popup screen';

$_['entry_sort_order']          = 'Activate social login buttons and set colors';
$_['text_google']               = 'Google+';
$_['text_facebook']             = 'Facebook';
$_['text_twitter']              = 'Twitter';

$_['text_background_color']     = 'Button color';
$_['text_background_color_active'] = 'on Push';


$_['entry_fields_sort_order']   = 'After log in, How much fields you want to collect';
$_['text_firstname']            = 'First name';
$_['text_lastname']             = 'Last name';
$_['text_phone']                = 'Phone';
$_['text_mask']                 = 'Mask';
$_['text_address_1']            = 'Address 1';
$_['text_address_2']            = 'Address 2';
$_['text_city']                 = 'City';
$_['text_postcode']             = 'Postcode';
$_['text_country_id']           = 'Country';
$_['text_zone_id']              = 'Region';
$_['text_password']             = 'Password';
$_['text_confirm']              = 'Confirm password';
$_['text_company']              = 'Company name';
$_['text_company_id']           = 'Company id';
$_['text_tax_id']               = 'Tax id';

$_['text_app_settings']         = 'App settings';
$_['text_app_id']               = 'App id:';
$_['text_app_key']              = 'App key:';
$_['text_app_secret']           = 'App secret:';

$_['text_success']              = 'Success: You have modified module Social Login!';
$_['button_save_and_stay']      = 'Save and Stay';

// Error
$_['error_permission']          = 'Warning: You do not have permission to modify module  Social Login!';
$_['warning_app_settings']      = 'Want to know your App Id and secret?';
$_['warning_app_settings_full'] = 'Please follow the <a href="#instruction" data-toggle="tab">instructions</a> to get them.';

$_['text_instructions_full']    ='
<div class="row">
  <div class="col-md-12">
    <div class="wrap-5">
      <h1>How to set up social apps?</h1>

      <ul class="nav nav-tabs">
        <li><a href="#google_plus"  data-toggle="tab"><i class="icon-google-plus"></i> Google+</a></li>
        <li class="active"><a href="#facebook"  data-toggle="tab"><i class="icon-facebook"></i> Facebook</a></li>
        <li><a href="#twitter"  data-toggle="tab"><i class="icon-twitter-bird"></i> Twitter</a></li>
      </ul>
      <div class="tab-content">
	  
			<div id="google_plus" class="tab-pane">
			<div class="tab-title">Steps to get Google app and secret:</div>
			<div class="tab-body">
            <ol>
            <li>Visit the Google Developers console <a href="https://cloud.google.com/console" target="_blank"> https://cloud.google.com/console</a></li>
            <li>Create a new project</li>
            <img src="view/image/social_login_free/google/01.png" class="img-thumbnail img-responsive" />
            <li>Fill in the project name and click save – wait for several seconds for the project to be created. </li>
            <img src="view/image/social_login_free/google/02.png" class="img-thumbnail img-responsive" />
            <li>Select the newly created project. Go to APIs & auth on the left menu and then to Credentials</li>
            <img src="view/image/social_login_free/google/03.png" class="img-thumbnail img-responsive" />
            <li>Click button - create new client id</li>
            <li>In the popup select web applications and fill in the urls. Please fill in the Redirect URIs with the correct url</li>
            <div class="bs-callout bs-callout-warning"><h4>Your Redirect URL</h4><p>'.HTTPS_CATALOG.'index.php?route=module/social_login_free/hybridauth&hauth.done=Google</p></div>
            <img src="view/image/social_login_free/google/04.png" class="img-thumbnail img-responsive" />
            <li>Fill in the Client Id and Client Secret in the Social Login settings tab for Google+</li>
            <img src="view/image/social_login_free/google/05.png" class="img-thumbnail img-responsive" />
            </ol>
            <div class="bs-callout bs-callout-warning"><h4>Attention!</h4><p>If you get an error from google, saying the the app needs to be provided with a name, please follow the following steps:</p></div>
            <ol>
              <li>Go to App settings in google dev console.</li>
              <li>Go to tab APIs & auth  and then to Consent Screen</li>
              <li>Fill the required fields as shown on the image below</li>
              <img src="view/image/social_login_free/google/06.png" class="img-thumbnail img-responsive" />
              <li>Save and wait for several minutes for the Google api to refresh its data then test the login.</li>
            </ol>
          </div>
        </div>
		
	  
	  
        <div id="facebook" class="tab-pane active">
          <div class="tab-title"><i class="icon-facebook"></i> Steps to get Facebook app id and secret:</div>
          <div class="tab-body">
            <ol>
            <li>Visit facebook developers page <a href="https://developers.facebook.com/" target="_blank">https://developers.facebook.com/</a></li>
            <li>In menu Apps – select create new app</li>
            <img src="view/image/social_login_free/facebook/01.png" class="img-thumbnail img-responsive" />
            <li>In the popup window fill in the Display Name and Choose category</li>
            <img src="view/image/social_login_free/facebook/02.png" class="img-thumbnail img-responsive" />
            <li>After the app is created, go to settings in the left menu</li>
            <li>Fill in Namespace and Contact Email</li>
            <li>Click Add platform and select Website</li>
            <li>Fill in the Site url and mobile site url and save</li>
            <div class="bs-callout bs-callout-warning"><h4>Your Site URL</h4><p>'.HTTPS_CATALOG.'</p></div>
            <img src="view/image/social_login_free/facebook/03.png" class="img-thumbnail img-responsive" />
            <li>In the same page ask to show the App Secret</li>
            <li>Do not forget to activate the APP in the left manu - Status & Review and turn on the APP by sliding the bar to the right</li>
            <li>Fill in the App ID and App Secret in the Social Login settings tab for Facebook</li>
            </ol>
          </div>
        </div>
		
        <div id="twitter" class="tab-pane">
          <div class="tab-title"><i class="icon-twitter-bird"></i> Steps to get Twitter app key and secret:</div>
          <div class="tab-body">
            <ol>
            <li>Visit twitter developers page <a href="https://dev.twitter.com/" target="_blank">https://dev.twitter.com/</a></li>
            <li>In menu near your icon – select my applications</li>
            <img src="view/image/social_login_free/twitter/01.png" class="img-thumbnail img-responsive" />
            <li>Create new app</li>
            <img src="view/image/social_login_free/twitter/02.png" class="img-thumbnail img-responsive" />
            <li>Fill in all the fields and click save</li>
            <img src="view/image/social_login_free/twitter/03.png" class="img-thumbnail img-responsive" />
            <div class="bs-callout bs-callout-warning"><h4>Your Website and Callback url</h4><p>'.HTTPS_CATALOG.'</p></div>
            <li>Then select your newly created app and go to tab Settings</li>
            <li>Check the checkbox “Allow this application to be used to Sign in with Twitter" and click Save</li>
            <img src="view/image/social_login_free/twitter/05.png" class="img-thumbnail img-responsive" />
            <li>Then go to tab API Keys and click "Generate my access token</li>
            <li>Fill in the App Key and App Secret in the Social Login settings tab for Twitter</li>
            <img src="view/image/social_login_free/twitter/04.png" class="img-thumbnail img-responsive" />
            </ol> 
          </div>
        </div>

    </div>
  </div>
</div>
';
?>