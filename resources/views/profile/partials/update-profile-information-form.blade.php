{{-- Profile Information --}}
<section class="mb-4">
    <header class="mb-3">
        <h5 class="font-weight-bold">Profile Information</h5>
        <p class="text-muted small">Update your account's profile information and email address.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-warning small mb-1">Your email address is unverified.</p>
                    <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-none">
                        Click here to re-send the verification email.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success small">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Save
            </button>
            @if (session('status') === 'profile-updated')
                <span class="text-success ml-3 small"><i class="fas fa-check-circle mr-1"></i> Saved.</span>
            @endif
        </div>
    </form>
</section>

<hr class="my-4">


