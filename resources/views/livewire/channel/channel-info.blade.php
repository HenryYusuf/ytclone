<div class="my-5">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="{{ asset('/images/' . $channel->image) }}" class="rounded-circle">
            <div class="ms-2">
                <h4>{{ $channel->name }}</h4>
                <p class="gray-text text-small">{{ $subscribers }} Subscribers</p>
            </div>
        </div>

        <div>
            <button wire:click.prevent="toggle"
                class="btn btn-lg text-uppercase {{ $userSubscribed ? 'sub-btn-active' : 'sub-btn' }}">
                {{ $userSubscribed ? 'Unsubscribed' : 'Subscribe' }}
            </button>
        </div>
    </div>
</div>
