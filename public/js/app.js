document.addEventListener('DOMContentLoaded', function () {
    const notiBtn = document.querySelector('.nav-noti');
    const notiContainer = document.querySelector('.noti-container');

    notiBtn.addEventListener('click', function (e) {
        e.preventDefault(); // ngăn chuyển trang nếu href="#"
        notiContainer.style.display = 
            (notiContainer.style.display === 'none' || notiContainer.style.display === '') 
                ? 'block' 
                : 'none';
    });

    // Optional: Ẩn khi click bên ngoài
    document.addEventListener('click', function (e) {
        if (!notiBtn.contains(e.target) && !notiContainer.contains(e.target)) {
            notiContainer.style.display = 'none';
        }
    });
});
