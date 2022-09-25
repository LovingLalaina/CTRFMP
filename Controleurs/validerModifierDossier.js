
var numeroPensionModif = $( ".NumeroPensionModif" );
var numeroPensionModif_message = $( ".NumeroPensionModif_message" );

var dateReceptionModif = $( ".DateReceptionModif" );
var anneeReceptionModif = $( ".AnneeReceptionModif" );
var anneeReceptionModif_message = $( ".AnneeReceptionModif_message" );


$( ".BoutonModifierDossier" ).each( function( i )
{
    
    $( this ).click( function( evenement )
    {
        var maDate = new Date( dateReceptionModif.eq(i).val() );
        if( maDate.getFullYear() != anneeReceptionModif.eq(i).val() )
        {
            evenement.preventDefault();
            anneeReceptionModif_message.eq(i).text( "L'année entrée ne correspond pas à la date de réception !!!" );
            anneeReceptionModif_message.eq(i).css( "color" , "orange" );
            anneeReceptionModif.eq(i).focus();
        }
        else
        {
            anneeReceptionModif_message.eq(i).text("");
            if( numeroPensionModif.eq(i).val() == "" )
            {
                evenement.preventDefault();
                numeroPensionModif_message.eq(i).text( "Numéro de Pension manquant !!!" );
                numeroPensionModif_message.eq(i).css( "color" , "red" );
                numeroPensionModif.eq(i).focus();
            }
            else if( numeroPension_regex.test( numeroPensionModif.eq(i).val() ) == false && numeroCIN_regex.test( numeroPensionModif.eq(i).val() ) == false )
            {
                evenement.preventDefault();
                numeroPensionModif_message.eq(i).text( "Format du numéro incorrect !" );
                numeroPensionModif_message.eq(i).css( "color" , "orange" );
                numeroPensionModif.eq(i).focus();
            }
            else
                numeroPensionModif_message.eq(i).text("");
        }
    });
});