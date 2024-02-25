<!-- Profile.blade.php -->
<form action="{{ route('seller.account.update.basic')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label for="name" class="form-label">Owner Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter your name" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        

        {{-- <div class="col-md-6">
            <div class="mb-3">
                <label for="owner_name" class="form-label">Owner Name</label>
                <input type="text" class="form-control @error('owner_name') is-invalid @enderror" id="owner_name" name="owner_name" placeholder="Enter owner name" value="{{ old('owner_name', $user->sellerInfo->owner_name ?? '') }}">
                @error('owner_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div> --}}

        <div class="col-md-6">
            <div class="mb-3">
                <label for="owner_contact" class="form-label">Owner Contact</label>
                <input type="text" class="form-control @error('owner_contact') is-invalid @enderror" id="owner_contact" name="owner_contact" placeholder="Enter owner contact" value="{{ old('owner_contact', $user->sellerInfo->owner_contact ?? '') }}">
                @error('owner_contact')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Brand -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label for="brand" class="form-label">Brand Name</label>
                <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" placeholder="Enter brand" value="{{ old('brand', optional($user->sellerInfo)->brand) }}">
                @error('brand')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="organization_name" class="form-label">Organization Name</label>
                <input type="text" class="form-control @error('organization_name') is-invalid @enderror" id="organization_name" name="organization_name" placeholder="Enter organization name" value="{{ old('organization_name', $user->sellerInfo->organization_name ?? '') }}">
                @error('organization_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- Email -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label for="email" class="form-label">Organization Email</label>
                <input type="email" class="form-control" id="email" disabled value="{{ $user->email }}" placeholder="Enter your email">
            </div>
        </div>
        <!-- WhatsApp -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label for="whatsapp" class="form-label">WhatsApp</label>
                <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp" placeholder="Enter WhatsApp number" value="{{ old('whatsapp', optional($user->sellerInfo)->whatsapp) }}">
                @error('whatsapp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <h4 class="mt-3 mb-3">Pickup Address</h4>
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Enter address" value="{{ old('address', optional($user->sellerInfo)->address) }}">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label for="locality" class="form-label">Locality</label>
                <input type="text" class="form-control @error('locality') is-invalid @enderror" id="locality" name="locality" placeholder="Enter locality" value="{{ old('locality', optional($user->sellerInfo)->locality) }}">
                @error('locality')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="Enter city" value="{{ old('city', optional($user->sellerInfo)->city) }}">
                @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="Enter state" value="{{ old('state', optional($user->sellerInfo)->state) }}">
                @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="mb-3">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" placeholder="Enter pincode" value="{{ old('pincode', optional($user->sellerInfo)->pincode) }}">
                @error('pincode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>

@push('scripts')
    <script type="module">
        $('#profileForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255 // Example rule for maximum length
                },
                brand: {
                    required: true,
                    maxlength: 255 // Example rule for maximum length
                },
                whatsapp: {
                    required: true,
                    maxlength: 255 // Example rule for maximum length
                },
                address: {
                    required: true,
                    maxlength: 255 // Example rule for maximum length
                },
                locality: {
                    required: true,
                    maxlength: 255 // Example rule for maximum length
                },
                city: {
                    required: true,
                    maxlength: 255 // Example rule for maximum length
                },
                state: {
                    required: true,
                    maxlength: 255 // Example rule for maximum length
                },
                pincode: {
                    required: true,
                    maxlength: 10, // Example rule for maximum length
                    digits: true // Ensure only digits are entered
                },
                // Add validation rules for other fields
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    maxlength: "Maximum length exceeded" // Example message for maximum length
                },
                brand: {
                    required: "Please enter your brand",
                    maxlength: "Maximum length exceeded" // Example message for maximum length
                },
                whatsapp: {
                    required: "Please enter your WhatsApp number",
                    maxlength: "Maximum length exceeded" // Example message for maximum length
                },
                address: {
                    required: "Please enter your address",
                    maxlength: "Maximum length exceeded" // Example message for maximum length
                },
                locality: {
                    required: "Please enter your locality",
                    maxlength: "Maximum length exceeded" // Example message for maximum length
                },
                city: {
                    required: "Please enter your city",
                    maxlength: "Maximum length exceeded" // Example message for maximum length
                },
                state: {
                    required: "Please enter your state",
                    maxlength: "Maximum length exceeded" // Example message for maximum length
                },
                pincode: {
                    required: "Please enter your pincode",
                    maxlength: "Maximum length exceeded", // Example message for maximum length
                    digits: "Please enter only digits" // Example message for digits validation
                },
                // Add messages for other fields
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    </script>
@endpush