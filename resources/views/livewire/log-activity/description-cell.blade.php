@php
    $event = $row->event;
    $description = $row->description;
    $propsArray = json_decode($row->properties, true);
    if (!is_array($propsArray)) {
        $propsArray = [];
    }
    $oldValues = $propsArray['old'] ?? null;
    $newValues = $propsArray['attributes'] ?? null;
@endphp

<div>
    <span>{{ $description }}</span>

    @if (!in_array($event, ['login', 'logout']))

        <div x-data="{ showModal: false }" class="inline-block ml-2">

            <button @click="showModal = true" type="button" class="text-blue-600 hover:underline text-sm font-medium">
                (View Changes)
            </button>

            <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4"
                style="display: none;">

                <div @click="showModal = false" class="fixed inset-0 bg-black/50"></div>

                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[85vh] z-10 flex flex-col">

                    <div class="flex justify-between items-center border-b p-4">
                        <h3 class="text-lg font-semibold">Changes Detail (Log ID: {{ $row->id }})</h3>
                        <button @click="showModal = false"
                            class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 overflow-y-auto" style="max-height: 70vh;">

                        <div>
                            <h4 class="font-bold text-lg mb-2 text-gray-700">Old Values</h4>
                            @if ($oldValues)
                                <pre class="bg-gray-100 p-3 rounded text-sm overflow-x-auto">{{ json_encode($oldValues, JSON_PRETTY_PRINT) }}</pre>
                            @else
                                <span class="text-gray-500 text-sm italic">No old values recorded.</span>
                            @endif
                        </div>

                        <div>
                            <h4 class="font-bold text-lg mb-2 text-green-700">New Values</h4>
                            @if ($newValues)
                                <pre class="bg-gray-100 p-3 rounded text-sm overflow-x-auto">{{ json_encode($newValues, JSON_PRETTY_PRINT) }}</pre>
                            @else
                                <span class="text-gray-500 text-sm italic">No new values recorded.</span>
                            @endif
                        </div>
                    </div>

                    <div class="border-t p-4 bg-gray-50 text-right rounded-b-lg">
                        <button @click="showModal = false" type="button"
                            class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
