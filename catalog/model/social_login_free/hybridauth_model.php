<?php
class Modelsocialloginfreehybridauthmodel extends Model {

	function process(){
		require_once( "catalog/model/social_login_free/hybrid/auth.php" );
		require_once( "catalog/model/social_login_free/hybrid/endpoint.php" ); 

		Hybrid_Endpoint::process();
	}
}
?>