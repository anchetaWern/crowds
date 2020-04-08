@if (Auth::user()->setup_step == 0)
<div class="modal" id="user-setup-modal-0" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 1: Connect Facebook Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        @include('partials.alert')

        @if (!session('alert'))
        <div class="alert alert-info">
        Your Facebook account will be used to validate your identity. Your profile picture will be displayed for your posts and bids.
        </div>
        @endif

        <div class="row justify-content-center">
          @include('partials.facebook-login-button')
        </div>

      </div>
      <div class="modal-footer">
        @include('partials.facebook-login-form', ['facebook_login_form_action' => "/setup/step-one"])
      </div>
    </div>
  </div>
</div>
@endif