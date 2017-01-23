/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
  // Site title and description.
  wp.customize('blogname', function (value) {
    value.bind(function (to) {
      $('.site-title a').text(to);
    });
  });
  wp.customize('blogdescription', function (value) {
    value.bind(function (to) {
      $('#header .tagline').text(to);
    });
  });
  // Customizer colors
  wp.customize('themefurnace_header_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#header').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#header').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_menu_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#cssmenu, #cssmenu ul ul li a').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#cssmenu, #cssmenu ul ul li a').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_menu_background_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#cssmenu, #cssmenu > ul li a:active').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#cssmenu, #cssmenu > ul li a:active').attr(
          'style', 'clip: auto; background: ' + to + '!important; position: relative;'
        );
      }
    });
  });
  wp.customize('themefurnace_header_text_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#header .tagline, #cssmenu ul li a, #cssmenu ul ul li a, .site-title a, #menu-social-items a').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#header .tagline, #cssmenu ul li a, #cssmenu ul ul li a, .site-title a, #menu-social-items a').css({
          'clip': 'auto',
          color: to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_headings_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $(':not(#footer) h1, :not(#footer) h2, :not(#footer) h3, :not(#footer) h4, :not(#footer) h5, :not(#footer) h6').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $(':not(#footer) h1, :not(#footer) h2, :not(#footer) h3, :not(#footer) h4, :not(#footer) h5, :not(#footer) h6').attr(
          'style', 'clip: auto; color: ' + to + ' !important; position: relative'
        );
      }
    });
  });
  wp.customize('themefurnace_footer_headings_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#footer h1, #footer h2, #footer h3, #footer h4, #footer h5, .footer-title > a').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#footer h1, #footer h2, #footer h3, #footer h4, #footer h5, .footer-title > a').attr(
          'style', 'clip: auto; color: ' + to + ' !important; position: relative'
        );
      }
    });
  });


  wp.customize('themefurnace_text_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('body, .tagline').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('body, .tagline').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('text', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('body, .tagline').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('body, .tagline').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('text_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('body, .tagline').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('body, .tagline').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_content_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#posts .container, #content, .masonry > .item, .inside.item').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#posts .container, #content, .masonry > .item, .inside.item').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_link_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('a').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('a').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_footer_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#footer').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#footer').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_footer_text_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#footer, .footertext').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#footer, .footertext').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_topbar_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#topbar').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#topbar').css({
          'clip': 'auto',
          'background-color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_topbar_text_color', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('#topbar').css({
          'clip': 'rect(1px, 1px, 1px, 1px)',
          'position': 'absolute'
        });
      } else {
        $('#topbar p').css({
          'clip': 'auto',
          'color': to,
          'position': 'relative'
        });
      }
    });
  });
  wp.customize('themefurnace_homepage_columns', function (value) {
    value.bind(function (to) {
      if ('blank' === to) {
        $('.masonry').attr('style', '');
      } else {
        $('.masonry').attr('style', 'column-count: ' + to + '; -webkit-column-count: ' + to + '; -moz-column-count: ' + to);
      }
    });
  });
  // Fonts
  wp.customize('themefurnace_google_fonts_body_font', function (value) {
    value.bind(function (to) {
      var font = to.replace(' ', '+');
      WebFontConfig = {
        google: {families: [font + '::latin']}
      };
      (function () {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })();

      // style the text
      if (to == 'none') {
        $('body').attr('style', '');
      }
      else {
        var myVar = setInterval(function () {
          if (typeof WebFont != 'undefined') {
            WebFont.load({
              google: {
                families: [font]
              }
            });
            clearInterval(myVar);
          }
        }, 100);

        $('body, .itemdate, .tagline').attr("style", 'font-family:"' + to + '" !important');
      }

    });
  });
  wp.customize('themefurnace_google_fonts_heading_font', function (value) {
    value.bind(function (to) {
      var font = to.replace(' ', '+');
      WebFontConfig = {
        google: {families: [font + '::latin']}
      };
      (function () {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })();

      // style the text
      if (to == 'none') {
        $('h1,h2,h3,h4,h5,h6').attr("style", '');
      }
      else {
        var myVar = setInterval(function () {
          if (typeof WebFont != 'undefined') {
            WebFont.load({
              google: {
                families: [font]
              }
            });
            clearInterval(myVar);
          }
        }, 100);

        $('h1,h2,h3,h4,h5,h6').attr("style", 'font-family:"' + to + '" !important');
      }


    });
  });
})(jQuery);
