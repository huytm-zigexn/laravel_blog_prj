<form action="{{ isset($category) ? route('categories.update', $category->slug) : route('categories.store') }}"
      method="POST">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ isset($category) ? 'Update' : 'Create' }}
    </button>
</form>
