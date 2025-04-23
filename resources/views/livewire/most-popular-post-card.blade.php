<div class="col-xl-4 col-md-6" wire:poll.300s>
    <div class="card shadow-sm bg-success text-white mb-4">
        <div class="card-body">
            <h5 class="card-title" style="font-weight: 400; font-size: 20px">The most popular post</h5>
            <p class="card-text" style="font-size: 24px; font-weight: bold">{{ $mostPopularPost->title }}</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.posts.show', $mostPopularPost->slug) }}" class="small text-white stretched-link">View Details</a>
            <div class="small text-white"><i class="fas fa-arrow-right"></i></div>
        </div>
    </div>
</div>