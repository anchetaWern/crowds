@if (Auth::user()->setup_step == 2)
<div class="modal" id="user-setup-modal-2" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 3: How can you be contacted?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          Your phone number or your Facebook Messenger ID will be used for communication between the person who made the order and the person who submitted the bid. This information will only be available to both parties once a request has been accepted.
        </div>

        <form action="/setup/step-three" method="POST" id="user-contact-form">
          @method('PATCH')
          @csrf
          @honeypot

          <div class="form-group row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

              <div class="col-md-6">
                  <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number', Auth::user()->detail->phone_number) }}" placeholder="eg. 09176543210" autocomplete="off">

                  @error('phone_number')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="messenger_id" class="col-md-4 col-form-label text-md-right">{{ __('Messenger ID') }}</label>

              <div class="col-md-6">
                  <input id="messenger_id" type="text" class="form-control @error('messenger_id') is-invalid @enderror" name="messenger_id" value="{{ old('messenger_id', Auth::user()->detail->messenger_id) }}" placeholder="eg. laong.laan25" autocomplete="off">

                  <small class="text-secondary">You can find this on your Messenger app by clicking on your profile picture on the upper left. Then under profile, you can see the username. Simply omit the m.me/ part.</small>

                  @error('messenger_id')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">

        <form action="/setup/back" method="POST">
          @method('PATCH')
          @csrf
          @honeypot
          <button class="btn btn-secondary">Back</button>
        </form>

        <button class="btn btn-primary" form="user-contact-form">Next</button>
      </div>
    </div>
  </div>
</div>
@endif