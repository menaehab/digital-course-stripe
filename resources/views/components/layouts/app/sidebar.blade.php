<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    {{-- Sidebar --}}
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        {{-- Close button (mobile) --}}
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        {{-- Navigation --}}
        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('home')" :current="request()->routeIs('home')"
                    wire:navigate>
                    {{ __('Home') }}
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.item icon="shopping-cart" :href="route('cart')" :current="request()->routeIs('cart')"
                wire:navigate>
                {{ __('Cart') }}
            </flux:navlist.item>

            <flux:navlist.item icon="shopping-cart" :href="route('payment-method-checkout.index')"
                :current="request()->routeIs('payment-method-checkout.index')" wire:navigate>
                {{ __('Payment Method') }}
            </flux:navlist.item>
            <flux:navlist.item icon="shopping-cart" :href="route('payment-intent.index')"
                :current="request()->routeIs('payment-intent.index')" wire:navigate>
                {{ __('Payment Intent') }}
            </flux:navlist.item>
            @guest
                <flux:navlist.group :heading="__('Account')" class="grid">
                    <flux:navlist.item :href="route('login')" icon="arrow-right" wire:navigate>
                        {{ __('Login') }}
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('register')" icon="user-plus" wire:navigate>
                        {{ __('Register') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endguest
        </flux:navlist>

        <flux:spacer />

        {{-- Desktop User Menu --}}
        @auth
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down" />
                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth
    </flux:sidebar>

    {{-- Mobile header --}}
    <flux:header class="lg:hidden">
        {{-- Open sidebar button --}}
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />

        {{-- Mobile User Menu --}}
        @auth
            <flux:dropdown position="top" align="end">
                <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @endauth

        @guest
            <flux:dropdown position="top" align="end">
                <flux:profile :initials="''" icon-trailing="chevron-down" />
                <flux:menu>
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('login')" icon="arrow-right" wire:navigate>
                            {{ __('Login') }}
                        </flux:menu.item>
                        <flux:menu.item :href="route('register')" icon="user-plus" wire:navigate>
                            {{ __('Register') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>
                </flux:menu>
            </flux:dropdown>
        @endguest
    </flux:header>

    {{-- Page content --}}
    {{ $slot }}


    @fluxScripts
</body>

</html>
