<x-geomir-layout>
  @section('content')
     <div class="" style="background-color: #CEB5DD;">

        <div class="fixed w-screen top-0 z-20" style="background-color: #CEB5DD;">
           <div class="bg-white-500 text-black relative">
               <div class="container mx-auto flex justify-center items-center">
               <img class="h-20" src='{{ asset("/img/prism_social-removebg-preview.png") }}'></img>
               </div>

               <hr class="absolute bottom-0 left-5 right-5 border-t-2 border-purple-800 rounded-full" >
           </div>


           <div class="bg-white-300 p-4 py-6 relative">
               <div class="container mx-auto md:px-10 flex justify-between">
               <a href="#" class="px-4 hover:underline">Home</a>
               <a href="#" class="px-4 hover:underline">Explore</a>
               <a href="#" class="px-4 hover:underline">Chat</a>
               <a href="#" class="px-4 hover:underline">New place</a>
               <a href="#" class="px-4 hover:underline">New Post</a>
               </div>

               <hr class="absolute bottom-0 left-0 right-0 border-t-2 border-purple-800 rounded-full mt-5">
           </div>
        </div>
        <div class="h-24">


        </div>
           <div class="md:pl-8 md:w-11/12 border-purple-800">
              <div class="pb-5 mb-5 md:pb-0 md:mb-0 md:border-none">
                 <div class=" flex flex-wrap">
                    @forelse ($posts as $index => $post)
                       <div class="w-screen md:w-1/2 mb-4 pr-1 pl-1 md:pl-0">
                          <div class= "border-8 rounded-md" style="border-color: #8A72AA;">
                             <div>
                                @if($post->file)
                                   <div class="relative h-96">
                                         <img src='{{ asset("storage/{$post->file->filepath}") }}' alt="File Image" style="width: 100%; height: 385px;">
                                         <div class="border-2 rounded-3xl absolute top-0 m-2 left-0 flex flex-row" style="background-color: #D583F1; border-color: #8A72AA;">
                                            <img class="h-6" src='{{ asset("/img/user trans.png") }}'></img>
                                            <p class= "pb-1 pr-2">{{ $post->author->name }}</p>
                                         </div>
                                   </div>
                                @endif
                             </div>
                             <div style="background-color: #ECCFFF;">
                                <p class="pl-1">{{ strlen($post->body) > 20 ? substr($post->body, 0, 15) . '...' : $post->body }}</p>
                             </div>
                          </div>
                       </div>
               @empty
               <div class="w-full px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No hay posts disponibles.</div>
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

        let currentPostIndex = 0;

        function changePost(direction) {
           const posts = document.querySelectorAll('.post-slide');
           currentPostIndex += direction;

           if (currentPostIndex < 0) {
                 currentPostIndex = posts.length - 1;
           } else if (currentPostIndex >= posts.length) {
                 currentPostIndex = 0;
           }

           posts.forEach(post => post.style.display = 'none');
           posts[currentPostIndex].style.display = 'block';
        }
        function openPostDetails(route, event) {
           if (event.target.classList.contains('no-redirect')) {
                 return;
           }

           event.stopPropagation();
           window.open(route);
        }
     </script>


  @endsection
</x-geomir-layout>


