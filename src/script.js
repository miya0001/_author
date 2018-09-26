( function() {
    if ( document.querySelector( '.underscore_author' ) ) {
        var me = '/_author/js/script.min.js';
        var css = '/_author/css/style.min.css';

        var scripts = document.querySelectorAll( 'script' );
        for ( var i = 0; i < scripts.length; i++ ) {
            var item = scripts[ i ];
            var src = item.getAttribute( 'src' );
            if ( src ) {
                if ( 0 < src.indexOf( me ) ) {
                    css = src.replace( me, css );
                }
            }
        }

        console.log('hello')

        var link = document.createElement( 'link' );
        link.setAttribute( 'rel', 'stylesheet' );
        link.setAttribute( 'type', 'text/css' );
        link.setAttribute( 'media', 'all' );
        link.setAttribute( 'href', css );
        document.head.appendChild( link );
    }
} )();
