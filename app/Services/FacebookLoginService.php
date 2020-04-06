<?php 
namespace App\Services;

class FacebookLoginService implements SocialLoginServiceInterface {
 
	private $fb;
	private $access_token;

	public function __construct($access_token) {
		$this->access_token = $access_token;

		$this->fb = new \Facebook\Facebook([
          'app_id' => config('services.facebook.app-id'),           
          'app_secret' => config('services.facebook.app-secret'),   
          'graph_api_version' => 'v5.0',
        ]);
	}


	public function getUserData() {
		// note: borderline hacky. 
        // might be more secure if Facebook PHP SDK is used without
        // the help of JavaScript SDK
		try {
		    $profile_response = $this->fb->get('/me?fields=name,email', $this->access_token);
		    $profile_body = $profile_response->getDecodedBody();

		    $picture_response = $this->fb->get('/me/picture?redirect=false&type=large', $this->access_token);
		    $picture_body = $picture_response->getDecodedBody();
		    $profile_data = array_merge($profile_body, $picture_body);
		    return $profile_data;

		} catch(\Exception $e) {
		    // the only way this will go wrong is if the user is messing around with hidden inputs
		    return false;
		}
	}
}