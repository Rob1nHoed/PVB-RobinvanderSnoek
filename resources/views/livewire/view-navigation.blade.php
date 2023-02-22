<div>
    <!-- Hamburger -->
    <div class="-mr-2 items-center sm:hidden pt-2 relative">
        <button wire:click="toggle" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

            <!-- Responsive Navigation Menu -->
    <div x:show="open" class="sm:hidden relative flex justify-end">
        @if($open)
            <div class="mb-3 pr-0.5 space-y-1 bg-slate-300 opacity-90 absolute z-10 items-center justify-end font-bold">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Homepage') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('search.withIngredients')" :active="request()->routeIs('search.withIngredients')">
                    {{ __('Search with ingredients') }}
                </x-responsive-nav-link>
            </div>
        @endif
    </div>
</div>

