<x-geomir-layout>
    @section('content')
    <div class="min-h-screen flex justify-center items-center" style="background-color: #CEB5DD;">
        <div class="text-center">
            <h1 class="text-3xl font-bold mb-8">About Us</h1>
            <div class="flex space-x-4">
                <!-- Cuadrado 1 -->
                <div class="bg-gray-300 w-64 h-64 m-4 p-4 text-center">
                    <img src="{{ asset('img/marc.jpg') }}" class="mx-auto">
                    <h2 class="text-xl mt-4 font-bold">Marc</h2>
                    <p class="text-gray-600">Página About Us</p>
                </div>

                <!-- Cuadrado 2 -->
                <div class="bg-gray-300 w-64 h-64 m-4 p-4 text-center">
                    <img src="{{ asset('img/axel.jpg') }}" class="mx-auto">
                    <h2 class="text-xl mt-4 font-bold">Nombre 2</h2>
                    <p class="text-gray-600">Página About Us</p>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-geomir-layout>
