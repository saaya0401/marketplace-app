<div class="profile__image-area">
    <div class="profile__image-area--inner">
        <div class="profile__image">
            @if($imageUrl)
            <img src="{{ Storage::url($imageUrl) }}" alt="Uploaded Image" class="profile-form__image">
            @endif
        </div>
        <div class="profile__image-input">
            <label class="profile-image__label"><input type="file" wire:model="profileImage" class="hidden">画像を選択する</label>
        </div>
    </div>
    <div class="form-error">
        @error('profile_image')
        {{$message}}
        @enderror
    </div>
    <input type="hidden" name="profile_image" value="{{ $imageUrl }}">
</div>