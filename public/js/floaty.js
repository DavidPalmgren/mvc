$(document).ready(function() {
    $('#floating-container').hover(function() {
        var x = Math.random() * ($(window).width() - $(this).width());
        var y = Math.random() * ($(window).height() - $(this).height());
        $(this).css({
            'position': 'absolute',
            'left': x + 'px',
            'top': y + 'px'
        });
    });
});