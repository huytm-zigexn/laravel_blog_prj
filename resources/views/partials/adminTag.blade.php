<form action="{{ isset($tag) ? route('tags.update', $tag->slug) : route('tags.store') }}"
      method="POST">
    @csrf
    @if(isset($tag)) @method('PUT') @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $tag->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $tag->description ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ isset($tag) ? 'Update' : 'Create' }}
    </button>
</form>
