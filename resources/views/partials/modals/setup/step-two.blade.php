@if (Auth::user()->setup_step == 1)
<div class="modal" id="user-setup-modal-1" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Step 2: Where do you live?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="/setup/step-two" method="POST">
        @method('PATCH')
        @csrf
        @honeypot
        <div class="modal-body">

          <div class="form-group row">
              <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('Province') }}</label>

              <div class="col-md-6">
                  <select name="province" id="province" class="form-control @error('province') is-invalid @enderror">
                      <option value="">Select province</option>
                      @foreach($provinces as $province)
                      <option value="{{ $province->id }}">{{ $province->name }}</option>
                      @endforeach
                  </select>

                  @error('province')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>

          <div class="form-group row">
              <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

              <div class="col-md-6">
                  <div class="text-center loader">
                    <div class="spinner-border">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <div>
                    <select name="city" id="city" class="form-control @error('city') is-invalid @enderror">

                    </select>

                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
              </div>
          </div>

          <div class="form-group row">
              <label for="barangay" class="col-md-4 col-form-label text-md-right">{{ __('Barangay') }}</label>

              <div class="col-md-6">
                  <div class="text-center loader">
                    <div class="spinner-border">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <div>
                    <select name="barangay" id="barangay" class="form-control @error('barangay') is-invalid @enderror">

                    </select>

                    @error('barangay')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
              </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Next</button>
        </div>
      </form>

    </div>
  </div>
</div>
@endif