<div class="exhibited__image-area">
    <div class="exhibited__image-area--inner">
        <div class="exhibited-products__image @if($imageUrl) exhibited-products__image--has-image @endif">
            <label class="exhibited-products__image-label"><input type="file" wire:model=image class="hidden">画像を選択する</label>
            @if($imageUrl)
            <img src="{{ Storage::url($imageUrl) }}" alt="Uploaded Image" class="exhibited-form__image">
            @endif
        </div>
    </div>
    <div class="form-error">
        @error('image')
        {{$message}}
        @enderror
    </div>
    <input type="hidden" name="image" value="{{ $imageUrl }}">
</div>