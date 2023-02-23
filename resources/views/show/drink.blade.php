<x-app-layout>

    {{-- Informatie over de cocktail --}}
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 bg-white border-b border-gray-200">
                    <div class="sm:flex">
                        <div class="flex items-center justify-center">
                            {{-- Afbeelding --}}
                            <img class="rounded-lg shadow-xl" src="/storage/{{ $drink->image }}" alt="{{ $drink->name }}" width="400" height="400">
                        </div>
                        <div class="pl-4 text-center sm:text-left">
                            {{-- Naam --}}
                            <h1 class="text-4xl font-bold pt-2">
                                {{ $drink->name }}
                            </h1>
                            
                            {{-- Categorien --}}
                            <div class="pt-8">
                                <h1 class="text-2xl font-bold">
                                    Categories:
                                </h1>
                                <div class="flex pt-2 items-center justify-center sm:items-start sm:justify-start">
                                    <div class="p-3 px-4 rounded-lg bg-slate-300 max-w-fit max-h-fit">
                                        {{ $category }}
                                    </div>
                                    <div class="px-2"></div>
                                    @if($alcohol)
                                        <div class="p-3 px-4 rounded-lg bg-slate-300 max-w-fit max-h-fit">
                                            Alcoholic
                                        </div>
                                    @else
                                        <div class="p-3 px-4 rounded-lg bg-slate-300 max-w-fit max-h-fit">
                                            Non-Alcoholic
                                        </div>
                                    @endif
                                </div>

                            </div>
                            
                            {{-- Instructies --}}
                            <div class="pt-6">
                                <h1 class="text-2xl font-bold">
                                    Instructions
                                </h1>
                                <p class="pt-5">
                                    {{ $drink->instructions }}
                                </p>
                            </div>
                        </div>
                        <div class="py-2 sm:py-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ingredienten --}}
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 bg-white border-b border-gray-200">
                    <h1 class="text-5xl text-center font-bold">
                        Ingredients
                    </h1>             
                    @livewire('swap-measure-type', ['measure' => $measure, 'ingredients' => $ingredients])
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
