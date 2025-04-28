<h1>Monthly Statistics Report Summary</h1>

<ul>
    <li>Total Posts: {{ $totalPosts }}</li>
    <li>Crawled Posts: {{ $crawledPosts }}</li>
    <li>Total Users: {{ $totalUsers }}</li>
    <li>Total Views: {{ $totalViews }}</li>
</ul>

<h2>Top Posts</h2>
<ul>
    <li>Most Viewed Post: {{ $topViewedPost->title ?? 'N/A' }} ({{ $topViewedPost->viewed_by_users_count ?? 0 }} views)</li>
    <li>Most Liked Post: {{ $topLikedPost->title ?? 'N/A' }} ({{ $topLikedPost->liked_by_users_count ?? 0 }} likes)</li>
    <li>Most Commented Post: {{ $topCommentedPost->title ?? 'N/A' }} ({{ $topCommentedPost->comments_count ?? 0 }} comments)</li>
</ul>

<h2>Top Category</h2>
<ul>
    <li>Category: {{ $topCategory->name ?? 'N/A' }}</li>
    <li>Total Views: {{ $topCategory->total_views ?? 0 }}</li>
</ul>
