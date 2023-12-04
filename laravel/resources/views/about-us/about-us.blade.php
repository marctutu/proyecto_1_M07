{{-- resources/views/about-us/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="bg-purple-400 container mx-auto px-6 py-12" style="background-color: purple">
    <h1 class="text-xl font-bold text-center mb-6">Meet our team</h1>
    <div class="flex justify-center"> <!-- Usamos flex para centrar horizontalmente -->
        @foreach ($teamMembers as $member)
            <div class="mx-4 mb-3"> <!-- Agregamos margen entre los elementos y margen inferior -->
                <div class="border p-4 rounded-lg text-center bg-white" 
                    onmouseenter="changeImage(this, '{{ $member['hobbyImage'] }}', 'hobby')"
                    onmouseleave="changeImage(this, '{{ $member['image'] }}', 'role')">
                    <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="mx-auto h-32 w-32 rounded-full">
                    <h3 class="mt-2 font-semibold">{{ $member['name'] }}</h3>
                    <p class="text-gray-600">{{ $member['role'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function changeImage(element, src, type) {
    const img = element.querySelector('img');
    const text = element.querySelector('p');

    img.src = src;
    text.textContent = type === 'hobby' ? '{{ $member['hobby'] }}' : '{{ $member['role'] }}';
}
</script>
@endsection
