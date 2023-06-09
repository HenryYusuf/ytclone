<?php

namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use App\Models\Subscription;
use Livewire\Component;

class ChannelInfo extends Component
{
    public $channel;

    public $userSubscribed = false;

    public $subscribers;

    protected $listeners = [
        'load_values' => '$refresh'
    ];

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
        if (auth()->check()) {
            if (auth()->user()->isSubscribedTo($this->channel)) {
                $this->userSubscribed = true;
            }
        }
    }

    public function render()
    {
        $this->subscribers = $this->channel->subscriptions->count();

        return view('livewire.channel.channel-info')->extends('layouts.app');
    }

    public function toggle()
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->isSubscribedTo($this->channel)) {
            Subscription::where('user_id', auth()->id())->where('channel_id', $this->channel->id)->delete();
            $this->userSubscribed = false;
        } else {
            Subscription::create([
                'user_id' => auth()->id(),
                'channel_id' => $this->channel->id,
            ]);
            $this->userSubscribed = true;
        }

        $this->emit('load_values');
    }
}
