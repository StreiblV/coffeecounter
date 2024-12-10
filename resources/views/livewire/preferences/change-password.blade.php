<div class="card">
    <h4>Change password</h4>
    <form wire:submit="save">
        @csrf

        <div class="mt-4">
            <label class="input-label" for="password">
                Password
            </label>
            <input type="password" class="input" name="password" wire:model="password" placeholder="new password">

        </div>
        @error('password')
            <div class="alert alert-danger">
                Please provide a password. We can't protect your account otherwise!
            </div>
        @enderror

        <div class="mt-4">
            <label class="input-label" for="confirmPassword">
                Confirm password
            </label>
            <input type="password" class="input" name="confirmPassword" wire:model="passwordConfirmation"
                placeholder="new password, but confirmed">
        </div>
        @error('passwordConfirmation')
            <div class="alert alert-danger">
                Please confirm your password. Nobody is safe from typos!
            </div>
        @enderror

        <button type="submit" class="button mt-4">Save</button>
    </form>
</div>