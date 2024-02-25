<form action="{{ route('account.update.password')}}" id="passwordForm" method="post">
    @csrf
    <div class="mb-3">
        <label for="current-password" class="form-label">Current Password</label>
        <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current-password" placeholder="Enter your current password">
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="new-password" class="form-label">New Password</label>
        <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new-password" placeholder="Enter your new password">
        @error('new_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" id="confirm-password" placeholder="Confirm your new password">
        @error('confirm_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Save</button>
</form>