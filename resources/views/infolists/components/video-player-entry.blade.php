<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div style="padding:56.25% 0 0 0;position:relative;">
        <iframe
            src="https://player.vimeo.com/video/{{ $getState() }}?h=17d092cc84&color=f70c1c"
            class="absolute top-0 left-0 w-full h-full"
            frameborder="0"
            allow="autoplay; fullscreen; picture-in-picture"
            allowfullscreen></iframe>
    </div>
    @script
        <script src="https://player.vimeo.com/api/player.js"></script>
    @endscript
</x-dynamic-component>
