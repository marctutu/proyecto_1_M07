<!-- resources/views/geomir.blade.php -->
<x-geomir-layout>
   @section('content')
      <div class="" style="background-color: #CEB5DD;">

         <!-- Menú superior con línea horizontal -->
         <div class="fixed w-screen top-0 z-20" style="background-color: #CEB5DD;">
            <div class="bg-white-500 text-black relative">
                <div class="container mx-auto flex justify-center items-center">
                <img class="h-20" src='{{ asset("/img/prism_social-removebg-preview.png") }}'></img>
                </div>

                <!-- Línea horizontal -->

                <hr class="absolute bottom-0 left-5 right-5 border-t-2 border-purple-800 rounded-full" >
            </div>

            <!-- Segundo menú con línea horizontal y desplazamiento hacia abajo -->

            <div class="bg-white-300 p-4 py-6 relative">
                <div class="container mx-auto md:px-10 flex justify-between">
                <a href="#" class="px-4 hover:underline">Home</a>
                <a href="#" class="px-4 hover:underline">Explore</a>
                <a href="#" class="px-4 hover:underline">Chat</a>
                <a href="#" class="px-4 hover:underline">New place</a>
                <a href="#" class="px-4 hover:underline">New Place</a>
                </div>

                <!-- Línea horizontal -->

                <hr class="absolute bottom-0 left-0 right-0 border-t-2 border-purple-800 rounded-full mt-5">
            </div>
         </div>
         <div class="h-24">

         </div>
            <div class="md:pl-8 md:w-11/12 border-purple-800">
               <div class="pb-5 mb-5 md:pb-0 md:mb-0 md:border-none">
                  <!-- Fila 1 -->
                  <div class=" flex flex-wrap">
                     @forelse ($places as $index => $place)
                        <div class="w-screen md:w-1/3 mb-4 pr-1 pl-1 md:pl-0">
                           <div class= "border-8 rounded-md" style="border-color: #8A72AA;">
                              <div>
                                 @if($place->file)
                                    <div class="relative h-96">
                                          <img src='{{ asset("storage/{$place->file->filepath}") }}' alt="File Image" style="width: 100%; height: 385px;">
                                          <div class="border-2 rounded-3xl absolute top-0 m-2 left-0 flex flex-row" style="background-color: #D583F1; border-color: #8A72AA;">
                                             <img class="h-6" src='{{ asset("/img/user trans.png") }}'></img>
                                             <p class= "pb-1 pr-2">{{ $place->author->name }}</p>
                                          </div>
                                    </div>
                                 @endif
                              </div>
                              <div style="background-color: #ECCFFF;">
                                 <p class="pl-1">{{ strlen($place->description) > 20 ? substr($place->description, 0, 15) . '...' : $place->description }}</p>
                              </div>
                           </div>
                        </div>
                @empty
                <div class="w-full px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay places disponibles.</div>
                @endforelse
               </div>
            </div>
            <div class="h-14 md:hidden">

            </div>
            <div class="border-purple-800 w-screen border-t-2 md:border-none p-4 fixed bottom-0 md:right-0 z-10 md:pl-8 md:w-1/12" style="background-color: #CEB5DD;">
               <div class="container border-purple-800 md:border-l-2 flex md:flex-col justify-between md:space-y-52">
                  <div class="md:pt-10">
                     <img class="h-16 md:pl-10" src='{{ asset("/img/likes morado fill.png") }}'></img>
                  </div>
                  <div>
                     <img class="h-16 pl-8" src='{{ asset("/img/user trans.png") }}'></img>
                  </div>
                  <div class="md:pb-10">
                     <img class="h-16 pl-10" src='{{ asset("/img/favorites morado fill de verdad.png") }}'></img>
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