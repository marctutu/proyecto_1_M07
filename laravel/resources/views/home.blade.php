<!-- resources/views/geomir.blade.php -->
<x-geomir-layout>
   @section('content')
      <div class="h-screen bg-white">

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

         <div class="w-full p-4 py-6 relative flex">

            <!-- Imagen a la izquierda -->

            <div class=" border-r-2 border-black" style="width: 40%;">
               <div id="place-container" class="place-container">
                  @forelse ($places as $index => $place)
                     <div onclick="openPlaceDetails('{{ route('places.show', $place->id) }}', event)" class="place-slide" style="display: {{ $index === 0 ? 'block' : 'none' }}">                           <!-- Contenido de la publicación -->
                           <div>
                              @if($place->file)
                                 <div class="relative">
                                       <img src='{{ asset("storage/{$place->file->filepath}") }}' alt="File Image" class="relative pr-6" style="width: 100%; height: 500px;">
                                       <div class="absolute top-0 left-0 bg-white p-2">
                                          <p>{{ $place->author->name }}</p>
                                       </div>
                                       <button id="prev-place" class="no-redirect absolute top-1/2 left-0 bg-white p-2" onclick="changePlace(-1)">Anterior</button>
                                       <button id="next-place" class="no-redirect absolute top-1/2 right-0 pr-6 bg-white pl-2 pt-2 pb-2" onclick="changePlace(1)">Siguiente</button>
                                 </div>
                              @endif
                           </div>

                           <div>
                              <p>{{ strlen($place->description) > 20 ? substr($place->description, 0, 200) . '...' : $place->description }}</p>
                           </div>
                           
                     </div>
                  @empty
                     <div class="w-full px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay places disponibles.</div>
                  @endforelse

               </div>
            </div>

            <!-- Contenedor de imágenes a la derecha -->

            <div class="pl-8 border-r-2 border-black" style="width: 50%;">
               <!-- Fila 1 -->
                  <div class="flex flex-wrap">
                     @forelse ($posts as $index => $post)
                        <div class="w-1/4 mb-4">
                           <div>
                              @if($post->file)
                                 <div class="relative">
                                       <img src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" class="w-44 h-40">
                                       <div class="absolute top-0 left-0 bg-white p-2">
                                          <p>{{ $post->author->name }}</p>
                                       </div>
                                 </div>
                              @endif
                           </div>
                           <div>
                              <p>{{ strlen($post->body) > 20 ? substr($post->body, 0, 20) . '...' : $post->body }}</p>
                           </div>
                        </div>
               @if(($index + 1) % 4 == 0)
                  </div>
                  <div class="flex flex-wrap">
               @endif
                     @empty
                        <div class="w-full px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay posts disponibles.</div>
                     @endforelse
                  </div>
            </div>
            <div class="pl-8" style="width: 10%;">
               <div class="container px-10 flex-col space-y-40">
                  <div class="pt-10">
                     <a href="#" class="block py-2 hover:underline">Likes</a>
                  </div>
                  <div>
                     <a href="#" class="block py-2 hover:underline">Account</a>
                  </div>
                  <div class="pb-10">
                     <a href="#" class="block py-2 hover:underline">Favs</a>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
      <script>
         // Índice de la publicación actual
         let currentPlaceIndex = 0;

         // Función para cambiar de publicación
         function changePlace(direction) {
            const places = document.querySelectorAll('.place-slide');
            currentPlaceIndex += direction;

            // Verificar límites
            if (currentPlaceIndex < 0) {
                  currentPlaceIndex = places.length - 1;
            } else if (currentPlaceIndex >= places.length) {
                  currentPlaceIndex = 0;
            }

            // Ocultar todas las publicaciones y mlacerar la actual
            places.forEach(place => place.style.display = 'none');
            places[currentPlaceIndex].style.display = 'block';
         }
         function openPlaceDetails(route, event) {
            // Verifica si el evento se originó en un elemento con la clase "no-redirect"
            if (event.target.classList.contains('no-redirect')) {
                  // Si es un botón que no debe redireccionar, no hagas nada
                  return;
            }

            // Evita la propagación del evento al contenedor padre
            event.stopPropagation();
            // Realiza la acción de redireccionamiento
            window.open(route);
         }
      </script>

   @endsection
</x-geomir-layout>


