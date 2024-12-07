
<div class="w-full flex justify-center max-w-2xl flex-col mx-auto mt-12">
    <form class="block bg-white m-4 p-8 rounded-lg shadow text-start">
        <div class="mb-4">
            <label class="input-label" for="username">
                Username
            </label>
            <input class="input" id="username" type="text" placeholder="Username">
        </div>
        <div class="mb-6">
            <label class="input-label" for="email">
                E-Mail
            </label>
            <input class="input" id="email" type="email" placeholder="my@email.com">            
        </div>
        <div class="mb-6">
            <label class="input-label" for="password">
                Password
            </label>
            <input class="input" id="password" type="password" placeholder="******************">            
        </div>
        <div class="mb-6">
            <label class="input-label" for="confirm-password">
                Confirm password
            </label>
            <input class="input" id="confirm-password" type="password" placeholder="******************">            
        </div>

        <div class="flex items-center justify-between">
            <div>
                <button class="button button-primary" type="button">
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

        <div class="shadow p-2 px-4 mt-4 rounded bg-red-500/20 text-red-500 {{ $is_forgotten ? '' : 'hidden' }}">
            Tough luck
        </div>
    </form>
</div>