/**
 * A Lightbox.
 *
 * @author Vladislav Luzan
 * @since 1.0.0
 */
'use strict';


jQuery( $ => {


    let lightboxImageScaleSize = 1,
        $pageCover,
        $lightboxImage;


    /**
     * Enables lightboxes for all ".thisisyyz__message img" elements.
     *
     * @since 1.0.0
     *
     * @listens $this:click
     *
     * @return {void}
     */
    $( ".thisisyyz__message img" ).each( function() {
        let $this = $(this);

        $this.on( 'click', { '$this': $this } , startLightBox );
    } );


    /**
     * Starts a lightbox.
     *
     * Does the main routing initializing a lightbox.
     *
     * @since 1.0.0
     *
     * @param {Event} event The event object that contains the target lightbox element.
     *
     * @return {void}
     */
    function startLightBox( event ) {
        /*
         * TODO: I think I can optimize this (1).
         */
        let $this = event.data.$this;


        /*
         * Adds HTML of the lightbox to the page.
         *
         * TODO: AND THIS (2).
         */
        $( 'body' ).append( '<div class="thisisyyz__lighbox__page-cover"></div>' );
        $pageCover = $( '.thisisyyz__lighbox__page-cover' );

        $( $this ).clone().addClass( 'thisisyyz__lighbox__image' ).appendTo( $pageCover );
        $lightboxImage = $( '.thisisyyz__lighbox__image' );


        /*
         * Adds a description for lightbox if the target image has an 'alt' attribute.
         */
        let $alt = $this.attr( 'alt' );
        if ( typeof $alt !== typeof undefined && $alt !== false ) {
            $( $pageCover ).append(
                `<div class="thisisyyz__lightbox__description-container"><span class="thisisyyz__lightbox__description">${ $alt }</span></div>`
            );
        }


        /*
         * Changes image size to fit well.
         */
        changeImageSize( $lightboxImage );


        /*
         * Makes a lightbox image draggable.
         */
        $lightboxImage.draggable();


        /*
         * Adds listeners.
         */
        addListeners();
    }


    /**
     * Adds listeners.
     *
     * @since 1.0.0
     *
     * @listens window:resize
     * @listens $lightboxImage:wheel
     * @listens $pageCover:click
     *
     * @return {void}
     *
     * TODO: Add "remove listeners" function.
     */
    function addListeners() {

        /**
         * Changes image size to fit well.
         *
         * @since 1.0.0
         *
         * @listens window:resize
         */
        $( window ).on( 'resize', changeImageSize);


        /**
         * Scrolling (zoom).
         *
         * Handles zooming of the lightbox image.
         *
         * @since 1.0.0
         *
         * @listens $lightboxImage:wheel
         */
        $lightboxImage.on( 'wheel', scrollHandler );


        /**
         * Closing.
         *
         * Handles a closing of the light when clicking on the not lightbox image.
         *
         * @since 1.0.0
         *
         * @listens $pageCover:click
         */
        $pageCover.on( 'click', closeLightbox );
    }


    /**
     * Changes image size to fit well.
     *
     * @since 1.0.0
     *
     * @return {void}
     */
    function changeImageSize() {

        let maxWidthForInitial  = $(window).width()  * 0.90,
            maxHeightForInitial = $(window).height() * 0.80;


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


    /**
     * Handles scrolling (zooming) of the lightbox image.
     *
     * @since 1.0.0
     *
     * @param {event} event The event object.
     *
     * @return {void}
     */
    function scrollHandler( event ) {

        /*
         * Prevents window scrolling.
         */

        event = event || window.event;
        if (event.preventDefault)
            event.preventDefault();
        event.returnValue = false;


        /*
         * Centering the image to mouse position (1/2).
         * Gets mouse position relative to the image.
         */
        let initialWidth  = $lightboxImage.width(),
            initialHeight = $lightboxImage.height(),

            offsetLeft =  $lightboxImage.offset().left,
            offsetTop  =  $lightboxImage.offset().top,
            // Mouse position.
            eventOccuredLeftToPage = event.pageX,
            eventOccuredTopToPage  = event.pageY,

            eventOccuredLeftRelativePX = ( eventOccuredLeftToPage - offsetLeft ) / lightboxImageScaleSize,
            eventOccuredTopRelativePX  = ( eventOccuredTopToPage  - offsetTop  ) / lightboxImageScaleSize,

            eventOccuredLeftRelativePercent = eventOccuredLeftRelativePX / initialWidth,
            eventOccuredTopRelativePercent  = eventOccuredTopRelativePX  / initialHeight;


        /*
         * Zooming.
         */
        let scrollDelta =  event.originalEvent.deltaY * 0.01 * 0.15; // Image zooming coefficient (reverse sign).

        if ( scrollDelta > 0 ){ // Mouse wheel Scroll Down (Decrease image size).
            if ( lightboxImageScaleSize - scrollDelta > 0.5 ) {
                lightboxImageScaleSize = lightboxImageScaleSize - scrollDelta;
            } else {
                // Don't go further.
                return;
            }
        } else if ( scrollDelta < 0 ) { //  Mouse wheel Scroll Up (Increase image size).
            if ( lightboxImageScaleSize - scrollDelta < 6 ) {
                lightboxImageScaleSize = lightboxImageScaleSize - scrollDelta;
            } else {
                return;
            }
        }

        $lightboxImage.css( 'transform', `scale( ${ lightboxImageScaleSize } )` );


        /*
         * Centering the image to the mouse position (2/2).
         * Moves the image to be at the same position.
         */

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


    /**
     * Closes the lightbox.
     *
     * @since 1.0.0
     *
     * @return {void}
     */
    function closeLightbox() {
        $pageCover.remove();

        lightboxImageScaleSize = 1;
    }
    
});
