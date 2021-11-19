var Pluginstars = function ( canvas ) {
    if( canvas !== null ){
        const STAR_COUNT = ( canvas.closest('.bab-stars-cont').offsetWidth + canvas.closest('.bab-stars-cont').offsetHeight ) / 8,
            STAR_SIZE = (canvas.hasAttribute('data-size')) ? parseInt(canvas.getAttribute('data-size')) : 3,
            STAR_MIN_SCALE = (canvas.hasAttribute('data-scale')) ? parseInt(canvas.getAttribute('data-scale')) : 0.2,
            OVERFLOW_THRESHOLD = 10;

            const context = canvas.getContext( '2d' );

            let scale = 1, // device pixel ratio
                width,
                height;

            let stars = [];

            let pointerX,
                pointerY;

            let velocity = { x: 0, y: 0, tx: 0, ty: 0, z: 0.0009 };

            let touchInput = false;

            generate();
            resize(canvas.closest('.bab-stars-cont'));
            step();

            window.addEventListener('resize', function(event){
                resize(canvas.closest('.bab-stars-cont'));
            });

            canvas.closest('.bab-stars-cont').onmousemove = onMouseMove;
            canvas.closest('.bab-stars-cont').ontouchmove = onTouchMove;
            canvas.closest('.bab-stars-cont').ontouchend = onMouseLeave;
            document.onmouseleave = onMouseLeave;

            function generate() {

            for( let i = 0; i < STAR_COUNT; i++ ) {
                stars.push({
                x: 0,
                y: 0,
                z: STAR_MIN_SCALE + Math.random() * ( 1 - STAR_MIN_SCALE )
                });
            }

        }

        function placeStar( star ) {

            star.x = Math.random() * width;
            star.y = Math.random() * height;

        }

        function recycleStar( star ) {

            let direction = 'z';

            let vx = Math.abs( velocity.x ),
                    vy = Math.abs( velocity.y );

            if( vx > 1 || vy > 1 ) {
                let axis;

                if( vx > vy ) {
                axis = Math.random() < vx / ( vx + vy ) ? 'h' : 'v';
                }
                else {
                axis = Math.random() < vy / ( vx + vy ) ? 'v' : 'h';
                }

                if( axis === 'h' ) {
                direction = velocity.x > 0 ? 'l' : 'r';
                }
                else {
                direction = velocity.y > 0 ? 't' : 'b';
                }
            }
            
            star.z = STAR_MIN_SCALE + Math.random() * ( 1 - STAR_MIN_SCALE );

            if( direction === 'z' ) {
                star.z = 0.1;
                star.x = Math.random() * width;
                star.y = Math.random() * height;
            }
            else if( direction === 'l' ) {
                star.x = -OVERFLOW_THRESHOLD;
                star.y = height * Math.random();
            }
            else if( direction === 'r' ) {
                star.x = width + OVERFLOW_THRESHOLD;
                star.y = height * Math.random();
            }
            else if( direction === 't' ) {
                star.x = width * Math.random();
                star.y = -OVERFLOW_THRESHOLD;
            }
            else if( direction === 'b' ) {
                star.x = width * Math.random();
                star.y = height + OVERFLOW_THRESHOLD;
            }

        }

        function resize(el) {

            scale = window.devicePixelRatio || 1;

            if( el !== undefined ) {
                width = el.offsetWidth * scale;
                height = el.offsetHeight * scale;
            } else {
                width = window.innerWidth * scale;
                height = window.innerHeight * scale;
            }

            if(height == 0){
                height = width / 2;
            }

            canvas.width = width;
            canvas.height = height;

            stars.forEach( placeStar ); 

        }

        function step() {

            context.clearRect( 0, 0, width, height );

            update();
            render();

            requestAnimationFrame( step );

        }

        function update() {

            velocity.tx *= 0.96;
            velocity.ty *= 0.96;

            velocity.x += ( velocity.tx - velocity.x ) * 0.8;
            velocity.y += ( velocity.ty - velocity.y ) * 0.8;

            stars.forEach( ( star ) => {

                star.x += velocity.x * star.z;
                star.y += velocity.y * star.z;

                star.x += ( star.x - width/2 ) * velocity.z * star.z;
                star.y += ( star.y - height/2 ) * velocity.z * star.z;
                star.z += velocity.z;
            
                // recycle when out of bounds
                if( star.x < -OVERFLOW_THRESHOLD || star.x > width + OVERFLOW_THRESHOLD || star.y < -OVERFLOW_THRESHOLD || star.y > height + OVERFLOW_THRESHOLD ) {
                recycleStar( star );
                }

            } );

        }

        function render(c = canvas) {

            stars.forEach( ( star ) => {

                context.beginPath();
                context.lineCap = 'round';
                context.lineWidth = STAR_SIZE * star.z * scale;
                const color = (c.hasAttribute('data-color')) ? c.getAttribute('data-color') : '#000';
                context.strokeStyle = color;

                context.beginPath();
                context.moveTo( star.x, star.y );

                var tailX = velocity.x * 2,
                    tailY = velocity.y * 2;

                // stroke() wont work on an invisible line
                if( Math.abs( tailX ) < 0.1 ) tailX = 0.5;
                if( Math.abs( tailY ) < 0.1 ) tailY = 0.5;

                context.lineTo( star.x + tailX, star.y + tailY );

                context.stroke();

            } );

        }

        function movePointer( x, y ) {

            if( typeof pointerX === 'number' && typeof pointerY === 'number' ) {

                let ox = x - pointerX,
                    oy = y - pointerY;

                velocity.tx = velocity.tx + ( ox / 8*scale ) * ( touchInput ? 1 : -1 );
                velocity.ty = velocity.ty + ( oy / 8*scale ) * ( touchInput ? 1 : -1 );

            }

            pointerX = x;
            pointerY = y;

        }

        function onMouseMove( event ) {

            touchInput = false;

            movePointer( event.clientX, event.clientY );

        }

        function onTouchMove( event ) {

            touchInput = true;

            movePointer( event.touches[0].clientX, event.touches[0].clientY, true );

            event.preventDefault();

        }

        function onMouseLeave() {

            pointerX = null;
            pointerY = null;

        }
    }
}