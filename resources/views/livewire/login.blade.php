
<div class="w-full flex justify-center max-w-2xl flex-col mx-auto mt-12">
    <form class="block bg-white m-4 p-8 rounded-lg shadow text-start" wire:submit="login">
        @csrf

        <div class="mb-4">
            <label class="input-label" for="email">
                Username or E-Mail
            </label>
            <input class="input" id="email" type="text" placeholder="youname@gmail.com" wire:model="form.email">

            @error('form.email') 
            <div class="alert alert-danger">
                Please provide your e-mail. We need it to identify you.
            </div>
            @enderror
        </div>
        <div class="mb-6">
            <label class="input-label" for="password">
                Password
            </label>
            <input class="input" id="password" type="password" placeholder="******************" wire:model="form.password">

            @error('form.password') 
            <div class="alert alert-danger">
                Please provide your password. We need to make sure it is really you.
            </div>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button class="button button-primary" type="submit">
                    Login
                </button>
                
                <a href="/">
                    <button class="button" type="button">                    
                        Cancel
                    </button>                    
                </a>
            </div>

            <a class="inline-block align-baseline font-bold text-sm" href="register">
                Don't have an account yet?
            </a>
        </div>
        
        @error("login")
        <div class="alert alert-danger">
            Something is wrong with your credentials. Please make sure to enter your correct username and password.
        </div>
        @enderror     
    </for>
</div>