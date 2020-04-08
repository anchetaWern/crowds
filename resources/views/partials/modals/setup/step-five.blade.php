@if (Auth::user()->setup_step == 4)
<div class="modal" id="user-setup-modal-4" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 5: Notifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="alert alert-info">
          Click the button below so you can receive notifications when someone makes a request in your barangay, someone makes a bid to your request, or when your bid gets accepted. Click <strong>allow</strong> when you get a prompt to enable notifications. If you don't want to receive notifications, simply click on the <strong>Finish Setup</strong> button.
        </div>

        <div class="row justify-content-center">
          <div class="col-md-6 text-center">

            <button type="button" class="btn btn-block btn-success" id="enable-notifications">
              <span class="spinner-border spinner-border-sm button-loader" role="status"></span>
              <span class="button-loader">Please wait...</span>
              <span class="button-text">Enable Notifications</span>
            </button>

            <form action="/setup/step-five" method="POST" id="notifications-form">
              @method('PATCH')
              @csrf
              @honeypot
              <input type="hidden" name="_fcm_token" id="_fcm_token">
            </form>
          </div>
        </div>
      </div>

      <div class="modal-footer">

        <form action="/setup/back" method="POST">
          @method('PATCH')
          @csrf
          @honeypot
          <button class="btn btn-secondary">Back</button>
        </form>

        <button class="btn btn-primary" form="notifications-form">Finish Setup</button>
      </div>
    </div>
  </div>
</div>
@endif