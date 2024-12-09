
<div class="w-full flex justify-center max-w-2xl flex-col mx-auto mt-12">
    <form class="block bg-white m-4 p-8 rounded-lg shadow text-start" wire:submit="save">
        @csrf

        <div class="mb-4">
            <label class="input-label" for="username">
                Username *
            </label>
            <input class="input" id="username" type="text" placeholder="Username" wire:model="form.name">

            @error('form.name') 
            <div class="alert alert-danger">
                Make sure to provide a username, so we know how to call you.
            </div>
            @enderror
        </div>
        <div class="mb-6">
            <label class="input-label" for="email">
                E-Mail *
            </label>
            <input class="input" id="email" type="email" placeholder="my@email.com" wire:model="form.email">

            @error('form.email') 
            <div class="alert alert-danger">
                Make sure to provide an email. We need to make sure you can login.
            </div>
            @enderror
        </div>
        <div class="mb-6">
            <label class="input-label" for="password">
                Password *
            </label>
            <input class="input" id="password" type="password" placeholder="******************" wire:model="form.password">

            @error('form.password') 
            <div class="alert alert-danger">
                Please provide a password. We can't protect your account otherwise!
            </div>
            @enderror
        </div>
        <div class="mb-6">
            <label class="input-label" for="confirm-password">
                Confirm password *
            </label>
            <input class="input" id="confirm-password" type="password" placeholder="******************" wire:model="form.passwordConfirmation">

            @error('form.passwordConfirmation') 
            <div class="alert alert-danger">
                Please confirm your password. Nobody is safe from typos!
            </div>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button class="button button-primary" type="submit">
                    Register
                </button>
                
                <a href="/">
                    <button class="button" type="button">                    
                        Cancel
                    </button>                    
                </a>
            </div>

            <a class="inline-block align-baseline font-bold text-sm" href="login">
                Already have an account?
            </a>
        </div>
    </form>
</div>