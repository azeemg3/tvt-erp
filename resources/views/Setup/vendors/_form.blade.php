{{-- Shared Vendor form. Expects: $vendor (nullable), $types, $nextCode (create only) --}}
@php
    $vendor = $vendor ?? null;
    $accountCode = $vendor && $vendor->account ? $vendor->account->code : ($nextCode ?? '');
@endphp

<div class="card-body">
    {{-- Basic Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Basic Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Vendor A/C</label>
            <input type="text" class="form-control form-control-sm" value="{{ $accountCode }}" readonly>
            <small class="text-muted">Auto generated account code</small>
        </div>
        <div class="form-group col-md-4">
            <label>Vendor Name <span class="text-danger">*</span></label>
            <input type="text" name="vendor_name" class="form-control form-control-sm @error('vendor_name') is-invalid @enderror"
                   value="{{ old('vendor_name', $vendor->vendor_name ?? '') }}" placeholder="Vendor Name">
            @error('vendor_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Vendor Type <span class="text-danger">*</span></label>
            <select name="vendor_type" class="form-control form-control-sm select2 @error('vendor_type') is-invalid @enderror" style="width:100%;">
                <option value="">Select Type</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ old('vendor_type', $vendor->vendor_type ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            @error('vendor_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control form-control-sm"
                   value="{{ old('contact_person', $vendor->contact_person ?? '') }}" placeholder="Contact Person">
        </div>
        <div class="form-group col-md-4">
            <label>Mobile <span class="text-danger">*</span></label>
            <input type="text" name="mobile" class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                   value="{{ old('mobile', $vendor->mobile ?? '') }}" placeholder="Mobile">
            @error('mobile') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control form-control-sm"
                   value="{{ old('phone', $vendor->phone ?? '') }}" placeholder="Phone">
        </div>
        <div class="form-group col-md-4">
            <label>Email</label>
            <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                   value="{{ old('email', $vendor->email ?? '') }}" placeholder="Email">
            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Airline Related Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Airline Related Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Airline Code</label>
            <input type="text" name="airline_code" class="form-control form-control-sm"
                   value="{{ old('airline_code', $vendor->airline_code ?? '') }}" placeholder="Airline Code">
        </div>
        <div class="form-group col-md-4">
            <label>IATA Code</label>
            <input type="text" name="iata_code" class="form-control form-control-sm"
                   value="{{ old('iata_code', $vendor->iata_code ?? '') }}" placeholder="IATA Code">
        </div>
    </div>

    {{-- Financial Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Financial Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Credit Limit</label>
            <input type="number" step="0.01" name="credit_limit" class="form-control form-control-sm @error('credit_limit') is-invalid @enderror"
                   value="{{ old('credit_limit', $vendor->credit_limit ?? '0.00') }}" placeholder="0.00">
            @error('credit_limit') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Credit Days</label>
            <input type="number" name="credit_days" class="form-control form-control-sm @error('credit_days') is-invalid @enderror"
                   value="{{ old('credit_days', $vendor->credit_days ?? '0') }}" placeholder="0">
            @error('credit_days') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Opening Balance</label>
            <input type="number" step="0.01" name="opening_balance" class="form-control form-control-sm @error('opening_balance') is-invalid @enderror"
                   value="{{ old('opening_balance', $vendor->opening_balance ?? '0.00') }}" placeholder="0.00"
                   {{ $vendor ? 'readonly' : '' }}>
            @if ($vendor)<small class="text-muted">Opening balance is locked after creation.</small>@endif
            @error('opening_balance') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Location Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Location Information</h6>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Address</label>
            <textarea name="address" rows="2" class="form-control form-control-sm" placeholder="Address">{{ old('address', $vendor->address ?? '') }}</textarea>
        </div>
        <div class="form-group col-md-3">
            <label>City</label>
            <input type="text" name="city" class="form-control form-control-sm"
                   value="{{ old('city', $vendor->city ?? '') }}" placeholder="City">
        </div>
        <div class="form-group col-md-3">
            <label>Country</label>
            <input type="text" name="country" class="form-control form-control-sm"
                   value="{{ old('country', $vendor->country ?? '') }}" placeholder="Country">
        </div>
    </div>

    {{-- Tax Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Tax Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>GST / VAT Number</label>
            <input type="text" name="gst_vat_no" class="form-control form-control-sm"
                   value="{{ old('gst_vat_no', $vendor->gst_vat_no ?? '') }}" placeholder="GST / VAT Number">
        </div>
    </div>

    {{-- Additional Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Additional Information</h6>
    <div class="row">
        <div class="form-group col-md-8">
            <label>Remarks</label>
            <textarea name="remarks" rows="2" class="form-control form-control-sm" placeholder="Remarks">{{ old('remarks', $vendor->remarks ?? '') }}</textarea>
        </div>
        <div class="form-group col-md-4">
            <label class="d-block">Status</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" class="custom-control-input" id="statusSwitch" name="status" value="1"
                       {{ (int) old('status', $vendor->status ?? 1) === 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="statusSwitch">Active</label>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> {{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('vendors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</div>
