<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileImageUploader extends Component
{
    use WithFileUploads;
    public $profileImage;
    public $imageName;
    public $imageUrl;

    public function mount(){
        $this->imageUrl=session('profile_image', auth()->user()->profile_image);
    }

    public function updatedProfileImage(){
        if ($this->profileImage) {
            $this->imageName = $this->profileImage->getClientOriginalName();
            $this->imageUrl = $this->profileImage->storeAs('profile-img', $this->imageName, 'public');
            session(['profile_image'=>$this->imageUrl]);
        }
    }

    public function render()
    {
        return view('livewire.profile-image-uploader');
    }
}
