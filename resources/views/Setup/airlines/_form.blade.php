{{-- Shared Airline form. Expects: $airline (nullable) --}}
@php
    $airline = $airline ?? null;
@endphp

<div class="card-body">
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Airline Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Airline Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                   value="{{ old('name', $airline->name ?? '') }}" placeholder="Airline Name">
            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-2">
            <label>IATA Code</label>
            <input type="text" name="iata_code" maxlength="3" class="form-control form-control-sm text-uppercase @error('iata_code') is-invalid @enderror"
                   value="{{ old('iata_code', $airline->iata_code ?? '') }}" placeholder="PK">
            @error('iata_code') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-2">
            <label>ICAO Code</label>
            <input type="text" name="icao_code" maxlength="4" class="form-control form-control-sm text-uppercase @error('icao_code') is-invalid @enderror"
                   value="{{ old('icao_code', $airline->icao_code ?? '') }}" placeholder="PIA">
            @error('icao_code') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-2">
            <label>Numeric Code</label>
            <input type="text" name="numeric_code" maxlength="3" class="form-control form-control-sm @error('numeric_code') is-invalid @enderror"
                   value="{{ old('numeric_code', $airline->numeric_code ?? '') }}" placeholder="214">
            @error('numeric_code') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Country</label>
            <select name="country" class="form-control form-control-sm select2 @error('country') is-invalid @enderror" style="width:100%;">
                <option value="">Select Country</option>
                {!! \App\Models\Country::dropdown(old('country', $airline->country ?? 0)) !!}
            </select>
            @error('country') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
        </div>
    </div>

    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Additional Information</h6>
    <div class="row">
        <div class="form-group col-md-8">
            <label>Remarks</label>
            <textarea name="remarks" rows="2" class="form-control form-control-sm" placeholder="Remarks">{{ old('remarks', $airline->remarks ?? '') }}</textarea>
        </div>
        <div class="form-group col-md-4">
            <label class="d-block">Status</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" class="custom-control-input" id="statusSwitch" name="status" value="1"
                       {{ (int) old('status', $airline->status ?? 1) === 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="statusSwitch">Active</label>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> {{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('airlines.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</div>
