<?php

namespace App\Http\Livewire\Video;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class AllVideo extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $channel;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function render()
    {
        return view('livewire.video.all-video')
            ->with('videos', $this->channel->videos()->paginate(5))
            ->extends('layouts.app');
    }

    public function delete(Video $video)
    {
        // check if user is allowed to delete
        $this->authorize('delete', $video);

        // Delete folder
        $deleted = Storage::disk('videos')->deleteDirectory($video->uid);

        if ($deleted) {
            $video->delete();
        }

        return redirect()->back();
    }
}
