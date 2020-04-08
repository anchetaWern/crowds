@if (Auth::user()->setup_step == 3)
<div class="modal" id="user-setup-modal-3" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 4: Which services will you offer?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="alert alert-info">
          Simply click <strong>Next</strong> if only want to avail services. You can always update your selection later in your account settings page.
        </div>

        <div class="row">
          <div class="col-md-12 text-left">

            <form action="/setup/step-four" method="POST" id="services-form">
              @method('PATCH')
              @csrf
              @honeypot

              <input type="hidden" name="_is_ios" id="_is_ios">

              @include('partials.services')
             
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

        <button class="btn btn-primary" form="services-form">Next</button>
      </div>
    </div>
  </div>
</div>
@endif