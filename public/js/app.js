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

document.addEventListener('DOMContentLoaded', function () {
    const postWrappers = document.querySelectorAll('.post-wrapper');

    postWrappers.forEach(wrapper => {
        const notiBtn = wrapper.querySelector('.postED');
        const notiContainer = wrapper.querySelector('.postED-container');

        notiBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Toggle hiển thị container này, ẩn các container khác
            document.querySelectorAll('.postED-container').forEach(container => {
                if (container !== notiContainer) {
                    container.style.display = 'none';
                }
            });

            notiContainer.style.display =
                (notiContainer.style.display === 'none' || notiContainer.style.display === '')
                    ? 'block'
                    : 'none';
        });

        // Ẩn khi click bên ngoài
        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target)) {
                notiContainer.style.display = 'none';
            }
        });
    });
});

