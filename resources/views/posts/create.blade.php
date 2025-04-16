<!-- resources/views/posts/create.blade.php -->
@extends('app')

@section('title', 'Create Post')

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.1.0/tinymce.min.js"></script>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tạo bài viết mới</div>
                    <div class="card-body">
                        <form method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="content">Nội dung</label>
                                <textarea id="content" name="content"></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Lưu bài viết</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- 
@section('scripts')
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'image code link lists table',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | image link | code',
        
        // Cấu hình upload ảnh
        images_upload_url: '{{ route("upload.image") }}',
        images_upload_credentials: true, // Gửi kèm cookie và headers (cần thiết cho CSRF)
        automatic_uploads: true,
        
        // File picker cho việc upload
        file_picker_types: 'image',
        file_picker_callback: function(callback, value, meta) {
            // Tạo input file ẩn
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            
            input.onchange = function() {
                // Khi user chọn file
                var file = this.files[0];
                
                // Đọc file thành base64 để hiển thị preview
                var reader = new FileReader();
                reader.onload = function() {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    
                    // Callback với URL ảnh tạm thời (sẽ được thay thế sau khi upload)
                    callback(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            
            // Mở dialog chọn file
            input.click();
        }
    });
</script>
@endsection --}}