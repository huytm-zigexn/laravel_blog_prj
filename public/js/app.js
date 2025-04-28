$(document).ready(function () {
    const $notiBtn = $('.nav-noti');
    const $notiContainer = $('.noti-container');

    $notiBtn.on('click', function (e) {
        e.preventDefault();
        $notiContainer.toggle(); // toggle giữa show/hide
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.nav-noti, .noti-container').length) {
            $notiContainer.hide();
        }
    });
});

$(document).ready(function () {
    const $postWrappers = $('.post-wrapper');

    $postWrappers.each(function () {
        const $wrapper = $(this);
        const $notiBtn = $wrapper.find('.postED');
        const $notiContainer = $wrapper.find('.postED-container');

        $notiBtn.on('click', function (e) {
            e.preventDefault();

            // Ẩn tất cả các container khác
            $('.postED-container').not($notiContainer).hide();

            // Toggle cái container đang bấm
            $notiContainer.toggle();
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest($wrapper).length) {
                $notiContainer.hide();
            }
        });
    });
});
