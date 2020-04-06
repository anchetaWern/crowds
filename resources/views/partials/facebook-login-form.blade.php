<form action="{{ $facebook_login_form_action }}" method="POST" id="facebook-login-form">
  @csrf
  @honeypot
  <input type="hidden" name="_fb_access_token" id="_fb_access_token">
</form>