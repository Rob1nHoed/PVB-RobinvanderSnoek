<div>
    {{-- Zoek knop --}}
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class=" overflow-hidden sm:rounded-lg">
            <div class="flex justify-center">
                <button wire:click="search" class="bg-blue-500 hover:bg-blue-700 text-white text-4xl font-bold py-5 px-4 rounded w-96">
                    Search
                </button>
            </div>
        </div>
    </div>

    {{-- Zoekbalk --}}
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class=" overflow-hidden sm:rounded-lg">
            <div class="pt-10">
                <input wire:model="search" type="text" class="shadow appearance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search for an ingredient">
            </div>
        </div>
    </div>

    {{-- Vorige/volgende pagina buttons --}}
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class=" overflow-hidden sm:rounded-lg flex justify-center">
            <div class="flex justify-center pt-10 px-2">
                <button wire:click="previousPage" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-bold py-1 px-4 rounded w-48">
                    Previous page
                </button>
            </div>
            <div class="flex justify-center pt-10 px-2">
                <button wire:click="nextPage" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-bold py-1 px-4 rounded w-48">
                    Next page
                </button>
            </div>
        </div>
    </div>
    
    {{-- Alle ingredienten tonen --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-2">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                {{-- Titel --}}
                <div class="p-5 pb-10">
                    <h1 class="text-center font-bold text-6xl">
                        Selecteer ingredriënten
                    </h1>
                </div>
                {{-- Alle ingredienten --}}
                <div class="grid grid-cols-4 gap-1">
                    @foreach ($searchResults as $ingredient)
                        <div class="rounded-lg p-4">
                            <div class="flex justify-center">
                                <img class="rounded-lg shadow-xl" src="storage/{{ $ingredient->image }}" alt="{{ $ingredient->strDrink }}" width="250px">
                            </div>
                            <div class="flex pt-3">
                                <div class="pl-4">
                                    {{-- Als de input al was aangevinkt, vinkt het weer aan --}}
                                    <input type="checkbox" wire:click="addIngredient({{ $ingredient->id }})" @if(in_array($ingredient->id, $selected)) checked @endif>
                                </div>
                                <h1 class="text-center font-bold text-xl pl-5">
                                    {{ $ingredient->name }}
                                </h1>
                            </div>
                        </div>  
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    {{-- Volgende/vorige pagina --}}
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class=" overflow-hidden sm:rounded-lg flex justify-center">
            <div class="flex justify-center pt-10 px-2">
                <button wire:click="previousPage" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-bold py-1 px-4 rounded w-48">
                    Previous page
                </button>
            </div>
            <div class="flex justify-center pt-10 px-2">
                <button wire:click="nextPage" class="bg-blue-500 hover:bg-blue-700 text-white text-2xl font-bold py-1 px-4 rounded w-48">
                    Next page
                </button>
            </div>
        </div>
    </div>
</div>
