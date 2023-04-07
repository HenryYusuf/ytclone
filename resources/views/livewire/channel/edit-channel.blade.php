<div>
    @if ($channel->image)
        <Label>Current Image</Label>
        <div class="text-center">
            <img src="{{ $channel->picture }}" class="img-thumbnail">
        </div>
    @endif
    <form wire:submit.prevent="update">
        <div class="mb-3">
            <label for="name">Name</label>
            <input type="text" class="form-control" wire:model="channel.name">
        </div>

        @error('channel.name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" wire:model="channel.slug">
        </div>

        @error('channel.slug')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea cols="30" rows="4" class="form-control" wire:model="channel.description"></textarea>
        </div>

        @error('channel.description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="image">Image</label>
            <input type="file" class="form-control" wire:model="image">
        </div>

        <div class="mb-3">
            @if ($image)
                Photo Preview:
                <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail">
            @endif
        </div>

        @error('channel.image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </form>
</div>
