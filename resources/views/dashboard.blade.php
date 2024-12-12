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

    <div class="w-full lg:w-1/2">
        <div class="card">
            <h4 class="mb-8 text-center">Todays entries</h4>
            <table class="w-full table-fixed">
                <thead>
                    <tr class="hidden md:table-row">
                        <th>
                            Entry
                        </th>
                        <th>
                            Time
                        </th>
                        <th class="text-end hidden md:table-cell">
                        </th>
                    </tr>
                    <tr class="table-row md:hidden">
                        <th>
                            Entry
                        </th>
                        <th class="text-end hidden md:table-cell">
                        </th>
                    </tr>
                </thead>
                <livewire:dashboard.entry-table :entries="$entries"/>
            </table>
        </div>
    </div>
    <div class="w-full lg:w-1/2">
        <div class="card">
            <div class="text-center">
                <h4 class="mb-8">✨ AI Overview ✨</h4>
                <div id="ai-summary">
                    <button class="button button-primary" onclick="fetchSummary()">Generate Summary</button>
                    <div class="ai-box hidden" id="ai-summary-container">
                        <div id="ai-summary-output" class="text-justify"></>
                    </div>                 
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
                const outputContainer = document.getElementById('ai-summary-container');
                const output = document.getElementById('ai-summary-output');

                if (data.summary) {
                    outputContainer.classList.remove("hidden");
                    button.classList.add("hidden");
                    output.innerText = data.summary;
                } else {
                    output.innerText = 'Error: ' + (data.error || 'Unexpected error.');
                }
            } catch (error) {
                // Handle any network or unexpected errors
                document.getElementById('ai-summary-output').innerText = `Error: ${error.message}`;
            } finally {
                // Restore the button state
                button.innerText = "Generate Summary";
                button.disabled = false;
            }
        }
    </script>
</div>

</x-layout.drawer>
