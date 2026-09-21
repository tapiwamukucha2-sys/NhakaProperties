<nav x-data="{ open: false }" class="bg-[--paper-2] border-b border-[--line]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-10">
                <a href="{{ route('home') }}" class="font-serif-brand text-xl font-bold flex items-center gap-2 text-[--ink]">
                    <x-logo :size="28" />
                    {{ config('app.name') }}
                </a>

                <div class="hidden sm:flex sm:space-x-8 text-sm font-medium">
                    <a href="{{ route('home') }}" class="border-b-2 pb-1 {{ request()->routeIs('home') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Home</a>
                    <a href="{{ route('browse') }}" class="border-b-2 pb-1 {{ request()->routeIs('browse') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Browse</a>
                    <a href="{{ route('map') }}" class="border-b-2 pb-1 {{ request()->routeIs('map') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Map</a>
                    <a href="{{ route('agents') }}" class="border-b-2 pb-1 {{ request()->routeIs('agents') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Agents</a>
                    <a href="{{ route('about') }}" class="border-b-2 pb-1 {{ request()->routeIs('about') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">About</a>
                    <a href="{{ route('dashboard') }}" class="border-b-2 pb-1 {{ request()->routeIs('dashboard') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Dashboard</a>
                    <a href="{{ route('subscribe.index') }}" class="border-b-2 pb-1 {{ request()->routeIs('subscribe.*') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Billing</a>
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.properties.index') }}" class="border-b-2 pb-1 {{ request()->routeIs('admin.properties.*') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Approvals</a>
                        <a href="{{ route('admin.hero-slides.index') }}" class="border-b-2 pb-1 {{ request()->routeIs('admin.hero-slides.*') ? 'border-[--ink]' : 'border-transparent hover:border-[--ink]' }}">Hero Slides</a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-2 py-1.5 border border-[--line] text-sm leading-4 font-medium rounded-md text-[--ink] bg-[--paper-2] hover:bg-[--paper] focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ Auth::user()->avatarUrl() }}" alt="{{ Auth::user()->name }}" class="w-7 h-7 rounded-full object-cover">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('dashboard')">
                            {{ __('Dashboard') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[--ink] hover:bg-[--paper] focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')">Home</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('home').'#rent'">Browse</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-[--line]">
            <div class="px-4">
                <div class="font-medium text-base text-[--ink]">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-[--ink]/60">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
