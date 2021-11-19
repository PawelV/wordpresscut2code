let babInitBackgrounds = '';

document.addEventListener("DOMContentLoaded", function (event) {
    babInitBackgrounds = function( el ) {
        let starsEls = document.querySelectorAll( '.bab-stars' );
        let gradientEls = document.querySelectorAll( '.wp-block-bab-blocks-gradient' );
        let diagonalsEls = document.querySelectorAll( '.bab-diagonals-lines' );
        let blurredEls = document.querySelectorAll( '.bab-blurred-circles' );
        let bubblesEls = document.querySelectorAll( '.bab-bubbles' );
        let gooeyEls = document.querySelectorAll( '.bab-gooey' );
        let floatingsquaresEls = document.querySelectorAll( '.bab-floatingsquares li' );

        if( el !== null ) {
            starsEls = [];
            gradientEls = [];
            diagonalsEls = [];
            blurredEls = [];
            bubblesEls = [];
            gooeyEls = [];
            el.forEach( function( element ) {
                if( element.classList.contains('bab-stars') ) {
                    starsEls = el;
                }
                if( element.classList.contains('bab-gradient') ) {
                    gradientEls = el;
                }
                if( element.classList.contains('bab-diagonals-lines') ) {
                    diagonalsEls = el;
                }
                if( element.classList.contains('bab-blurred-circles') ) {
                    blurredEls = el;
                }
                if( element.classList.contains('bab-bubbles') ) {
                    bubblesEls = el;
                }
                if( element.classList.contains('bab-gooey') ) {
                    gooeyEls = el;
                }
                if( element.classList.contains('bab-floatingsquares') ) {
                    floatingsquaresEls = element.querySelectorAll( 'li' );
                }
            });
        }

        // Stars
        if(starsEls.length > 0) {
            starsEls.forEach( function( element ) {
                Pluginstars(element);
            });
        }

        // Gradient
        if(gradientEls.length > 0) {
            gradientEls.forEach( function( element ) {
                const speed = element.querySelector('.bab-gradient-controlls').getAttribute('data-speed');
                if( speed !== undefined ) {
                    element.style.animationDuration = speed + "s";
                }
            });
        }

        // Diagonal lines
        if(diagonalsEls.length > 0) {
            diagonalsEls.forEach( function( element ) {
                const firstColor = element.getAttribute('data-first');
                const secondColor = element.getAttribute('data-second');
                if( firstColor !== undefined && secondColor !== undefined ) {
                    element.querySelectorAll( '.bab-diagonals' ).forEach( function( elementCh ) {
                        elementCh.style.backgroundImage = 'linear-gradient(-60deg, '+firstColor+' 50%, '+secondColor+' 50%)';
                    });
                }
            });
        }

        // Blurred circles
        if(blurredEls.length > 0) {
            blurredEls.forEach( function( element ) {
                PluginBlurredCircles(element);
            });
        }

        // Bubbles
        if(bubblesEls.length > 0) {
            bubblesEls.forEach( function( element ) {
                PluginBubbles(element);
            });
        }

        // Gooey
        if(gooeyEls.length > 0) {
            gooeyEls.forEach( function( element ) {
                PluginGooey(element);
            });
        }

        // Floating squares
        if(floatingsquaresEls.length > 0) {
            floatingsquaresEls.forEach( function( element ) {
                const color = (element.closest('.bab-floatingsquares').hasAttribute('data-color')) ? element.closest('.bab-floatingsquares').getAttribute('data-color') : 'rgba(255, 255, 255, 0.2)';
                element.style.backgroundColor = color;
            });
        }
    }

    babInitBackgrounds(null);
});