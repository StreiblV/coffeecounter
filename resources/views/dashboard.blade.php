<x-layout.drawer>
<div class="flex flex-row flex-wrap w-full">
    <div class="card w-full">
        <div class="text-center">
            <h4 class="mb-8">Todays consumption</h4>
            <h4 class="text-green font-bold">
                {{ $energyLevels }}
            </h4>
            Energy Levels
        </div>
    </div>

    <div class="card w-full">
        <h4 class="mb-8 text-center">Consume</h4>
        <livewire:dashboard.consume></livewire:dashboard.consume>
    </div>

    <div class="card w-full">
        <h4 class="mb-8 text-center">Todays entries</h4>
        <table class="w-full table-fixed">
            <thead>
                <tr class="hidden md:table-row">
                    <th class="text-start">
                        Entry
                    </th>
                    <th class="text-start">
                        Time
                    </th>
                    <th class="text-end hidden md:table-cell">
                    </th>
                </tr>
                <tr class="table-row md:hidden">
                    <th class="text-start">
                        Entry
                    </th>
                    <th class="text-end hidden md:table-cell">
                    </th>
                </tr>
            </thead>
            <livewire:dashboard.entry-table :entries="$entries"/>
        </table>
    </div>

    <div class="card w-full <?php if (!isset($aiApiKey)) { echo "hidden"; } ?>">
        <div class="text-center">
            <h4 class="mb-8">✨ AI Overview ✨</h4>
            <div id="ai-summary">
                <button class="button button-primary" onclick="fetchSummary()">Generate Summary</button>
                <div class="ai-box">
                    <p id="summary-output"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function fetchSummary() {
            // Update the button state to show progress
            const button = document.querySelector("#ai-summary button");
            button.innerText = "Generating...";
            button.disabled = true;

            try {
                // Fetch the AI summary
                const response = await fetch('/ai-summary');
                const data = await response.json();

                if (data.summary) {
                    document.getElementById('summary-output').innerText = data.summary;
                } else {
                    document.getElementById('summary-output').innerText = 'Error: ' + (data.error || 'Unexpected error.');
                }
            } catch (error) {
                // Handle any network or unexpected errors
                document.getElementById('summary-output').innerText = `Error: ${error.message}`;
            } finally {
                // Restore the button state
                button.innerText = "Generate Summary";
                button.disabled = false;
            }
        }
    </script>
</div>

</x-layout.drawer>
