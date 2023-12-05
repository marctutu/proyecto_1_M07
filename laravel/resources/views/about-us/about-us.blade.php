<head>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
</head>

<x-geomir-layout>
    @section('content')
    <div class="min-h-screen flex justify-center items-center" style="background-color: #CEB5DD;">
        <div class="text-center">
            <h1 class="text-3xl font-bold mb-8">About Us</h1>
            <div class="flex space-x-4">
                <div class="image-container bg-gray-300 w-64 h-64 m-4 p-4 text-center" onmouseover="playAudio('audioMarc')" onmouseleave="pauseAudio('audioMarc')" onclick="openVideo()">
                    <img src="{{ asset('img/marc.jpg') }}" class="mx-auto grayscale-contrast">
                    <audio id="audioMarc" src="{{ asset('img/musica1.mp3') }}"></audio>
                    <div class="info absolute bottom-0 left-0 w-full p-4 bg-white bg-opacity-85">
                        <h2 class="text-xl font-bold">Marc</h2>
                        <p class="text-black">CEO</p>
                    </div>
                    <div class="image-overlay absolute inset-0 flex flex-col justify-center items-center bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 ease-in-out">
                        <img src="{{ asset('img/futbol.jpg') }}" alt="Hobby image" class="hobby-photo opacity-0 transition-opacity duration-300 ease-in-out">
                        <div class="overlay-text text-white text-2xl font-bold my-4 opacity-0 transition-opacity duration-300 ease-in-out">Fútbol</div>
                    </div>
                </div>

                <div class="image-container bg-gray-300 w-64 h-64 m-4 p-4 text-center" onmouseover="playAudio('audioAxel')" onmouseleave="pauseAudio('audioAxel')">
                    <img src="{{ asset('img/axel.jpg') }}" class="mx-auto grayscale-contrast">
                    <audio id="audioAxel" src="{{ asset('img/musica2.mp3') }}"></audio>
                    <div class="info absolute bottom-0 left-0 w-full p-4 bg-white bg-opacity-85">
                        <h2 class="text-xl font-bold">Axel</h2>
                        <p class="text-black">CEO</p>
                    </div>
                    <div class="image-overlay absolute inset-0 flex flex-col justify-center items-center bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 ease-in-out">
                        <img src="{{ asset('img/ps5.jpg') }}" alt="Hobby image" class="hobby-photo opacity-0 transition-opacity duration-300 ease-in-out">
                        <div class="overlay-text text-white text-2xl font-bold my-4 opacity-0 transition-opacity duration-300 ease-in-out">PlayStation 5</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="youtubeModal" style="display:none;">
            <div class="modal-content">
                <span class="close" onclick="closeVideo()">&times;</span>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/kgCbG0q4jmc?si=8pdZbCGmLvBp2A-h" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    @endsection
</x-geomir-layout>


<style>
    .image-container {
        position: relative;
        overflow: hidden;
    }

    .image-container img {
        max-width: 100%;
    }

    .image-container:hover .info,
    .image-container:hover .image-overlay,
    .image-container:hover .image-overlay .hobby-photo,
    .image-container:hover .image-overlay .overlay-text {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .image-container:hover .info {
        visibility: hidden;
        opacity: 0;
    }

    .image-container:hover .image-overlay {
        opacity: 1;
        visibility: visible;
    }

    .image-overlay .hobby-photo {
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .image-container:first-child:hover .image-overlay .hobby-photo {
        opacity: 1;
        transform: translate(-50%, -50%) rotateX(360deg);
    }

    .image-container:last-child:hover .image-overlay .hobby-photo {
        opacity: 1;
        transform: translate(-50%, -50%) rotateY(360deg);
    }

    .image-container:hover .image-overlay .overlay-text {
        opacity: 1;
    }

    .info {
        transition: opacity 0.3s ease;
    }

    .grayscale-contrast {
        filter: grayscale(100%) contrast(150%);
    }

    .overlay-text {
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
    }

    .modal {
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 33%;
    }

    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
function playAudio(audioId) {
    var audio = document.getElementById(audioId);
    audio.play();
}

function pauseAudio(audioId) {
    var audio = document.getElementById(audioId);
    audio.pause();
}

// Funció vídeo de YouTube
function openVideo() {
        document.getElementById('youtubeModal').style.display = 'block';
    }

    // Función cerrar el modal
function closeVideo() {
    document.getElementById('youtubeModal').style.display = 'none';
}
</script>

