

$( document ).ready( function()
{
    var nombreLigne = $( ".ligne-pensionnaire" ).length;
    if( nombreLigne <= 8 ) $( ".div-table-pensionnaire" ).css( "height" , nombreLigne * 50 + 60 );

    nombreLigne = $( ".ligne-chemise" ).length;
    if( nombreLigne <= 6 ) $( ".div-table-chemise" ).css( "height" , nombreLigne * 65 + 70 );
    
    nombreLigne = $( ".ligne-dossier" ).length;
    if( nombreLigne <= 6 ) $( ".div-table-dossier" ).css( "height" , nombreLigne * 65 + 70 );

    nombreLigne = $( ".ligne-BC" ).length;
    if( nombreLigne <= 6 ) $( ".div-table-BC" ).css( "height" , nombreLigne * 70 + 75 );

    nombreLigne = $( ".ligne-utilisateur" ).length;
    if( nombreLigne <= 6 ) $( ".div-table-utilisateur" ).css( "height" , nombreLigne * 70 + 75 );
});