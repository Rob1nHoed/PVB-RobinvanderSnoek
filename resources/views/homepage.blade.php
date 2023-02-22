<x-app-layout>
    <div class="py-12">

        {{-- Zoekbalk --}}
        {{-- todo --}}
        
        {{-- 8 willekeurige featured dranken --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-20">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Titel --}}
                    <div class="p-5 pb-10">
                        <h1 class="text-center font-bold text-6xl">
                            Featured drinks
                        </h1>
                    </div>

                    {{-- Dranken --}}
                    <div class="grid grid-cols-4 gap-4">
                        @foreach ($featured as $drink)
                            <div class="rounded-lg p-4">
                                <a href="{{ route('show.drink', [$drink->id, 'metric']) }}">
                                    <div class="flex justify-center">
                                        <img class="rounded-lg shadow-xl" src="storage/{{ $drink->image }}" alt="{{ $drink->strDrink }}">
                                    </div>
                                    <div class="flex justify-center pt-2">
                                        <h1 class="text-center font-bold text-2xl">
                                            {{ $drink->name }}
                                        </h1>
                                    </div>
                                </a>
                            </div>  
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        {{-- 8 willekeurige dranken --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-20">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Titel --}}
                    <div class="p-5 pb-10">
                        <h1 class="text-center font-bold text-6xl">
                            Random drinks
                        </h1>
                    </div>

                    {{-- Dranken --}}
                    <div class="grid grid-cols-4 gap-4">
                        @foreach ($random as $drink)
                            <div class="rounded-lg p-4">
                                <a href="{{ route('show.drink', [$drink->id, 'metric']) }}">
                                    <div class="flex justify-center">
                                        <img class="rounded-lg shadow-xl" src="storage/{{ $drink->image }}" alt="{{ $drink->strDrink }}">
                                    </div>
                                    <div class="flex justify-center pt-2">
                                        <h1 class="text-center font-bold text-2xl">
                                            {{ $drink->name }}
                                        </h1>
                                    </div>
                                </a>
                            </div>  
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
