<div>
    @if ($photo)
        <img src="{{ $photo->temporaryUrl() }}" alt="Image Preview" style="max-width: 100%; height: auto;" />
    @else
        <p>No image selected</p>
    @endif
</div>
