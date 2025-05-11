<form method="POST" action="{{ isset($spot) ? route('spots.update', $spot) : route('spots.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($spot))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($spot) ? $spot->name : old('name') }}" required>
    </div>

    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" class="form-control" id="location" name="location" value="{{ isset($spot) ? $spot->location : old('location') }}" required>
    </div>

    <div class="form-group">
        <label for="capacity">Capacity</label>
        <input type="number" class="form-control" id="capacity" name="capacity" value="{{ isset($spot) ? $spot->capacity : old('capacity') }}" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description">{{ isset($spot) ? $spot->description : old('description') }}</textarea>
    </div>

    <div class="form-group">
        <label for="picture">Picture</label>
        <input type="file" class="form-control-file" id="picture" name="picture">
        @if(isset($spot) && $spot->picture)
            <div class="mt-2">
                <img src="{{ asset($spot->picture) }}" alt="{{ $spot->name }}" style="max-width: 200px;">
                <p>Current image</p>
            </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($spot) ? 'Update' : 'Create' }} Spot</button>
</form>