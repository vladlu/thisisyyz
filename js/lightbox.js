'use strict';


jQuery(() => {


    let lightboxImageScaleSize = 1;



    jQuery( ".thisisyyz__message img" ).each(function() {
        let $this = jQuery(this);

        $this.on( 'click', { '$this': $this } , startLightBox );
    });



    function startLightBox( event ) {
        let $this = event.data.$this;

        jQuery( 'body' ).append( '<div class="thisisyyz__lighbox__page-cover"></div>' );
        let $pageCover = jQuery( '.thisisyyz__lighbox__page-cover' );

        jQuery( $this ).clone().addClass( 'thisisyyz__lighbox__image' ).appendTo( $pageCover );
        let $lightboxImage = jQuery( '.thisisyyz__lighbox__image' );

        let $alt = $this.attr( 'alt' );
        if (typeof $alt !== typeof undefined && $alt !== false) {
            jQuery( $pageCover ).append(
                `<div class="thisisyyz__lightbox__description-container"><span class="thisisyyz__lightbox__description">${ $alt }</span></div>`
            );
        }

        main( $lightboxImage );


        /* Closing */
        $pageCover.on( 'click', { '$pageCover': $pageCover }, closeLightbox );
    }


    function main( $lightboxImage ) {

        /* Change Image Size To Fit Well */

        ChangeImageSize( $lightboxImage );
        jQuery(window).on( 'resize', () => { ChangeImageSize( $lightboxImage ) } );


        /* Draggable */

        $lightboxImage.draggable();


        /* Scrolling */

        $lightboxImage.on( 'wheel', { '$lightboxImage': $lightboxImage }, scrollHandler );
    }


    function ChangeImageSize( $lightboxImage ) {

        let maxWidthForInitial  = jQuery(window).width()  * 0.90,
            maxHeightForInitial = jQuery(window).height() * 0.80;


        $lightboxImage.css( 'width', 'auto' );
        $lightboxImage.css( 'height', 'auto' );


        if ( $lightboxImage.height() > maxHeightForInitial ) {
            $lightboxImage.height( maxHeightForInitial );
            $lightboxImage.css( 'width', 'auto' )
        }
        if ( $lightboxImage.width() > maxWidthForInitial ) {
             $lightboxImage.width( maxWidthForInitial );
             $lightboxImage.css( 'height', 'auto' )
        }
    }


    function scrollHandler( e ) {

        let $lightboxImage = e.data.$lightboxImage;


        /* Prevent Window Scrolling */

        e = e || window.event;
        if (e.preventDefault)
            e.preventDefault();
        e.returnValue = false;


        /* Centering image to mouse position (1/2) */
        /* GETS MOUSE POSITION RELATIVE TO THE IMAGE */

        let initialWidth  = $lightboxImage.width(),
            initialHeight = $lightboxImage.height(),

            offsetLeft =  $lightboxImage.offset().left,
            offsetTop  =  $lightboxImage.offset().top,
            // Mouse position
            eventOccuredLeftToPage = e.pageX,
            eventOccuredTopToPage  = e.pageY,

            eventOccuredLeftRelativePX = ( eventOccuredLeftToPage - offsetLeft ) / lightboxImageScaleSize,
            eventOccuredTopRelativePX  = ( eventOccuredTopToPage  - offsetTop  ) / lightboxImageScaleSize,

            eventOccuredLeftRelativePercent = eventOccuredLeftRelativePX / initialWidth,
            eventOccuredTopRelativePercent  = eventOccuredTopRelativePX  / initialHeight;


        /* Zooming */

        // Image zooming coefficient (reverse sign)
        let scrollDelta =  e.originalEvent.deltaY * 0.01 * 0.15;

        if ( scrollDelta > 0 ){ // Mouse wheel Scroll Down (Decrease Image Size)
            if ( lightboxImageScaleSize - scrollDelta > 0.5 ) {
                lightboxImageScaleSize = lightboxImageScaleSize - scrollDelta;
            } else {
                // Don't go further
                return;
            }
        } else if ( scrollDelta < 0 ) { //  Mouse wheel Scroll Up (Increase Image Size)
            if ( lightboxImageScaleSize - scrollDelta < 6 ) {
                lightboxImageScaleSize = lightboxImageScaleSize - scrollDelta;
            } else {
                return;
            }
        }

        $lightboxImage.css( 'transform', `scale( ${ lightboxImageScaleSize } )` );


        /* Centering image to mouse position (2/2) */
        /* MOVES THE IMAGE TO BE AT THE SAME POSITION */

        let widthChangeInPX  = initialWidth  * -scrollDelta,
            heightChangeInPX = initialHeight * -scrollDelta,

            newOffsetLeft = offsetLeft - widthChangeInPX * 0.5,
            newOffsetTop  = offsetTop - heightChangeInPX * 0.5,

            moveFromLeft,
            moveFromTop;


        if ( eventOccuredLeftRelativePercent < 0.5 ) {
            moveFromLeft = widthChangeInPX * ( 1 - eventOccuredLeftRelativePercent - 0.5 );
        } else {
            moveFromLeft = widthChangeInPX * - ( eventOccuredLeftRelativePercent - 0.5 );
        }

        if ( eventOccuredTopRelativePercent < 0.5 ) {
            moveFromTop  = heightChangeInPX * ( 1 - eventOccuredTopRelativePercent - 0.5 );
        } else {
            moveFromTop  = heightChangeInPX * - ( eventOccuredTopRelativePercent - 0.5 );
        }


        $lightboxImage.offset( { 'left':  newOffsetLeft + moveFromLeft, 'top': newOffsetTop + moveFromTop } );
    }


    function closeLightbox(e) {
        let $pageCover = e.data.$pageCover;

        $pageCover.remove();

        lightboxImageScaleSize = 1;
    }
    
});
