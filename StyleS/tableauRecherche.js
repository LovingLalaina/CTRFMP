
$( document ).ready( function()
{
    var nombreLigne = $( ".ligne-pensionnaire" ).length;

    $( ".div-table-pensionnaire" ).css( "height" , 510 );
    
    if( nombreLigne <= 8 ) $( ".div-table-pensionnaire" ).css( "height" , nombreLigne * 50 + 60 );
    else $( ".div-table-pensionnaire" ).css( "height" , 510 );

});