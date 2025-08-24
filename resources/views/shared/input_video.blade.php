@php
    $type ??= 'text';
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= ucfirst($name);
@endphp
<!-- resources/views/shared/input_video.blade.php -->
<div class="m-2">
    <input type="url" id="{{ $name }}" name="{{ $name }}" placeholder="Entrez l'URL de la vidéo" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500" required>
</div>

<div class="m-2">
    <div class="mt-2">
        <iframe id="{{ $name }}_preview" width="100%" height="315" src="" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

<script>
    const input = document.getElementById('{{ $name }}');
    const iframe = document.getElementById('{{ $name }}_preview');

    input.addEventListener('input', function() {
        const url = input.value;
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|.+\?v=)?([^&]{11})/;
        const vimeoRegex = /^(https?:\/\/)?(www\.)?(vimeo\.com\/)(\d+)/;

        if (youtubeRegex.test(url)) {
            const videoId = url.match(youtubeRegex)[5];
            iframe.src = `https://www.youtube.com/embed/${videoId}`;
        } else if (vimeoRegex.test(url)) {
            const videoId = url.match(vimeoRegex)[4];
            iframe.src = `https://player.vimeo.com/video/${videoId}`;
        } else {
            iframe.src = '';
        }
    });
</script>
