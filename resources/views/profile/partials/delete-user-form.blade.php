
{{-- Delete Account --}}
<section>
    <header class="mb-3">
        <h5 class="font-weight-bold text-danger">Delete Account</h5>
        <p class="text-muted small">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
    </header>

    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmUserDeletionModal">
        <i class="fas fa-trash-alt mr-1"></i> Delete Account
    </button>

    {{-- AdminLTE / Bootstrap 4 Compatible Deletion Modal --}}
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" role="dialog" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold text-danger" id="confirmUserDeletionModalLabel">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Are you sure you want to delete your account?
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted small">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                        </p>

                        <div class="form-group mt-3">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Enter your password to confirm" required>
                            @error('password', 'userDeletion')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>