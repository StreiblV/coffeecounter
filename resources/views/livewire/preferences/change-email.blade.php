<div class="card">
    <h4>Change e-mail</h4>
    <form wire:submit="save">
        @csrf

        <div class="mt-4">
            <label class="input-label" for="email">
                E-Mail
            </label>
            <input type="text" class="input" name="email" wire:model="email" placeholder="email@gmail.com">
        </div>

        @error('email')
            <div class="alert alert-danger">
                Make sure to provide an email. We need to make sure you can login.
            </div>
        @enderror
        <button type="submit" class="button mt-4">Save</button>
    </form>
</div>