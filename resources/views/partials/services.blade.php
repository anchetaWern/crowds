@foreach ($service_types as $service)
<div class="custom-control custom-checkbox mb-2">
	<input type="checkbox" class="custom-control-input" id="{{ Str::slug($service->name) }}" name="service_type[]" value="{{ $service->id }}" {{ isChecked($service->id, $user_services) }}>
	<label class="custom-control-label" for="{{ Str::slug($service->name) }}">{{ $service->name }}</label>
	<div>
	  <small class="text-secondary">{{ $service->description }}</small>
	</div>
</div>
@endforeach