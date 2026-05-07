$(function () {
    const $form = $('#filterForm');
    const $list = $('#blogList');
    let requestTimer;

    function loadBlogs() {
        $.ajax({
            url: 'ajax/filter_blogs.php',
            method: 'GET',
            data: $form.serialize(),
            beforeSend: function () {
                $list.html('<div class="empty">Loading blogs...</div>');
            },
            success: function (response) {
                $list.html(response);
            },
            error: function () {
                $list.html('<div class="empty">Unable to load blogs. Please try again.</div>');
            }
        });
    }

    $form.on('submit', function (event) {
        event.preventDefault();
        loadBlogs();
    });

    $form.on('input change', 'input, select', function () {
        clearTimeout(requestTimer);
        requestTimer = setTimeout(loadBlogs, 250);
    });

    $('#resetFilters').on('click', function () {
        $form[0].reset();
        loadBlogs();
    });
});
