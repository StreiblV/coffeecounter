<x-layout.drawer>
    <div class="w-full">
        <div class="card">
            <div class="text-center">
                <h4>Welcome home, {{ $user->name }}!</h4>
                <h6 class="mt-4">Let's see what we can do for you</h6>

                <div class="mt-4 flex-row">
                    <a class="button" href="privacy">Privacy Policy</a>
                    <a class="button button-primary" href="logout">Logout</a>
                </div>
            </div>
        </div>

        <livewire:preferences.change-username :user="$user" />
        <livewire:preferences.change-email :user="$user" />
        <livewire:preferences.change-password :user="$user" />

    </div>
</x-layout.drawer>
