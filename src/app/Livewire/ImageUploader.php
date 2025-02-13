<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;

class ImageUploader extends Component
{
    use WithFileUploads;
    public $image;
    public $imageUrl;

    public function updatedImage(){
        if($this->image) {
            $imageName=$this->image->getClientOriginalName();
            $path=$this->image->storeAs('item-img', $imageName, 'public');
            $this->imageUrl=$path;
            Session::put('item-img', $path);
        }
    }

    public function render()
    {
        return view('livewire.image-uploader');
    }
}
