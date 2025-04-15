@extends('app')

@section('title', 'All Posts')

@section('content')
    <h1 class="text-center mb-5" style="font-weight: bold; font-size: 35px; margin-top: 80px">All Posts</h1>
    <div class="row" style="margin-left: 20px">
        <div class="col-md-3">
            <div class="filter-sidebar">
                <h2>Bộ lọc</h2>
                
                <form action="{{ route('posts.index') }}" method="GET" id="filter-form">
                    <!-- Category Filter -->
                    <div class="d-flex justify-content-center">
                        <div class="filter-section" style="margin: 0 20px">
                            <h5>Danh mục</h5>
                            <div class="form-group">
                                <select name="category" class="form-control filter-select">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Tags Filter -->
                        <div class="filter-section" style="margin: 0 20px">
                            <h5>Thẻ</h5>
                            <div class="tag-list">
                                @foreach($tags as $tag)
                                <div class="form-check">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->slug }}" 
                                        class="form-check-input tag-checkbox"
                                        @php
                                            $selectedTags = array_filter((array) request('tags')); // loại bỏ các giá trị rỗng
                                        @endphp
                                        {{ in_array($tag->slug, $selectedTags) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $tag->name }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Áp dụng</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">Xóa bộ lọc</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row" style="margin: 20px">
        @if ($posts->count() <= 0)
            <h1>Can't find suitable blogs</h1>
        @else
            @foreach ($posts as $post)
                <div class="col" style="margin-bottom: 30px; max-width: 400px;">
                    <div class="card h-40 shadow-sm border-0 rounded-4 overflow-hidden" style="min-height: 400px;">
                        @if ($post->medias()->first())
                            <img src="{{ $post->medias()->first()->file_path }}" class="card-img-top" alt="{{ $post->title }}">
                        @endif
                        <form style="margin: auto" action="{{ route('likes.store', $post->slug) }}" method="POST">
                            @csrf
                            @php 
                                $hasLiked =  \App\Models\Like::where('post_id', $post->id) 
                                    ->where('user_id', Auth::id())->exists();
                            @endphp
                            <button
                                class="{{ $hasLiked ? 'liked' : '' }}"
                                style="border-radius: 20px; padding: 8px 10px; margin-top: 10px;"
                            >
                                <i style="font-size: 30px" class="fa-solid fa-heart"></i>
                            </button>
                        </form>
                        <div class="card-body">
                            <p style="margin: 0">Published at: {{ $post->published_at }}</p>
                            <h5 class="card-title" style="font-weight: 500">{{ $post->title }}</h5>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center bg-white border-0">
                            <div class="social_icon d-flex gap-2" style="padding: 20px 0">
                                <a href="#"><img src="images/fb-icon.png" width="28" height="28" /></a>
                                <a href="#"><img src="images/twitter-icon.png" width="28" height="28" /></a>
                                <a href="#"><img src="images/instagram-icon.png" width="28" height="28" /></a>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Xử lý chọn nhiều tag
        $('.tag-checkbox').on('change', function() {
            var selectedTags = [];
            $('.tag-checkbox:checked').each(function() {
                selectedTags.push($(this).val());
            });
            $('#tags-input').val(selectedTags.join(','));
        });
        
        // Xử lý xóa một tag từ active filters
        $('.remove-tag').on('click', function(e) {
            e.preventDefault();
            var tagToRemove = $(this).data('tag');
            var currentTags = $('#tags-input').val().split(',');
            var newTags = currentTags.filter(function(tag) {
                return tag !== tagToRemove;
            });
            $('#tags-input').val(newTags.join(','));
            $('#filter-form').submit();
        });
        
        // Tự động submit form khi chọn category hoặc date
        $('.filter-select').on('change', function() {
            $('#filter-form').submit();
        });
    });
</script>
@endsection
