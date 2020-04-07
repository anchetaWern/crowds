<div class="form-group">
  <label for="service_type">Service type</label>
  <select class="custom-select @error('service_type') is-invalid @enderror" name="service_type" id="service_type">
    <option>What type of service do you need?</option>
    @foreach ($service_types as $service)
    <option value="{{ $service->id }}" {{ isSelected($service->id, old('service_type')) }}>{{ $service->name }}</option>
    @endforeach
  </select>

  @error('service_type')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>

<div class="form-group">
  <label for="description">What do you need?</label>
  <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="{{ $description_placeholder }}"></textarea>
    
  @error('description')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>

<button class="btn btn-primary float-right">Post</button>