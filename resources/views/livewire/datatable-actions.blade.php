<div class="flex gap-2">
    <a href="#" class="px-2 py-1 text-sm bg-blue-500 text-white rounded">
        Edit
    </a>
    <button wire:click="delete({{ $row->id }})" class="px-2 py-1 text-sm bg-red-500 text-white rounded">
        Hapus
    </button>
</div>
