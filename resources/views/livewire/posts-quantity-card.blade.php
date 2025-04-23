<div class="col-xl-4 col-md-6" wire:poll.5s>
    <div class="card shadow-sm bg-primary text-white mb-4">
        <div class="card-body">
            <h5 class="card-title" style="font-weight: 400; font-size: 20px">Total Posts</h5>
            <p class="card-text" style="font-size: 24px; font-weight: bold">{{ $postsQuantity }}</p>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.posts.index') }}" class="small text-white stretched-link">View Details</a>
            <div class="small text-white"><i class="fas fa-arrow-right"></i></div>
        </div>
    </div>
</div>
