    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @if (count($courses) > 0)
                @foreach ($courses as $course)
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
                                ${{ $course->price / 100 }}
                            </p>

                            <a class="dark:bg-zinc-500 p-2 my-2 rounded-lg hover:bg-zinc-600 transition-colors"
                                href="#" wire:click="addToCart({{ $course->id }})">
                                Add To Cart
                            </a>
                        </div>
                    </div>
                @endforeach
        </div>
        @endif
    </div>

    </div>
