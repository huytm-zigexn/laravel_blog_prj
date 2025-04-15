<!-- Followers Modal -->
<div class="modal fade" id="followersModal" tabindex="-1" aria-labelledby="followersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Followers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @forelse($user->followers as $follower)
                    <a href="{{ route('user.show', $follower->id) }}" class="d-flex align-items-center mb-3">
                        @if($follower->avatar)
                            <img src="{{ asset($follower->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; margin-right: 30px">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($follower->name) }}&background=0D8ABC&color=fff&size=50" 
                                style="margin-right: 30px" class="rounded-circle" alt="Avatar">
                        @endif
                        <span>{{ $follower->name }}</span>
                    </a>
                @empty
                    <p>Không có follower nào.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>