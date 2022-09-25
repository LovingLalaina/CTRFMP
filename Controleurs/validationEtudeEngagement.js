
var numeroDebut = $( ".NumeroDebut" );
var numeroFin = $( ".NumeroFin" );
var numeroPreparer_message = $( ".NumeroPreparer_message" );

$( ".BoutonPreparer" ).each( function(i)
{
    $(this).click( function( evenement )
    {
        if( numeroDebut.eq(i).val() == "" )
        {
            evenement.preventDefault();
            numeroPreparer_message.eq(i).text( "Numéro de debut manquant !!!" );
            numeroPreparer_message.eq(i).css( "color" , "red" );
            numeroDebut.eq(i).focus();
        }
        else if( numeroFin.eq(i).val() == "" )
        {
            evenement.preventDefault();
            numeroPreparer_message.eq(i).text( "Numéro de fin manquant !!!" );
            numeroPreparer_message.eq(i).css( "color" , "red" );
            numeroFin.eq(i).focus();
        }
        else if( numeroDebut.eq(i).val() > numeroFin.eq(i).val() )
        {
            evenement.preventDefault();
            numeroPreparer_message.eq(i).text( "Ordre des numeros entrés incorrect !" );
            numeroPreparer_message.eq(i).css( "color" , "orange" );
            numeroDebut.eq(i).focus();
        }
        else
        numeroPreparer_message.eq(i).text( "" );
    });
})