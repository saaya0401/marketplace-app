<div>
    <div class="message__image-area @if($imageUrl) message__image--has-image @endif">
        <label class="message__image-label"><input type="file" wire:model=image class="hidden">画像を追加</label>
        @if($imageUrl)
            <img src="{{ Storage::url($imageUrl) }}" alt="Uploaded Image" class="message__image">
        @endif
    </div>
</div>
