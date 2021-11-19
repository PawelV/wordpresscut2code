var PluginGooey = function ( canvas ) {
    if( canvas !== null ){
        canvas.innerHTML = '';
        for( var i = 0; i < 128; i++ ) {
            let b = document.createElement("div");
            b.classList.add('bubble');
            let s = `--size:${2+Math.random()*4}rem; --distance:${6+Math.random()*4}rem; --position:${-5+Math.random()*110}%; --time:${2+Math.random()*2}s; --delay:${-1*(2+Math.random()*2)}s;`;
            b.setAttribute('style', s);
            canvas.append(b);
        }
        const height = (canvas.hasAttribute('data-height')) ? parseInt(canvas.getAttribute('data-height')) : 5;
        canvas.closest('.bab-gooey-cont').querySelector('.bab-gooey-cont-footer').style.height = height + '%';
        canvas.style.bottom = height + '%';

        const color = (canvas.hasAttribute('data-color')) ? canvas.getAttribute('data-color') : '#fff';
        canvas.closest('.bab-gooey-cont').querySelector('.bab-gooey-cont-footer').style.backgroundColor = color;
        canvas.querySelectorAll('.bubble').forEach( function( element ) {
            element.style.backgroundColor = color;
        });
    }
}