$(document).keydown(function (event) {
    if (event.which == 17 || event.which == 91) {
        cntrlIsPressed = true;
    }
});

$(document).keyup(function () {
    cntrlIsPressed = false;
});

var cntrlIsPressed = false;

$('.sidebar .sidebar-nav a .sidebar-item').each(function () {
    $(this).click(function () {
        if ($(this).hasClass('side-parent')) {
            if (!$(this).parent().parent().parent().parent().hasClass('show-lg')) {
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).parent().find('.submenu').slideDown('fast')
                } else {
                    $(this).parent().find('.submenu').slideUp('fast');
                }
            }
        } else {
            $(this).addClass('active');
        }
    })
});

$('.submenu .submenu-item').each(function () {
    $(this).click(function (e) {
        e.stopPropagation();
    })
});

// new tab
$('.btn-newtab').each(function () {
    $(this).click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        var urls = $(this).data('link');
        window.open(urls, '_blank')
        $('.link-new').removeClass('show')
    })
})
// new window
$('.btn-copylink').each(function () {
    $(this).click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        var url = $(this).children('#copys').val();
        var tempVal = $('<input>');
        $('body').append(tempVal);
        tempVal.val(url).select();
        document.execCommand('copy');
        tempVal.remove();
        $('.link-new').removeClass('show')
        showSuccess('Link Copied!');
    })
})

$('.side-toggle.slide').click(function () {
    $('aside').toggleClass('show-sm');
    $('aside').removeClass('show-lg');

    if ($('aside').hasClass('show-lg')) {
        let r = $('.sidebar-item');
        r.removeClass('active')
        r.parent().find('.submenu').fadeOut();
        $('aside.show-lg .sidebar .sidebar-nav a .sidebar-item.side-parent').hover(
            function () {
                $(this).addClass('openSub')
            },
            function () {
                $(this).removeClass('openSub')
                $('.subChild').removeClass('opened');
            }
        )
    }
});

$('.side-toggle.shrink').click(function () {
    $('aside').toggleClass('show-lg');
    $('aside').removeClass('show-sm');

    if ($('aside').hasClass('show-lg')) {
        let r = $('.sidebar-item');
        r.removeClass('active')
        r.parent().find('.submenu').fadeOut();
        $('aside.show-lg .sidebar .sidebar-nav a .sidebar-item.side-parent').hover(
            function () {
                $(this).addClass('openSub')
            },
            function () {
                $(this).removeClass('openSub')
                $('.subChild').removeClass('opened');
            }
        )
    }
});

$('.sidebar .sidebar-nav a.has-parent').each(function () {
    $(this).on('taphold', function (e) {
        e.preventDefault();
    })
    $(this).on('contextmenu', function (ev) {
        ev.preventDefault()
    })
})
$('.sub-item').each(function () {
    $(this).on('contextmenu', function (e) {
        e.preventDefault();
        e.stopPropagation()
        if ($(this).children('.link-new').hasClass('show')) {
            $(this).children('.link-new').removeClass('show');
        } else {
            $(this).siblings().children('.link-new').removeClass('show')
            $(this).children('.link-new').addClass('show');
        }
        var pos = $(this).position();
        $('.link-new.show').css('top', pos.top + 15)
        $('.link-new.show').css('left', pos.left + 35);
    })
})
$('.sub-item:not(.haveSub)').each(function () {
    $(this).on('click', function (evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();
        if (cntrlIsPressed) {
            window.open($(this).attr('link'), '_blank')
        } else {
            window.location.href = $(this).attr('link');
        }
    })
})
$('.sidebar .sidebar-nav a.no-parent').each(function () {
    $(this).on('click', function (evt) {
        evt.preventDefault();
        evt.stopImmediatePropagation();
        if (evt.ctrlKey) {
            window.open($(this).attr('href'), '_blank')
        } else {
            window.location.href = $(this).attr('href')
        }
    })
})


// Nested Sidebar
$('.sub-item.haveSub').each(function () {
    $(this).click(function (e) {
        e.preventDefault()
        e.stopPropagation();
        let ch = $(this).children('.childSub');
        if (ch.hasClass('active')) {
            ch.removeClass('active');
            ch.slideUp('fast');
        } else {
            ch.addClass('active')
            ch.slideDown('fast');
        }
        $(this).children().children('.navicon').toggleClass('open')
    })
})
// Show LG nested sidebar
$('.haveChild').each(function () {
    $(this).hover(
        function () {
            let pr = $(this).next('#listSub').children('.subChild');
            console.log(pr);
            if (pr.hasClass('opened')) {
                pr.removeClass('opened');
            } else {
                pr.addClass('opened');
            }
        },
        function () {
            // release
        }
    )
})