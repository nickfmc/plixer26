(function($) {
    console.log('admin-script.js is loaded');
    var ajaxTimeout = null;

    $(document).on('change', '.acf-field[data-key="field_655e393647c55"] input', function() {
        console.log('ACF field changed');
        var checkbox = $(this);
        checkbox.prop('disabled', true); // Disable the checkbox
        clearTimeout(ajaxTimeout); // Cancel the previous timeout
        var post_id = acf.get('post_id');
        var field_value = checkbox.is(':checked') ? 'true' : 'false';
        ajaxTimeout = setTimeout(function() {
            $.post('/wp-json/myplugin/v1/dark_page/' + post_id, {value: field_value}, function(response) {
                console.log('Field value updated:', response);
                $.get('/wp-json/myplugin/v1/dark_page/' + post_id, function(dark_page) {
                    console.log('AJAX response:', dark_page);
                    dark_page = String(dark_page); // Convert dark_page to a string
                    if (dark_page === 'true') {
                        console.log('Adding dark-admin class');
                        $('body').addClass('dark-admin');
                    } else if (dark_page === 'false') {
                        console.log('Removing dark-admin class');
                        $('body').removeClass('dark-admin');
                    }
                    checkbox.prop('disabled', false); // Re-enable the checkbox
                });
            });
        }, 3000); // Wait 5 seconds before sending the AJAX request
    });
})(jQuery);

(function($) {
    console.log('admin-script.js is loaded');

    $(document).on('change', '.acf-field[data-key="field_655e393647c55"] input', function() {
        console.log('ACF field changed');
        $.get('/wp-json/myplugin/v1/dark_page/' + acf.get('post_id'), function(dark_page) {
            console.log('AJAX response:', dark_page);
            dark_page = String(dark_page); // Convert dark_page to a string
            if (dark_page === 'false') {
                console.log('Adding dark-admin class');
                $('body').addClass('dark-admin');
            } else if (dark_page === 'true') {
                console.log('Removing dark-admin class');
                $('body').removeClass('dark-admin');
            }
        });
    });
})(jQuery);