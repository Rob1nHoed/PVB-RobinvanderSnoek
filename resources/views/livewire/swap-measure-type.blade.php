<div>
    {{-- Knop om tussen ml en cl te switchen --}}
    <div class="fixed bottom-0 right-0">
        <div class="container mx-auto px-4 py-4 flex">
            <div class="w-100">
                <div class="flex items">
                    <button wire:click="swapMeasureType" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Switch to {{ $measureType == 'metric' ? 'imperial' : 'metric' }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-4 pt-10">
    @foreach ($ingredients as $key=>$ingredient)
        <div class="rounded-lg p-4">
            {{-- Afbeelding --}}
            <div class="justify-center">
                <a href="{{ route('show.ingredient', $ingredient->id) }}">
                    <img class="rounded-lg shadow-xl" src="/storage/{{ $ingredient->image }}" alt="{{ $ingredient->name }}">
                </a>
            </div>
            {{-- Naam met hoeveelheid --}}
            <div class="flex justify-center pt-2">
                <h1 class="text-center font-bold text-2xl">
                    {{ $measures[$key] }} {{ $ingredient->name }}
                </h1>
            </div>
        </div>  
    @endforeach
    </div>
    
</div>