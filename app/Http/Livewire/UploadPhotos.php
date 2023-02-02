<?php

namespace App\Http\Livewire;

use App\Models\Photo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithFileUploads;


class UploadPhotos extends Component
{
    use WithFileUploads;

    protected $listeners = ['storePhoto'];
    
    public $photos = [];

    public function storePhoto($imageBlob) {
        $imageBlob = str_replace('data:image/png;base64,', '', $imageBlob);
        $imageBlob = str_replace(' ', '+', $imageBlob);
        $imageName = 'photo' . Str::slug(Carbon::now()) . '.png';

        $photo = new Photo();
        $photo->name = $imageName;
        $photo->path = '/storage/' . $imageName;
        Storage::disk('public')->put($imageName, base64_decode($imageBlob));
        $photo->save();

        $this->photos = Photo::all();
    }
    public function mount() {
        Photo::truncate();
    }
    public function render()
    {
        return view('livewire.upload-photos');
    }
}
