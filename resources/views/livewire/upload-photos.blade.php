<div>
        <video class="max-w-[50%] rounded-lg shadow-lg" playsinline autoplay></video>
        <canvas style="display:none;" ></canvas>
        <button class="px-4 py-2 mt-2 text-white bg-green-500 rounded-lg" >Save Photo</button>

        <div class="grid grid-cols-4 gap-2 mt-2 sm:grid-cols-8">
            @foreach ($photos as $photo)
                <div class="relative flex items-center px-2 py-2 space-x-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="shrink">
                        <img class="h-auto rounded-lg" src="{{ $photo->path }}" alt="">
                    </div>
                </div>
                
            @endforeach
        </div>
</div>
<script>
    const video = document.querySelector('video');
    const canvas = window.canvas = document.querySelector('canvas');
    const button = document.querySelector('button');

    button.onclick = function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        Livewire.emit('storePhoto', canvas.toDataURL());
    };

    const constraints = {
        audio:false,
        video:{
            width: 960,
            height: 720,
            facingMode:{exact:"environment"},
        }
    };

    function handleSuccess(stream) {
        window.stream = stream; // make stream available to browser console
        video.srcObject = stream;
    }

    function handleError(error) {
        console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
    }
    
    navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);
</script>