<div class="card">
    <h4>Change username</h4>
    <form wire:submit="save">
        @csrf

        <div class="mt-4">
            <label class="input-label" for="username">
                Username
            </label>
            <input type="text" class="input" name="username" wire:model="name" placeholder="Username">
        </div>

        @error('name') 
        <div class="alert alert-danger">
            Make sure to provide a username, so we know how to call you.
        </div>
        @enderror

        <button type="submit" class="button mt-4">Save</button>
    </form>
</div>