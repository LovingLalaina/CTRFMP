
var numeroPension = $( ".NumeroPension" );
var numeroPension_message = $( ".NumeroPension_message" );

var dateReception = $( ".DateReception" );
var anneeReception = $( ".AnneeReception" );
var anneeReception_message = $( ".AnneeReception_message" );

$( ".BoutonDossier" ).each( function( i )
{
    $( this ).click( function( evenement )
    {
        var maDate = new Date( dateReception.eq(i).val() );
        if( maDate.getFullYear() != anneeReception.eq(i).val() )
        {
            evenement.preventDefault();
            anneeReception_message.eq(i).text( "L'année entrée ne correspond pas à la date de réception !!!" );
            anneeReception_message.eq(i).css( "color" , "orange" );
            anneeReception.eq(i).focus();
        }
        else
        {
            anneeReception_message.eq(i).text("");
            if( numeroPension.eq(i).val() == "" )
            {
                evenement.preventDefault();
                numeroPension_message.eq(i).text( "Numéro de Pension manquant !!!" );
                numeroPension_message.eq(i).css( "color" , "red" );
                numeroPension.eq(i).focus();
            }
            else if( ( numeroPension_regex.test( numeroPension.eq(i).val() ) == false ) && ( numeroCIN_regex.test( numeroPension.eq(i).val() ) == false ) )
            {
                evenement.preventDefault();
                numeroPension_message.eq(i).text( "Format du numéro incorrect !" );
                numeroPension_message.eq(i).css( "color" , "orange" );
                numeroPension.eq(i).focus();
            }
            else
                numeroPension_message.eq(i).text("");
        }
    });
});