/**
 * Functionality specific to Steakhouse.
 **/

// Google maps function
var gkMapInitialize = function() {
  var maps = jQuery('.gk-map');
  var mapCenters = [];
  var mapAreas = [];

  maps.each(function(i, map) {
    map = jQuery(map);
    mapCenters[i] = new google.maps.LatLng(0.0, 0.0);


    if(map.data('latitude') !== undefined && map.data('longitude') !== undefined) {
        mapCenters[i] = new google.maps.LatLng(
                    parseFloat(map.data('latitude')),
                    parseFloat(map.data('longitude'))
                );
    }

      var mapOptions = {
        zoom: parseInt(map.data('zoom'), 10) || 12,
        center: mapCenters[i],
        panControl: map.data('ui') === 'yes' ? true : false,
        zoomControl: map.data('ui') === 'yes' ? true : false,
        scaleControl: map.data('ui') === 'yes' ? true : false,
        disableDefaultUI: map.data('ui') === 'yes' ? false : true,
        mapTypeControl: map.data('ui') === 'yes' ? true : false,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_CENTER
        }
      };

      mapAreas[i] = new google.maps.Map(map.get(0), mapOptions);
      var link = jQuery('<a>', { class: 'gk-map-close'});
      link.insertAfter(map);
      // custom events for the full-screen display
      var marker = null;
      map.on('displaybigmap', function() {
        marker = new google.maps.Marker({
           position: mapCenters[i],
           map: mapAreas[i],
           animation: google.maps.Animation.DROP
        });

        setTimeout(function() {
            google.maps.event.trigger(mapAreas[i], 'resize');
        }, 300);

        mapAreas[i].setCenter(mapCenters[i]);
      });

      if(jQuery(maps[i]).hasClass('static')) {
        marker = new google.maps.Marker({
           position: mapCenters[i],
           map: mapAreas[i],
           animation: google.maps.Animation.DROP
        });
      }

      map.on('hidebigmap', function() {
        if(marker) {
            marker.setMap(null);
        }
      });
  });

  jQuery(window).resize(function() {
    jQuery.each(mapAreas, function(i, map) {
        map.setCenter(mapCenters[i]);
    });
  });
};

(function($) {
    $(document).ready(function(){
        // smooth anchor scrolling
        jQuery('a[href*="#"]').on('click', function (e) {
            e.preventDefault();

            if(this.hash !== '' && this.href.replace(this.hash, '') == window.location.href.replace(window.location.hash, '')) {
                var target = jQuery(this.hash);

                if(target.length) {
                    jQuery('html, body').stop().animate({
                        'scrollTop': target.offset().top
                    }, 1000, 'swing', function () {
                        window.location.hash = target.selector;
                    });
                } else {
                    window.location = jQuery(this).attr('href');
                }
            } else {
                window.location = jQuery(this).attr('href');
            }
        });

        // Fit videos
        $(".video-wrapper").fitVids();

        // Scroll effects
        var frontpage_header = jQuery('#gk-header');
        var frontpage_module = jQuery('#gk-header-mod');

        if(
            jQuery('body').hasClass('frontpage') &&
            frontpage_header &&
            jQuery(window).width() > 720
        ) {
            jQuery(window).scroll(function() {
                var win_scroll = jQuery(window).scrollTop();
                var header_height = frontpage_header.height();

                if(win_scroll < header_height) {
                    animate_header(win_scroll, header_height);
                }
            });

            var animate_header = function(win_scroll, header_height) {
                var result = (win_scroll / header_height) * 0.75;
                frontpage_module.css('background', 'rgba(0, 0, 0, ' + (result) + ')');
            };
        }

        // Google Maps loading
        var loadScript = function() {
            $.getScript("https://maps.googleapis.com/maps/api/js?v=3.exp&callback=gkMapInitialize")
              .fail(function( jqxhr, settings, exception ) {
               console.log('Google Maps script not loaded');
            });
        };

        if($('.gk-map').length > 0) {
            loadScript();
        }

        // Locate effect
        var locate_buttons = $('.gk-locate');

        locate_buttons.each(function(i, button) {
            button = $(button);
            var wrapper = button.parents('.frontpage-block-wrap');

            if(!wrapper.length) {
                wrapper = button.parents('.widget-wrap');
            }

            button.click(function(e) {
                e.preventDefault();

                wrapper.find('.header').addClass('hide');
                wrapper.find('.gk-over-map').addClass('hide');
                wrapper.addClass('hide');

                var map = wrapper.find('.gk-map');
                var coordinates = map.offset();
                var scroll = $(window).scrollTop();
                var top_margin = (-1 * (coordinates.top - scroll));
                var bottom_margin = (-1 * ($(window).height() - (coordinates.top + map.height() - scroll)));

                setTimeout(function() {
                    map.css('z-index', '1000000');
                    map.css({
                        'height': $(window).height() + "px",
                        'margin-top': top_margin + "px",
                        'margin-bottom': bottom_margin + "px"
                    });

                    map.trigger('displaybigmap');

                    setTimeout(function() {
                        var close_button = wrapper.find('.gk-map-close');
                        close_button.addClass('active');

                        if(!close_button.hasClass('has-events')) {
                            close_button.click(function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                map.css({
                                    'height': wrapper.outerHeight() + "px",
                                    'margin-top': "0px",
                                    'margin-bottom': "0px"
                                });

                                close_button.removeClass('active');

                                setTimeout(function() {
                                    map.css('z-index', '0');
                                    map.trigger('hidebigmap');

                                    setTimeout(function() {
                                        wrapper.removeClass('hide');
                                    }, 50);

                                    setTimeout(function() {
                                        wrapper.find('.header').removeClass('hide');
                                        wrapper.find('.gk-over-map').removeClass('hide');
                                    }, 300);
                                }, 300);
                            });
                            close_button.addClass('has-events');
                        }
                    }, 500);
                }, 500);
            });
        });

        // Testimonials
        var testimonials = $('.gk-testimonials');

        if(testimonials.length > 0) {
            testimonials.each(function(i, wrapper) {
                wrapper = $(wrapper);
                var amount = wrapper.data('amount');

                var testimonial_prev = $('<a>', { class: 'gk-testimonials-prev' });
                var testimonial_next = $('<a>', { class: 'gk-testimonials-next' });
                var testimonial_pagination = $('<ul>', { class: 'gk-testimonials-pagination' });

                var quotes = wrapper.find('blockquote');
                var current_page = 0;
                var sliding_wrapper = wrapper.find('div div');

                for(var j = 0; j < amount; j++) {
                    var titem = '<li' + (j === 0 ? ' class="active"' : '') + '>' + (j+1) + '</li>';
                    testimonial_pagination.html(testimonial_pagination.html() + titem);
                }

                testimonial_prev.appendTo(wrapper);
                testimonial_next.appendTo(wrapper);
                testimonial_pagination.appendTo(wrapper);
                var pages = testimonial_pagination.find('li');
                // hide quotes
                quotes.each(function(i, quote) {
                    if(i > 0) {
                        $(quote).addClass('hidden');
                    }
                });
                // navigation
                testimonial_prev.click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    $(quotes[current_page]).addClass('hidden');
                    current_page = (current_page > 0) ? current_page - 1 : pages.length - 1;
                    $(quotes[current_page]).removeClass('hidden');
                    pages.removeClass('active');
                    $(pages[current_page]).addClass('active');
                    sliding_wrapper.css('margin-left', -1 * (current_page * 100) + "%");
                });

                testimonial_next.click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    $(quotes[current_page]).addClass('hidden');
                    current_page = (current_page < pages.length - 1) ? current_page + 1 : 0;
                    $(quotes[current_page]).removeClass('hidden');
                    pages.removeClass('active');
                    $(pages[current_page]).addClass('active');
                    sliding_wrapper.css('margin-left', -1 * (current_page * 100) + "%");
                });

                pages.each(function(i, page) {
                    page = $(page);
                    page.click(function() {
                        quotes[current_page].addClass('hidden');
                        current_page = i;
                        $(quotes[current_page]).removeClass('hidden');
                        pages.removeClass('active');
                        $(pages[current_page]).addClass('active');
                        sliding_wrapper.css('margin-left', -1 * (current_page * 100) + "%");
                    });
                });
            });
        }

        // Forms validation
        var contact_forms = $(document).find('.gk-contact-form');
        var reservation_forms = $(document).find('.gk-reservation-form');

        var forms = [
                        contact_forms,
                        reservation_forms
                    ];

        if(contact_forms || reservation_forms) {
            $(forms).each(function(i, set) {
                $(set).each(function(i, form) {
                    var inputs = $(form).find('.gk-required');
                    var submit = $(form).find('.gk-submit');

                    $(inputs).each(function(i, input) {
                        $(input).focus(function() {
                            if($(input).hasClass('invalid-input')) {
                                $(input).removeClass('invalid-input');
                            }
                        });
                    });

                    submit.click(function(e) {
                        e.preventDefault();

                        var valid = true;

                        $(inputs).each(function(i, input) {
                            if($(input).val() === '') {
                                valid = false;
                                $(input).addClass('invalid-input');
                            }
                        });

                        if(valid) {
                            if(submit.parent().parent().prop('tagName') == 'FORM') {
                                submit.parent().parent().submit();
                            } else {
                                submit.parent().submit();
                            }
                        }
                    });
                });
            });
        }

        // Gallery popups
        var photos = jQuery('.gk-photo');

        if(photos.length > 0) {
            // photos collection
            var collection = [];
            // create overlay elements
            var overlay = jQuery('<div>', { class: 'gk-photo-overlay' });
            var overlay_prev = jQuery('<a>', { class: 'gk-photo-overlay-prev' });
            var overlay_next = jQuery('<a>', { class: 'gk-photo-overlay-next' });
            // put the element
            overlay.appendTo(jQuery('body'));
            // add events
            overlay.click(function() {
                var img = overlay.find('img');
                if(img) { img.remove(); }
                overlay.removeClass('active');
                overlay_prev.removeClass('active');
                overlay_next.removeClass('active');
                setTimeout(function() {
                    overlay.css('display', 'none');
                }, 300);
            });
            // prepare links
            photos.each(function(j, photo) {
                photo = jQuery(photo);
                var link = photo.find('a');
                collection.push(link.attr('href'));
                link.click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    overlay.css('display', 'block');

                    setTimeout(function() {
                        overlay.addClass('active');

                        setTimeout(function() {
                            overlay_prev.addClass('active');
                            overlay_next.addClass('active');
                        }, 300);

                        var img = jQuery('<img>', { class: 'loading' });
                        img.load(function() {
                            img.removeClass('loading');
                        });
                        img.attr('src', link.attr('href'));
                        img.prependTo(overlay);
                    }, 50);
                });
            });
            // if collection is bigger than one photo
            if(collection.length > 1) {
                overlay_prev.appendTo(overlay);
                overlay_next.appendTo(overlay);

                overlay_prev.click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var img = overlay.find('img');
                    if(!img.hasClass('loading')) {
                        img.addClass('loading');
                    }
                    setTimeout(function() {
                        var current_img = img.attr('src');
                        var id = collection.indexOf(current_img);
                        var new_img = collection[(id > 0) ? id - 1 : collection.length - 1];
                        img.attr('src', new_img);
                    }, 300);
                });

                overlay_next.click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var img = overlay.find('img');
                    if(!img.hasClass('loading')) {
                        img.addClass('loading');
                    }
                    setTimeout(function() {
                        var current_img = img.attr('src');
                        var id = collection.indexOf(current_img);
                        var new_img = collection[(id < collection.length - 1) ? id + 1 : 0];
                        img.attr('src', new_img);
                    }, 300);
                });
            }
        }

        // Main menu
        var menu_ID = false;

        if ($('#gk-header-nav .nav-menu').length) {
            menu_ID = '#gk-header-nav .nav-menu';
        }

        if (menu_ID) {
            // fix for the iOS devices
            $(menu_ID + ' li').each(function (i, el) {

                if ($(el).children('.sub-menu').length > 0) {
                    $(el).addClass('haschild');
                }
            });
            // main element for the iOS fix - adding the onmouseover attribute
            // and binding with the data-dblclick property to emulate dblclick event on
            // the mobile devices
            $(menu_ID + ' li a').each(function (i, el) {
                el = $(el);

                el.attr('onmouseover', '');

                if (el.parent().hasClass('haschild') && $(document.body).attr('data-tablet') !== null) {
                    el.click(function (e) {
                        if (el.attr("data-dblclick") === undefined) {
                            e.stop();
                            el.attr("data-dblclick", new Date().getTime());
                        } else {
                            var now = new Date().getTime();
                            if (now - el.attr("data-dblclick") < 500) {
                                window.location = el.attr('href');
                            } else {
                                e.stop();
                                el.attr("data-dblclick", new Date().getTime());
                            }
                        }
                    });
                }
            });
            // main menu element handler
            var base = $(menu_ID);
            // if the main menu exists
            if (base.length > 0) {
                base.find('li.haschild').each(function (i, el) {
                    el = $(el);

                    if (el.children('.sub-menu').length > 0) {
                        var content = $(el.children('.sub-menu').first());
                        var prevh = content.outerHeight();
                        var prevw = content.outerWidth();
                        var duration = 250;

                        var fxStart = {
                            'height': 0,
                            'width': prevw,
                            'opacity': 0
                        };
                        var fxEnd = {
                            'height': prevh,
                            'width': prevw,
                            'opacity': 1
                        };

                        content.css(fxStart);
                        content.css({
                            'left': 'auto',
                            'overflow': 'hidden'
                        });

                        el.mouseenter(function () {
                            content.css('display', 'block');

                            if (content.attr('data-base-margin') !== null) {
                                content.css({
                                    'margin-left': content.attr('data-base-margin') + "px"
                                });
                            }

                            var pos = content.offset();
                            var winWidth = $(window).outerWidth();
                            var winScroll = $(window).scrollLeft();

                            if (pos.left + prevw > (winWidth + winScroll)) {
                                var diff = (winWidth + winScroll) - (pos.left + prevw) - 5;
                                var base = parseInt(content.css('margin-left'), 10);
                                var margin = base + diff;

                                if (base > 0) {
                                    margin = -prevw + 10;
                                }
                                content.css('margin-left', margin + "px");

                                if (content.attr('data-base-margin') === null) {
                                    content.attr('data-base-margin', base);
                                }
                            }
                            //
                            content.stop(false, false, false);

                            content.animate(
                                fxEnd,
                                duration,
                                function () {
                                    if (content.outerHeight() === 0) {
                                        content.css('overflow', 'hidden');
                                    } else if (
                                        content.outerHeight() - prevh < 30 &&
                                        content.outerHeight() - prevh >= 0
                                    ) {
                                        content.css('overflow', 'visible');
                                    }
                                }
                            );
                        });
                        el.mouseleave(function () {
                            content.css({
                                'overflow': 'hidden'
                            });
                            //
                            content.animate(
                                fxStart,
                                duration,
                                function () {
                                    if (content.outerHeight() === 0) {
                                        content.css('overflow', 'hidden');
                                    } else if (
                                        content.outerHeight() - prevh < 30 &&
                                        content.outerHeight() - prevh >= 0
                                    ) {
                                        content.css('overflow', 'visible');
                                    }

                                    content.css('display', 'none');
                                }
                            );
                        });
                    }
                });

                base.find('li.haschild').each(function (i, el) {
                    el = $(el);
                    var content = $(el.children('.sub-menu').first());
                    content.css({
                        'display': 'none'
                    });
                });
            }
        }

        // Aside menu
        var toggler = $('#aside-menu-toggler');

        toggler.click(function() {
            gkOpenAsideMenu();
        });

        $('#close-menu').click(function() {
            $('#close-menu').toggleClass('menu-open');
            $('#gk-bg').toggleClass('menu-open');
            $('#aside-menu').toggleClass('menu-open');
        });

        // detect android browser
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1 && !window.chrome;

        if(isAndroid) {
            $(document.body).addClass('android-stock-browser');
        }
        // Android stock browser fix for the aside menu
        if($(document.body).hasClass('android-stock-browser') && $('#aside-menu').length) {
            $('#aside-menu-toggler').click(function() {
                window.scrollTo(0, 0);
            });
            // menu dimensions
            var asideMenu = $('#aside-menu');
            var menuHeight = $('#aside-menu').outerHeight();
            //
            window.scroll(function() {
                if(asideMenu.hasClass('menu-open')) {
                    // get the necessary values and positions
                    var currentPosition = $(window).scrollTop();
                    var windowHeight = $(window).height();

                    // compare the values
                    if(currentPosition > menuHeight - windowHeight) {
                        $('#close-menu').trigger('click');
                    }
                }
            });
        }
    });

    function gkOpenAsideMenu() {
        $('#gk-bg').toggleClass('menu-open');
        $('#aside-menu').toggleClass('menu-open');

        if(!$('#close-menu').hasClass('menu-open')) {
            setTimeout(function() {
                $('#close-menu').toggleClass('menu-open');
            }, 300);
        } else {
            $('#close-menu').removeClass('menu-open');
        }
    }

    if($('#gk-header-nav') && !$('#gk-header-nav').hasClass('active')) {
        var currentPosition = $(window).scrollTop();

        if(
            currentPosition >= $('#gk-header').outerHeight() &&
            !$('#gk-header-nav').hasClass('active')
        ) {
            $('#gk-header-nav').addClass('active');
        } else if(
            currentPosition < $('#gk-header').outerHeight() &&
            $('#gk-header-nav').hasClass('active')
        ) {
            $('#gk-header-nav').removeClass('active');
        }

        $(window).scroll(function() {
            var currentPosition = $(window).scrollTop();

            if(
                currentPosition >= $('#gk-header').outerHeight() &&
                !$('#gk-header-nav').hasClass('active')
            ) {
                $('#gk-header-nav').addClass('active');
            } else if(
                currentPosition < $('#gk-header').outerHeight() &&
                $('#gk-header-nav').hasClass('active')
            ) {
                $('#gk-header-nav').removeClass('active');
            }
        });
    }
})(jQuery);