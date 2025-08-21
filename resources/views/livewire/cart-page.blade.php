<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    @if (request('message'))
        <div class="bg-red-100 border text-center border-red-400 text-red-700 px-4 py-3 rounded" role="alert"
            wire:poll.5s>
            {{ request('message') }}
        </div>
    @endif
    <h1 class="text-4xl text-center font-bold">Cart</h1>
    <h1 class="text-3xl text-center font-bold">Total: {{ $cart->total() }}</h1>
    @if (count($cart->courses) > 0)
        <a class="px-4 py-2 my-4 w-max mx-auto text-center rounded-lg bg-zinc-900 text-neutral-200 hover:bg-zinc-600 transition-colors"
            href="{{ route('checkout.guest') }}">Check Out</a>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @foreach ($cart->courses as $course)
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <!-- Light mode -->
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:hidden" />
                    <!-- Dark mode -->
                    <div class="hidden dark:block rounded-xl h-full w-full bg-neutral-900 p-4">
                        <a wire:navigate href="{{ route('course.show', $course->slug) }}"
                            class="mb-4 text-2xl text-center font-semibold text-neutral-100">{{ $course->name }}</a>
                        <p class="text-sm text-neutral-400">
                            {{ $course->description }}
                        </p>
                        <p class="my-2">
                            {{ $course->price() }}
                        </p>
                        <a class="dark:bg-zinc-500 p-2 my-2 rounded-lg hover:bg-zinc-600 transition-colors"
                            href="#" wire:click="removeFromCart({{ $course->id }})">
                            Remove
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
