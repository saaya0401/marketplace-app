<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;

class ProfileImageUploader extends Component
{
    use WithFileUploads;
    public $profileImage;
    public $imageUrl;

    public function mount($profile = null){
        if($profile && isset($profile['profile_image'])){
            $this->imageUrl=$profile['profile_image'];
        }else{
            $this->imageUrl=null;
        }
    }

    public function updatedProfileImage(){
        if ($this->profileImage) {
            $imageName=$this->profileImage->getClientOriginalName();
            $path=$this->profileImage->storeAs('profile-img', $imageName, 'public');
            $this->imageUrl=$path;
            Session::put('profile_image', $path);
        }
    }

    public function render()
    {
        return view('livewire.profile-image-uploader');
    }
}
