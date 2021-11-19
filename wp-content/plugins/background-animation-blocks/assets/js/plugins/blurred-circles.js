var PluginBlurredCircles = function ( canvas ) {
    if( canvas !== null ){
        const first = (canvas.hasAttribute('data-first')) ? canvas.getAttribute('data-first') : '#E45A84';
        const second = (canvas.hasAttribute('data-second')) ? canvas.getAttribute('data-second') : '#583C87';
        const third = (canvas.hasAttribute('data-third')) ? canvas.getAttribute('data-third') : '#FFACAC';
        const fourth = (canvas.hasAttribute('data-fourth')) ? canvas.getAttribute('data-fourth') : '#a76fc7';

        canvas.querySelectorAll('span:nth-child(odd)').forEach( function( element ) {
            element.style.color = first;
        });
        canvas.querySelectorAll('span:nth-child(even)').forEach( function( element ) {
            element.style.color = second;
        });
        canvas.querySelectorAll('span:nth-child(3n + 3)').forEach( function( element ) {
            element.style.color = third;
        });
        canvas.querySelectorAll('span:nth-child(5n + 5)').forEach( function( element ) {
            element.style.color = fourth;
        });
    }
}