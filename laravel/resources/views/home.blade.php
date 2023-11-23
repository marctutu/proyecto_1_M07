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

            <div class="relative border-r-2 border-black" style="width: 40%;">
               <div id="post-container" class="post-container">
                  @forelse ($posts as $index => $post)
                     <div class="post-slide" style="display: {{ $index === 0 ? 'block' : 'none' }}">
                           <!-- Contenido de la publicación -->
                           <div>
                              @if($post->file)
                                 <div class="relative">
                                       <img src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" class="w-80 h-80">
                                       <div class="absolute top-0 left-0 bg-white p-2">
                                          <p>{{ $post->author->name }}</p>
                                       </div>
                                 </div>
                              @endif
                           </div>
                           <div>
                              <a href="{{ route('posts.show', $post->id) }}">{{ strlen($post->body) > 20 ? substr($post->body, 0, 20) . '...' : $post->body }}</a>
                           </div>
                     </div>
                  @empty
                     <div class="w-full px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay posts disponibles.</div>
                  @endforelse

                  <!-- Botones de navegación -->
                  <button id="prev-post" onclick="changePost(-1)">Anterior</button>
                  <button id="next-post" onclick="changePost(1)">Siguiente</button>
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
                              <a href="{{ route('posts.show', $post->id) }}">{{ strlen($post->body) > 20 ? substr($post->body, 0, 20) . '...' : $post->body }}</a>
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
         let currentPostIndex = 0;

         // Función para cambiar de publicación
         function changePost(direction) {
            const posts = document.querySelectorAll('.post-slide');
            currentPostIndex += direction;

            // Verificar límites
            if (currentPostIndex < 0) {
                  currentPostIndex = posts.length - 1;
            } else if (currentPostIndex >= posts.length) {
                  currentPostIndex = 0;
            }

            // Ocultar todas las publicaciones y mostrar la actual
            posts.forEach(post => post.style.display = 'none');
            posts[currentPostIndex].style.display = 'block';
         }
      </script>

   @endsection
</x-geomir-layout>


