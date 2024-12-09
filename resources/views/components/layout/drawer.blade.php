<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include("/components/layout/head")
</head>

<body class="h-screen font-sans antialiased dark:bg-black dark:text-white/50 h-screen">

    <div class="drawer-layout">
        <div class="drawer" id="drawer">
            <a class="drawer-button" href="#" onclick="toggleDrawer()">
                <i class="bi bi-list"></i>
            </a>

            <a class="drawer-item {{ request()->route()->uri == 'dashboard' ? 'drawer-item-active' : '' }}"
                href="dashboard">
                <i class="bi bi-cup-hot"></i> Track
            </a>
            <a class="drawer-item {{ request()->route()->uri == 'analytics' ? 'drawer-item-active' : '' }}" 
                href="analytics">
                <i class="bi bi-graph-up"></i> Analytics
            </a>

            <a class="drawer-item" href="#">
                <i class="bi bi-award"></i> Leaderboard
            </a>

            <a class="drawer-item" href="#">
                <i class="bi bi-chat-right-heart"></i> Social
            </a>

            <a class="drawer-item" href="#">
                <i class="bi bi-gear"></i> Settings
            </a>

        </div>
        <div class="m-2 md:mt-2 md:ms-4 w-full">
            {{ $slot }}
        </div>
    </div>

    <script lang="javascript">
        const toggleDrawer = () => {
            const drawer = document.getElementById("drawer");

            drawer.classList.toggle("drawer-active");
        }
    </script>



    @livewireScripts
</body>

</html>