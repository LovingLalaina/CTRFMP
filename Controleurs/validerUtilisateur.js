
var numeroPension = $( ".NumeroPension" );
var nomPensionnaire = $( ".NomPensionnaire" );
var prenomPensionnaire = $( ".PrenomPensionnaire" );
var numeroTelephone = $( ".NumeroTelephone" );

var numeroPension_message = $( ".NumeroPension_message" );
var nomPensionnaire_message = $( ".NomPensionnaire_message" );
var prenomPensionnaire_message = $( ".PrenomPensionnaire_message" );
var numeroTelephone_message = $( ".NumeroTelephone_message" );

var motDePasse = $( ".MotDePasse" );
var motDePasseConfirmation = $( ".MotDePasseConfirmation" );

var motDePasse_message = $( ".MotDePasse_message" );
var motDePasseConfirmation_message = $( ".MotDePasseConfirmation_message" );

$( ".BoutonUtilisateur" ).each( function( i )
{
    $( this ).click( function( evenement )
    {
        if( motDePasse.eq(i).val() != motDePasseConfirmation.eq(i).val() )
        {
            evenement.preventDefault();
            motDePasseConfirmation_message.eq(i).text( "Mots de passe Non Correspondant !!!" );
            motDePasseConfirmation_message.eq(i).css( "color" , "red" );
            motDePasseConfirmation.eq(i).focus();
        }
        else
        motDePasseConfirmation_message.eq(i).text( "" );
    });
});