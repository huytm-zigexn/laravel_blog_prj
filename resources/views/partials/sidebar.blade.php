<div class="h-100 w-100 text-white p-3" style="background-color: #080c50">
    <h4 style="color: #fff; font-size: 20px; font-weight: bold" class="text-center">Admin Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link text-white {{ request()->routeIs('users.index', 'users.edit', 'users.show') ? 'fw-bold' : '' }}"><i class="bi bi-person"></i> User Management</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.posts.index') }}" class="nav-link text-white {{ request()->routeIs('admin.posts.index', 'admin.posts.create', 'admin.posts.edit', 'admin.posts.show') ? 'fw-bold' : '' }}"><i class="bi bi-file-earmark-text"></i> Post Management</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link text-white {{ request()->routeIs('categories.index') ? 'fw-bold' : '' }}"><i class="bi bi-folder"></i> Category Management</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold' : '' }}"><i class="bi bi-tags"></i> Tag Management</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold' : '' }}"><i class="bi bi-chat-dots"></i> Comment Management</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'fw-bold' : '' }}"><i class="bi bi-bar-chart"></i> Statistics</a>
        </li>
    </ul>
</div>

<style>
    .admin-sidebar {
        min-height: 100vh;
    }
    @media (max-width: 768px) {
        .admin-sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            height: 100%;
            z-index: 999;
            transition: left 0.3s;
        }
        .admin-sidebar.show {
            left: 0;
            background-color: #343a40;
        }
    }
</style>
