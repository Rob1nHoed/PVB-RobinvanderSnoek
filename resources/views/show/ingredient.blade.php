<x-app-layout>
    {{-- Informatie over ingredient --}}
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 bg-white border-b border-gray-200">
                    <div class="sm:flex">
                            
                        <div class="flex items-center justify-center sm:justify-start">
                            <img class="rounded-lg shadow-xl" src="/storage/{{ $ingredient->image }}" alt="{{ $ingredient->name }}" width="300" height="300">
                        </div>
                        <div class="px-6 pt-6">
                            <h1 class="text-4xl font-bold text-center">{{ $ingredient->name }}</h1>
                            
                            {{-- Categorien --}}
                            <div class="pt-10 text-center">
                                <h1 class="text-2xl font-bold sm:text-left">
                                    Categories:
                                </h1>
                                <div class="flex pt-2 items-center justify-center sm:items-start sm:justify-start">
                                    @if($ingredient->alcohol)
                                        <div class="p-3 px-4 rounded-lg bg-slate-300 max-w-fit max-h-fit">
                                            Alcoholic
                                        </div>
                                    @else
                                        <div class="p-3 px-4 rounded-lg bg-slate-300 max-w-fit max-h-fit">
                                            Non-Alcholic
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="py-2 sm:py-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Drankjes waar dit ingredient wordt gebruikt --}}
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 bg-white border-b border-gray-200">
                    <h1 class="text-5xl text-center font-bold pt-6">
                        Used in
                    </h1>
                    <div class="grid grid-cols-4">
                        @foreach ($ingredient->drinks as $drink)
                            <div class="rounded-lg p-4">
                                <div class="flex justify-center">
                                    <a href="{{ route('show.drink', [$drink->id, 'metric']) }}">
                                        <img class="rounded-lg shadow-xl" src="/storage/{{ $drink->image }}" alt="{{ $ingredient->name }}">
                                    </a>
                                </div>
                                <div class="flex justify-center pt-2">
                                    <h1 class="text-center font-bold text-2xl">
                                        {{ $drink->name }}
                                    </h1>
                                </div>
                            </div>  
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
