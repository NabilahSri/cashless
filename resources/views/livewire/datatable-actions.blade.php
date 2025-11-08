<div class="flex gap-2">

    @isset($viewUrl)
        <a href="{{ $viewUrl }}" title="Lihat"
            class="flex items-center justify-center w-8 h-8 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
            <i class="fa-regular fa-eye"></i>
        </a>
    @endisset

    @if ($editEvent ?? false)
        <button wire:click="$dispatch('{{ $editEvent }}', { id: '{{ $row->id }}' } )"
            class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fa-solid fa-pen"></i>
        </button>
    @elseif ($editUrl ?? false)
        <a href="{{ $editUrl }}"
            class="flex items-center justify-center w-8 h-8 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fa-solid fa-pen"></i>
        </a>
    @endif

    @isset($delete)
        <button wire:click="confirmDelete('{{ $row->id }}')" title="Hapus"
            class="flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-md
                       hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
            <i class="fa-regular fa-trash-can"></i>
        </button>
    @endisset
</div>
