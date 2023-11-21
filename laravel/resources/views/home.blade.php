<!-- resources/views/geomir.blade.php -->
<x-geomir-layout>
   @section('content')
      <div class="bg-white">

<!-- Menú superior con línea horizontal -->
         <div class="bg-white-500 text-black p-4 py-6 relative">
         <div class="container mx-auto flex justify-center items-center">
            <div class="font-bold">Logo</div>
         </div>
         <!-- Línea horizontal -->
         <hr class="absolute bottom-0 left-5 right-5 border-t-2 border-black rounded-full">
         </div>

         <!-- Segundo menú con línea horizontal y desplazamiento hacia abajo -->

         <div class="bg-white-300 p-4 py-6 relative">
         <div class="container mx-auto px-10 flex justify-between">
            <a href="#" class="px-4 hover:underline">Home</a>
            <a href="#" class="px-4 hover:underline">Explore</a>
            <a href="#" class="px-4 hover:underline">Chat</a>
            <a href="#" class="px-4 hover:underline">New post</a>
            <a href="#" class="px-4 hover:underline">New Place</a>
         </div>

         <!-- Línea horizontal -->

         <hr class="absolute bottom-0 left-0 right-0 border-t-2 border-black rounded-full mt-5">
         </div>

         <!-- Contenido principal -->

         <div class="h-screen w-full p-4 py-6 relative flex">

         <!-- Imagen a la izquierda -->

         <div class="w-3/6 relative border-r-2 border-black">
            <img src="tu_imagen.jpg" alt="Imagen Izquierda" class="w-full h-auto">
         </div>

         <!-- Contenedor de imágenes a la derecha -->

         <div class="w-2/6 pl-8 border-r-2 border-black">
            <!-- Fila 1 -->
            <div class="flex mb-4 h-1/3">
               @forelse ($posts as $post)
                                <div class="w-1/4">
                                    
                                    <div class="h-5/6>
                                        @if($post->file)
                                            <div class="mt-4">
                                                <img src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" class="w-32 h-32 object-cover mb-2">
                                        @endif
                                    </div>
                                    <div class="h-1/6">
                                        {{ strlen($post->body) > 20 ? substr($post->body, 0, 20) . '...' : $post->body }}
                                        @if(strlen($post->body) > 20)
                                            <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver más</a>
                                        @endif
                                    </div>
                                    <div class="px-6 py-4 whitespace-nowrap">{{ $post->author->name }}</div>
                                 </div>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay posts disponibles.</td>
                                </tr>
                  @endforelse
            </div> 

            <!-- Fila 2 -->
            <div class="flex mb-4 h-1/3">
               <div class="w-1/4">
                  <img src="imagen1.jpg" alt="Imagen 5" class="w-full h-auto">
               </div>
               <div class="w-1/4 pl-4">
                  <img src="imagen2.jpg" alt="Imagen 6" class="w-full h-auto">
               </div>
               <div class="w-1/4 pl-4">
                  <img src="imagen3.jpg" alt="Imagen 7" class="w-full h-auto">
               </div>
               <div class="w-1/4 pl-4">
                  <img src="imagen4.jpg" alt="Imagen 8" class="w-full h-auto">
               </div>   
            </div>
            
            <div class="flex mb-4 h-1/3">
               <div class="w-1/4">
                  <img src="imagen1.jpg" alt="Imagen 9" class="w-full h-auto">
               </div>
               <div class="w-1/4 pl-4">
                  <img src="imagen2.jpg" alt="Imagen 10" class="w-full h-auto">
               </div>
               <div class="w-1/4 pl-4">
                  <img src="imagen3.jpg" alt="Imagen 11" class="w-full h-auto">
               </div>
               <div class="w-1/4 pl-4">
                  <img src="imagen4.jpg" alt="Imagen 12" class="w-full h-auto">
               </div>   
            </div>
         </div>
         <div class="w-1/6 pl-8 ">
               <div class="container px-10 flex-col">
                  <a href="#" class="block py-2 hover:underline">Likes</a>
                  <a href="#" class="block py-2 hover:underline">Account</a>
                  <a href="#" class="block py-2 hover:underline">Favs</a>
               </div>
            </div>
         </div>

         <!-- Línea de delimitación -->
         <hr class="my-8">
         </div>
      </div>
    @endsection
</x-geomir-layout>


