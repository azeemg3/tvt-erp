{{-- Shared Client form. Expects: $client (nullable), $users, $categories, $nextCode (create only) --}}
@php
    $client = $client ?? null;
    $accountCode = $client && $client->account ? $client->account->code : ($nextCode ?? '');
@endphp
<!--!-->
<div class="card-body">
    {{-- Basic Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3">Basic Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Client A/C</label>
            <input type="text" class="form-control form-control-sm" value="{{ $accountCode }}" readonly>
            <small class="text-muted">Auto generated account code</small>
        </div>
        <div class="form-group col-md-4">
            <label>Client Name <span class="text-danger">*</span></label>
            <input type="text" name="client_name" class="form-control form-control-sm @error('client_name') is-invalid @enderror"
                   value="{{ old('client_name', $client->client_name ?? '') }}" placeholder="Client Name">
            @error('client_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Client Email</label>
            <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                   value="{{ old('email', $client->email ?? '') }}" placeholder="Client Email">
            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Client Mobile <span class="text-danger">*</span></label>
            <input type="text" name="mobile" class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                   value="{{ old('mobile', $client->mobile ?? '') }}" placeholder="Client Mobile">
            @error('mobile') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>C/O SPO</label>
            <select name="assigned_user_id" class="form-control form-control-sm select2" style="width:100%;">
                <option value="">Select C/O SPO</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ (string) old('assigned_user_id', $client->assigned_user_id ?? '') === (string) $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Assignments --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Assignments</h6>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Recovery Officer</label>
            <select name="recovery_officer_id" class="form-control form-control-sm select2" style="width:100%;">
                <option value="">Select Recovery Officer</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ (string) old('recovery_officer_id', $client->recovery_officer_id ?? '') === (string) $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Financial Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Financial Information</h6>
    <div class="row">
        <div class="form-group col-md-4">
            <label>Category <span class="text-danger">*</span></label>
            <select name="category" class="form-control form-control-sm select2 @error('category') is-invalid @enderror" style="width:100%;">
                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ old('category', $client->category ?? 'Walk-In Customer') === $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
            @error('category') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Credit Limit</label>
            <input type="number" step="0.01" name="credit_limit" class="form-control form-control-sm @error('credit_limit') is-invalid @enderror"
                   value="{{ old('credit_limit', $client->credit_limit ?? '0.00') }}" placeholder="0.00">
            @error('credit_limit') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-4">
            <label>Credit Days</label>
            <input type="number" name="credit_days" class="form-control form-control-sm @error('credit_days') is-invalid @enderror"
                   value="{{ old('credit_days', $client->credit_days ?? '0') }}" placeholder="0">
            @error('credit_days') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Additional Information --}}
    <h6 class="font-weight-bold text-primary border-bottom pb-2 mb-3 mt-2">Additional Information</h6>
    <div class="row">
        <div class="form-group col-md-6">
            <label>Address</label>
            <textarea name="address" rows="2" class="form-control form-control-sm" placeholder="Address">{{ old('address', $client->address ?? '') }}</textarea>
        </div>
        <div class="form-group col-md-6">
            <label>Remarks</label>
            <textarea name="remarks" rows="2" class="form-control form-control-sm" placeholder="Remarks">{{ old('remarks', $client->remarks ?? '') }}</textarea>
        </div>
        <div class="form-group col-md-4">
            <label class="d-block">Status</label>
            <div class="custom-control custom-switch">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" class="custom-control-input" id="statusSwitch" name="status" value="1"
                       {{ (int) old('status', $client->status ?? 1) === 1 ? 'checked' : '' }}>
                <label class="custom-control-label" for="statusSwitch">Active</label>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> {{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</div>
