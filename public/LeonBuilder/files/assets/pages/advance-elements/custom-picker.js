"use strict";
$(document).ready(function(){


// Color picker js start
function change_checkbox_color() {
    $('.color-box .show-box').on('click', function() {
        $(".color-box").toggleClass("open");
    });

    $('.colors-list a').on('click', function() {
        var curr_color = $('main').data('checkbox-color');
        var color = $(this).data('checkbox-color');
        var new_colot = 'checkbox-' + color;

        $('.rkmd-checkbox .input-checkbox').each(function(i, v) {
            var findColor = $(this).hasClass(curr_color);

            if (findColor) {
                $(this).removeClass(curr_color);
                $(this).addClass(new_colot);
            }

            $('main').data('checkbox-color', new_colot);

        });
    });
}
// Color picker
$("#custom").spectrum({
    color: "#f00"
});
$("#flat").spectrum({
    flat: true,
    showInput: true
});
$("#flatClearable").spectrum({
    flat: true,
    showInput: true,
    allowEmpty: true
});
// Color picker js end

// Mini-color js start

// Mini-color js ends
});