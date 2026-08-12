<?php

namespace App\Livewire;
use Livewire\Component;
use Native\Mobile\Facades\Camera;
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Camera\PhotoTaken;
class ProfilePhoto extends Component
{
    public $photoPath;

    public function capturePhoto()
    {
        Camera::getPhoto()->id('profile-photo');
    }

    #[OnNative(PhotoTaken::class)]
    public function handlePhoto(string $path, string $id)
    {
    if ($id === 'profile-photo') {
        $this->photoPath = $path;
    }
    }

    public function render()
    {
        return view('livewire.profile-photo');
    }
}