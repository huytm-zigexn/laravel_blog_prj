<!-- Followings Modal -->
<div class="modal fade" id="followingsModal" tabindex="-1" aria-labelledby="followingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Following</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @forelse($user->followings as $following)
                    <a href="{{ route('user.show', $following->id) }}" class="d-flex align-items-center mb-3">
                        @if($following->avatar)
                            <img src="{{ asset($following->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; margin-right: 30px">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($following->name) }}&background=0D8ABC&color=fff&size=50" 
                                class="rounded-circle" alt="Avatar" style="margin-right: 30px">
                        @endif
                        <span>{{ $following->name }}</span>
                    </a>
                @empty
                    <p>Không đang theo dõi ai.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>