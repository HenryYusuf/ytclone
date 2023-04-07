<?php

namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

class EditChannel extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $channel;
    public $image;

    // protected $rules = [
    //     'channel.name' => 'required|max:255}unique:channels,name,' . $this->channel->id,
    //     'channel.slug' => 'required|max:255',
    //     'channel.description' => 'max:1000',
    // ];

    protected function rules()
    {
        return [
            'channel.name' => 'required|max:255|unique:channels,name,' . $this->channel->id,
            'channel.slug' => 'required|max:255|unique:channels,slug,' . $this->channel->id,
            'channel.description' => 'max:1000',
            'image' => 'image|max:1024',
        ];
    }

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function render()
    {
        return view('livewire.channel.edit-channel');
    }

    public function update()
    {

        $this->authorize('update', $this->channel);
        $this->validate();

        $this->channel->update([
            'name' => $this->channel->name,
            'slug' => $this->channel->slug,
            'description' => $this->channel->description,
        ]);

        // * Check if image is submitted
        if ($this->image) {
            // * delete the old image
            if ($this->channel->image) {
                unlink(storage_path('app/images/' . $this->channel->image));
            }

            // * save the image
            $image = $this->image->storeAs('images', $this->channel->uid . '.png');
            $imageImage = explode('/', $image)[1];

            // * resize the image
            $img = Image::make(storage_path('app/' . $image))
                ->encode('png')
                ->fit(80, 80, function ($constraint) {
                    $constraint->upsize();
                })->save();

            // * update the image path
            $this->channel->update([
                'image' => $imageImage,
            ]);
        }

        session()->flash('message', 'Channel updated successfully.');
        return redirect()->route('channel.edit', ['channel' => $this->channel->slug]);
    }
}
