'use strict';


/*--------------------------------------------------------------
 -     VARIABLES
 -     FUNCTIONS

 1     MAIN
 2     ENABLE POINTER EVENTS
 3     REMOVE REPLY COUNTER MARGINS
 4     MAKE MESSAGES WITH YOUTUBE WIDTH 100
 5     MOVE reply-counter to column-3 when there's no admin links

 #     LET'S START THE GAME!
--------------------------------------------------------------*/




/*=====================================
  -     VARIABLES
 =====================================*/


const thisisyyz_someMagicalNumber = 36,   // Line height?
      thisisyyz_mainMediumMaxWidth = 709;

let thisisyyz_timeoutID1,

    thisisyyz_replyCounterColumn;


/*=====================================
  -     FUNCTIONS
 =====================================*/


function thisisyyz_doTreatAsTextElem(that) {
    let $that = jQuery(that);

    if ( that.nodeType === Node.TEXT_NODE ||
        $that.is( 'br' )        ||
        $that.is( 'strong' )    ||
        $that.is( 'em' )        ||
        $that.is( 'del' )       ||
        $that.is( 'a' )         ||
        $that.is( 'img.emoji' )
    ) {
        return true;
    }
}


/*=================================================================================================================
   1     MAIN
 =====================================*/



function thisisyyz_main( earlyState ) {


    /* SETUP BUBBLE SIZE */


    jQuery( ".thisisyyz__message" ).each(function() {

        let $message = jQuery(this),

            messagePaddingTop,
            messagePaddingBottom,
            messagePaddingLeft   = parseInt( $message.css( 'padding-left'   ) ),
            messagePaddingRight  = parseInt( $message.css( 'padding-right'  ) ),

            messageVerticalPadding,
            messageHorizontalPadding = messagePaddingLeft + messagePaddingRight,


            $text = jQuery( '.thisisyyz__message__text', this ),

            $bubble = jQuery( '.thisisyyz__message__bubble', this );



        /**
         * Makes $texts which contains only a string display:inline
         */

        let isInline = true;
        $text.children().each(function() {
                let $contents = jQuery(this).contents();

                // Twitter-Widget with #shadow-root has length 0
                if ( $contents.length ) {
                    $contents.each(function() {
                        if ( ! thisisyyz_doTreatAsTextElem(this) ) {
                            isInline = false;
                            return false;
                        }
                    });
                }

                if ( ! isInline ) {
                    return false;
                }
        });
        if ( isInline ) {
            $text.css( 'display', 'inline' );
        }


        /**
         * Removes padding-top if the first element of the first element is text;
         * and  padding-bottom if the first element of the last  element is text too.
         */


        if ( earlyState ) {
            messagePaddingTop = 0;
            $message.css('padding-top', 0);

            messagePaddingBottom = 0;
            $message.css('padding-bottom', 0);
        } else {

            let $firstElem = $text.children().first(),
                $firstContentOfFirstElem = $firstElem.contents().length ? $firstElem.contents().first() : false;

            if ( $firstContentOfFirstElem && thisisyyz_doTreatAsTextElem( $firstContentOfFirstElem[0] ) ) {
                messagePaddingTop = 0;
            } else {
                $message.css('padding-top', '');
                messagePaddingTop =  parseInt( $message.css( 'padding-top' ) );
            }


            let $lastElem = $text.children().last(),
                $lastContentOfLastElem = $lastElem.contents().length ? $lastElem.contents().last() : false;

            if ( $lastContentOfLastElem && thisisyyz_doTreatAsTextElem( $lastContentOfLastElem[0] ) ) {
                messagePaddingBottom = 0;
            } else {
                $message.css('padding-bottom', '');
                messagePaddingBottom =  parseInt( $message.css( 'padding-bottom' ) );
            }


            /*  3 REMOVE REPLY COUNTER MARGINS */

            thisisyyz_removeReplyCounterMargins( $bubble, $message );
        }


        messageVerticalPadding = messagePaddingTop  + messagePaddingBottom;


        function roundByBase( number, base ) {
            let c = Math.round( number / base );
            // Never returns zero
            return c ? base * c : base;
        }


        // Setups the size
        $bubble.width( $text.width() + messageHorizontalPadding )
                            .height( ( $text.css('display') === 'block' ) ?
                                ( $text.height() + messageVerticalPadding ) :
                                roundByBase( $text.height(), thisisyyz_someMagicalNumber ) );
    });


    /* SELECT BUBBLE TYPE */


    jQuery( ".thisisyyz__message__bubble" ).each(function() {
        let $elem = jQuery(this);
                        // Line height (1 line of text)
        if ( $elem.height() > thisisyyz_someMagicalNumber ) {
            $elem.addClass('second-bubble-type');
            $elem.removeClass('first-bubble-type');
        } else {
            $elem.addClass('first-bubble-type');
            $elem.removeClass('second-bubble-type');
        }
    });


    /* MOVE REPLY COUNTER (and show/hide third column) */


    if ( jQuery(window).width() <= thisisyyz_mainMediumMaxWidth ) {
        // Checks if reply-counter is already in column-1
        if ( ! jQuery( '.thisisyyz__column-1.thisisyyz__reply-counter' ).length ) {

            // Moves reply-counter to column-1
            jQuery( '.thisisyyz__container.type-topic' ).each( function() {
                let $replyCounter = jQuery( this ).find( '.thisisyyz__reply-counter' ),
                    $column1      = jQuery( this ).find( '.thisisyyz__column-1' );

                jQuery( $replyCounter ).appendTo( $column1 );

                if ( thisisyyz_replyCounterColumn === 3 ) {
                    jQuery( '.thisisyyz__column-3' ).hide();
                }
            });
        }
    } else {
        // Checks if reply-counter is already in column-2 (or 3)
        if ( ! jQuery( `.thisisyyz__column-${thisisyyz_replyCounterColumn}.thisisyyz__reply-counter` ).length ) {

            // Moves reply-counter back (to column-2)
            jQuery( '.thisisyyz__container.type-topic' ).each( function() {
                let $replyCounter = jQuery( this ).find( '.thisisyyz__reply-counter' ),
                    $column2      = jQuery( this ).find( `.thisisyyz__column-${thisisyyz_replyCounterColumn}` );

                jQuery( $replyCounter ).appendTo( $column2 );

                if ( thisisyyz_replyCounterColumn === 3 ) {
                    jQuery( '.thisisyyz__column-3' ).show();
                }
            });
        }
    }


    /* MOVE TIMESTAMP */


    if ( jQuery(window).width() <= thisisyyz_mainMediumMaxWidth ) {
        // Checks if timestamp is already in message-container
        if ( ! jQuery( '.thisisyyz__message-container.thisisyyz__created' ).length ) {

            // Moves timestamp to message-container
            jQuery( '.thisisyyz__container' ).each( function() {
                let $timestamp        = jQuery( this ).find( '.thisisyyz__created' ),
                    $messageContainer = jQuery( this ).find( '.thisisyyz__message-container' );

                jQuery( $timestamp ).appendTo( $messageContainer );
            });
        }
    } else {
        // Checks if timestamp is already in column-2
        if ( ! jQuery( '.thisisyyz__column-2.thisisyyz__created' ).length ) {
            // Moves timestamp back (to column-2)
            jQuery( '.thisisyyz__container' ).each( function() {
                let $timestamp = jQuery( this ).find( '.thisisyyz__created' ),
                    $column2   = jQuery( this ).find( '.thisisyyz__column-2' );

                jQuery( $timestamp ).appendTo( $column2 );
            });
        }
    }
}



/*=====================================
  2     ENABLE POINTER EVENTS
 =====================================*/



/**
 * Adds class "thisisyyz__message__text__item__all-pointer-events" to children of thisisyyz__message__text with
 * more than 1 child inside or with no text node (so only text elems with no siblings will have no pointer events).
 */
function thisisyyz_enablePointerEvents() {
    jQuery( ".thisisyyz__message" ).each(function() {
        let $text = jQuery( '.thisisyyz__message__text', this );

        $text.children().each(function() {
            let $contents = jQuery(this).contents();

            // Twitter-Widget with #shadow-root has length 0
            if ( $contents.length ) {
                $contents.each(function() {
                    if ( ! ( thisisyyz_doTreatAsTextElem(this) ) ) {
                        jQuery(this).addClass( 'thisisyyz__message__text__item__all-pointer-events' );
                    }
                });
            } else {
                jQuery(this).addClass( 'thisisyyz__message__text__item__all-pointer-events' );
            }
        });
    });
}



/*=====================================
  3     REMOVE REPLY COUNTER MARGINS
 =====================================*/



/**
 * Removes reply counter margins for multiline message blocks
 */
function thisisyyz_removeReplyCounterMargins( $bubble , $message ) {
    let $replyCounter = $message.siblings( '.thisisyyz__reply-counter' );

    if ( $bubble.height() > thisisyyz_someMagicalNumber ) {
        $replyCounter.css( 'margin', 0 );
    } else {
        // Disables given property
        $replyCounter.css( 'margin', '' );
    }
}



/*=====================================
  4     MAKE MESSAGES WITH YOUTUBE WIDTH 100
 =====================================*/



function thisisyyz_messageWithYoutube100() {
    jQuery( 'iframe[src*="youtube.com"]' ).each(function() {
        jQuery(this).parents( '.thisisyyz__message-container' ).css( 'width', '100%' )
    });

    // Triggers an event for YouTube iframe to resize!
    jQuery(window).trigger( 'resize' );
}



/*=====================================
  5     MOVE reply-counter to column-3 when there's no admin links
 =====================================*/



function thisisyyz_replyCounterToColumn3() {
    if ( ! jQuery( '.thisisyyz__container.type-topic .thisisyyz__admin-links' ).length ) {
        thisisyyz_replyCounterColumn = 3;

        jQuery( '.thisisyyz__container.type-topic' ).each( function() {
            let $replyCounter = jQuery( this ).find( '.thisisyyz__reply-counter' ),
                $message      = jQuery( this ).find( '.thisisyyz__message-container' ),
                $column3      = jQuery( this ).find( '.thisisyyz__column-3' );

            jQuery( $replyCounter ).appendTo( $column3 );
            jQuery( $column3 ).css('display', 'flex');
            $message.addClass( 'thereis-third-column' );
        });
    } else {
        thisisyyz_replyCounterColumn = 2;
    }
}



/*=================================================================================================================
  #     LET'S START THE GAME!
 =====================================*/



/*  1 MAIN  */

jQuery(document).on( 'ready', () => {
    /*  5 MOVE reply-counter to column-3 when there's no admin links */
    thisisyyz_replyCounterToColumn3();

    thisisyyz_main( true )
} );

jQuery(window)  .on( 'load',  () => {
    setTimeout( thisisyyz_main, 400, false );
    setTimeout( thisisyyz_main, 800, false );
});

jQuery(window).on( 'resize', () => {
    clearTimeout( thisisyyz_timeoutID1 );
    thisisyyz_timeoutID1 = setTimeout( () => { thisisyyz_main(); setTimeout(thisisyyz_main, 400, false) }, 200, false );
});



/*  2 ENABLE POINTER EVENTS */

jQuery(window).on( 'load', thisisyyz_enablePointerEvents );



/*  4 MAKE MESSAGES WITH YOUTUBE WIDTH 100 */

jQuery(document).on( 'ready', thisisyyz_messageWithYoutube100 );
