{{-- Update Password --}}
<section class="mb-4">
    <header class="mb-3">
        <h5 class="font-weight-bold">Update Password</h5>
        <p class="text-muted small">Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">Current Password</label>
            <input type="password" id="update_password_current_password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">New Password</label>
            <input type="password" id="update_password_password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password', 'updatePassword')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Confirm Password</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-warning text-dark font-weight-bold">
                <i class="fas fa-key mr-1"></i> Save Password
            </button>
            @if (session('status') === 'password-updated')
                <span class="text-success ml-3 small"><i class="fas fa-check-circle mr-1"></i> Saved.</span>
            @endif
        </div>
    </form>
</section>

<hr class="my-4">