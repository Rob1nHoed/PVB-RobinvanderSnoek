<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Icons -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <!-- Primary Navigation Menu -->
    <div class=" px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex width-1/4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:px-1 sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Homepage') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:px-1 sm:ml-10 sm:flex">
                    <x-nav-link :href="route('search.withIngredients')" :active="request()->routeIs('search.withIngredients')">
                        {{ __('Search with ingredients') }}
                    </x-nav-link>
                </div>
                                {{-- a searchbar at the right, without routes --}}
            </div>
            
            <form action="{{ route('show.searchResult') }}" method="POST">
                @csrf
                <div class="pt-3 pb-0.5">
                    <input type="text" name="name" class="rounded border shadow px-32 focus:outline-none focus:shadow-outline w-max" placeholder="Search for cocktails" required>
                </div>
            </form>
        
            {{-- Livewire component --}}
            @livewire('view-navigation')
        </div>
    </div>
</body>
</html>