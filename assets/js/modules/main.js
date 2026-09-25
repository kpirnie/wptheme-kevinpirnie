// actual dom ready
var DOMReady = function( callback ) {
    if ( document.readyState === "interactive" || document.readyState === "complete" ) {
        callback( );
    } else if ( document.addEventListener ) {
        document.addEventListener( "DOMContentLoaded", callback );
    } else if ( document.attachEvent ) {
        document.attachEvent( "onreadystatechange", function( ) {
            if ( document.readyState != "loading" ) {
                callback( );
            }
        } );
    }
};
