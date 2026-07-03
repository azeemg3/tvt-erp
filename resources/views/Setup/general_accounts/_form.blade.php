{{-- Shared General Account form. Expects: $generalAccount (nullable) --}}
@php
    $generalAccount = $generalAccount ?? null;
@endphp

<div class="card-body">
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Account Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                   value="{{ old('name', $generalAccount->name ?? '') }}" placeholder="Name">
            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>NIC</label>
            <input type="text" name="nic" class="form-control form-control-sm @error('nic') is-invalid @enderror"
                   value="{{ old('nic', $generalAccount->nic ?? '') }}" placeholder="12345-1234567-1">
            <small class="text-muted">13 digits or 12345-1234567-1 format</small>
            @error('nic') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Phone <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control form-control-sm @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $generalAccount->phone ?? '') }}" placeholder="Phone">
            @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>City</label>
            <input type="text" name="city" class="form-control form-control-sm @error('city') is-invalid @enderror"
                   value="{{ old('city', $generalAccount->city ?? '') }}" placeholder="City">
            @error('city') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-8">
            <label>Address</label>
            <textarea name="address" rows="2" class="form-control form-control-sm @error('address') is-invalid @enderror"
                      placeholder="Address">{{ old('address', $generalAccount->address ?? '') }}</textarea>
            @error('address') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>

    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Role Assignment</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label class="d-block">As SPO</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_spo" value="0">
                <input type="checkbox" class="custom-control-input" id="isSpoSwitch" name="is_spo" value="1"
                       {{ (int) old('is_spo', $generalAccount->is_spo ?? 0) === 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="isSpoSwitch">Sales Promotion Officer</label>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label class="d-block">As RO</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_ro" value="0">
                <input type="checkbox" class="custom-control-input" id="isRoSwitch" name="is_ro" value="1"
                       {{ (int) old('is_ro', $generalAccount->is_ro ?? 0) === 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="isRoSwitch">Recovery Officer</label>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label class="d-block">As Marketing Officer</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="is_marketing_officer" value="0">
                <input type="checkbox" class="custom-control-input" id="isMarketingOfficerSwitch" name="is_marketing_officer" value="1"
                       {{ (int) old('is_marketing_officer', $generalAccount->is_marketing_officer ?? 0) === 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="isMarketingOfficerSwitch">Marketing Officer</label>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> {{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('general-accounts.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</div>
