<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;

class ChatMessageImage extends Component
{
    use WithFileUploads;
    public $image;
    public $imageUrl;

    public function updatedImage(){
        if($this->image) {
            $imageName=$this->image->getClientOriginalName();
            $path=$this->image->storeAs('chat-img', $imageName, 'public');
            $this->imageUrl=$path;
            Session::put('chat-img', $path);
        }
    }

    public function render()
    {
        return view('livewire.chat-message-image');
    }
}
