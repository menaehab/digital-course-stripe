<div>
    <h1 class="text-2xl font-semibold">{{ $course->name }}</h1>
    <p class="text-sm text-neutral-400">{{ $course->description }}</p>
    <p class="my-2">${{ $course->price / 100 }}</p>
</div>
