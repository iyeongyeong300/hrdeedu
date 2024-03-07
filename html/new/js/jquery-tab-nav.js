;(function($) {

    $.fn.tabNav = function(options) {

        var settings = $.extend(true, {}, $.fn.tabNav.defaults, options || {}),
            elements = this;

        elements.on('mouseenter focus', 'li > a', function() {
            $(this).parent().addClass(settings.activeClass);
            $(this).addClass(settings.focusClass);
        }).on('mouseleave blur', 'li > a', function() {
            var el = $(this);
            el.removeClass(settings.focusClass);
            setTimeout(function() {
                if (!el.siblings('.' + settings.subMenuClass).hasClass(settings.focusClass)) {
                    el.parent().removeClass(settings.activeClass);
                }
            }, 10);
        }).on('mouseenter focusin', 'li > .' + settings.subMenuClass, function() {
            $(this).addClass(settings.focusClass);
        }).on('mouseleave focusout', 'li > .' + settings.subMenuClass, function() {
            var el = $(this);
            setTimeout(function() {
                if (el.find(':focus').length === 0 ) {
                    el.removeClass(settings.focusClass);
                    if (el.siblings('a.' + settings.focusClass).length === 0 ) {
                        el.parents('li.' + settings.activeClass).eq(0).removeClass(settings.activeClass);
                    }
                }
            }, 10);
        });
    }

    $.fn.tabNav.defaults = {
        subMenuClass: 'sub-menu',
        activeClass: 'active',
        focusClass: 'has-focus',
    };

})(jQuery);
