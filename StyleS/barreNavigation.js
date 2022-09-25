
$(document).ready( function()
{
    var borderTop = [ "5px  solid #e71d1d" , "5px  solid #0070ee" , " 5px  solid #f1dc4f" , "5px solid #00ff00" ];
    var backgroundColor = [ "rgba( 228 , 77 , 38 , 0.15 )" , "rgba( 000 , 112 , 192 , 0.15 )" , "rgba( 241 , 211 , 79 , 0.15 )" , "rgba( 50 , 240 , 20 , 0.15 )" ];

    $( "nav li[class!=liDeconnexion]" ).each( function( i )
    {
        $(this).mouseover( function(){
            $(this).css( "border-top" , borderTop[i] );
            $(this).css( "background-color" , backgroundColor[i] );
            $(this).children("a").css( "color" , "lightgrey" );
            $(this).children("a").css( "padding" , "15px 30px 20px 30px" );
        });

        $(this).mouseout( function(){
            $(this).css( "border-top" , "" );
            $(this).css( "background-color" , "" );
            $(this).children("a").css( "color" , "white" );
            $(this).children("a").css( "padding-top" , "" );
        });
    });

    $( ".liDeconnexion a" ).on( "mouseover" , function()
    {
        $( this ).css( "color" , "red" );
    });

    $( ".liDeconnexion a" ).on( "mouseout" , function()
    {
        $( this ).css( "color" , "white" );
    });

});

