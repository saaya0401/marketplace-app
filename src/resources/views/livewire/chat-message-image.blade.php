<div>
    <div class="message__image-area @if($imageUrl) message__image--has-image @endif">
        @if($imageUrl)
            <div class="message__image-wrapper">
                <img src="{{ Storage::url($imageUrl) }}" alt="Uploaded Image" class="message__image">
            </div>
        @endif
        <label class="message__image-label"><input type="file" wire:model=image class="hidden">画像を追加</label>
    </div>
    <input type="hidden" name="message_image" value="{{ $imageUrl }}">
</div>
