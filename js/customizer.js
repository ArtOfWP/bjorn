/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
  var header_position_small,header_position_medium, header_position_large;
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
  wp.customize( 'header_x_position_small', function( value ) {
    value.bind( function( to ) {
      var window_width = $( window ).width();
      header_position_small=to;
      if(window_width<600) {
        $('.hero.without-featured-image').css({'background-position-x': to});
      } else {
        $('.hero.without-featured-image').css({'background-position-x': 0});
      }
    } );
  } );
  wp.customize( 'header_x_position_medium', function( value ) {
    value.bind( function( to ) {
      var window_width = $( window ).width();
      header_position_medium=to;
      if(600<=window_width<768) {
        $('.hero.without-featured-image').css({'background-position-x': to});
      }
    } );
  } );
  wp.customize( 'header_x_position_large', function( value ) {
    value.bind( function( to ) {
      var window_width = $( window ).width();
      header_position_large=to;
      if(768<=window_width<1020) {
        $('.hero.without-featured-image').css({'background-position-x': to});
      }
    } );
  } );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
	// Header color.
  var header_color;
	wp.customize( 'header_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-header' ).css( {
          background: 'rgba(0, 0, 0, 0.225)'
				} );
			} else {
        var window_width = $( window ).width();
        header_color=to;
        if(window_width<1020) {
          $('.site-header').css({
            'background': to
          });
        }
			}
		} );
	} );

  $( window ).resize( function(){
    var window_width = $( window ).width();
    if(window_width<1300) {
      $('.site-header').css({
        'background-color': header_color
      });
    } else {
      $('.site-header').css({
        background: 'rgba(0, 0, 0, 0.225)'
      });
    }
    if(window_width<600) {
      $('.hero.without-featured-image').css({'background-position-x': header_position_small});
    } else if(600<=window_width<768) {
      $('.hero.without-featured-image').css({'background-position-x': header_position_medium});
    } else if(768<=window_width<1020) {
      $('.hero.without-featured-image').css({'background-position-x': header_position_large});
    } else if(window_width>1020) {
      $('.hero.without-featured-image').css({'background-position-x': 0});
    } else {
      $('.hero.without-featured-image').css({'background-position': '50% 50%'});
    }

  } );

  // Link color.
  wp.customize( 'link_color', function( value ) {
    value.bind( function( to ) {
      if ( 'blank' === to ) {
        $( 'a[class!="more-link"] a[class!="button"]' ).css( {
          color: '#e74f4e'
        } );
      } else {
        $( '.featured-page-area a:not(.more-link,.button)' ).css( {
          'color': to
        } );
      }
    } );
  } );

  // Site logo.
  wp.customize( 'site_logo_small', function( value ){
    value.bind( function( newVal, oldVal ){
      if ( newVal && newVal.url ) {
        $( '.site-title' ).css( {
          'margin-top' : -20,
          'min-height' : 0
        } );
      } else {
        $( '.site-title' ).css( {
          'margin-top' : 30,
          'min-height' : 60
        } );
      }
    } );
  } );

  // Sidebar position.
	wp.customize( 'edin_sidebar_position', function( value ) {
		value.bind( function( to ) {
			if ( 'left' === to ) {
				$( 'body' ).removeClass( 'sidebar-right' ).addClass( 'sidebar-left' );
			} else {
				$( 'body' ).removeClass( 'sidebar-left' ).addClass( 'sidebar-right' );
			}
		} );
	} );
} )( jQuery );
