<tbody>
    @foreach ($entries as $entry)
        <tr class="hidden md:table-row">
            <td class="text-start">
                {{ $entry->type }}
            </td>
            <td class="text-start">
                {{ date_format($entry->created_at, "H:i") }}
            </td>
            <td class="text-end">
                <a class="button" wire:click="remove({{ $entry->id }})">
                    <i class="bi bi-trash"></i> Remove
                </a>
            </td>
        </tr>
    @endforeach
    @foreach ($entries as $entry)
        <tr class="table-row md:hidden">
            <td class="text-start">
                {{ $entry->type }} @
                {{ date_format($entry->created_at, "H:i") }}
            </td>
            <td class="text-end">
                <a class="button" wire:click="remove({{ $entry->id }})">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach
</tbody>