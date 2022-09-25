
var numeroPension = $( ".NumeroPension" );
var nomPensionnaire = $( ".NomPensionnaire" );
var prenomPensionnaire = $( ".PrenomPensionnaire" );
var numeroTelephone = $( ".NumeroTelephone" );

var numeroPension_message = $( ".NumeroPension_message" );
var nomPensionnaire_message = $( ".NomPensionnaire_message" );
var prenomPensionnaire_message = $( ".PrenomPensionnaire_message" );
var numeroTelephone_message = $( ".NumeroTelephone_message" );

$( ".BoutonPensionnaire" ).each( function( i )
{
    $( this ).click( function( evenement )
    {
        if( numeroPension.eq(i).val() == "" )
        {
            evenement.preventDefault();
            numeroPension_message.eq(i).text( "Numéro de Pension manquant !!!" );
            numeroPension_message.eq(i).css( "color" , "red" );
            numeroPension.eq(i).focus();
            
        }
        else if( numeroPension_regex.test( numeroPension.eq(i).val() ) == false && numeroCIN_regex.test( numeroPension.eq(i).val() ) == false )
        {
            evenement.preventDefault();
            numeroPension_message.eq(i).text( "Format du numéro incorrect !" );
            numeroPension_message.eq(i).css( "color" , "orange" );
            numeroPension.eq(i).focus();
        }
        else
        {
            numeroPension_message.eq(i).text("");
            if( nomPensionnaire.eq(i).val() == "" )
            {
                evenement.preventDefault();
                nomPensionnaire_message.eq(i).text( "Nom de Pensionnaire manquant !!!" );
                nomPensionnaire_message.eq(i).css( "color" , "red" );
                nomPensionnaire.eq(i).focus();
            }
            else if( nomPensionnaire_regex.test( nomPensionnaire.eq(i).val() ) == false )
            {
                evenement.preventDefault();
                nomPensionnaire_message.eq(i).text( "Format du nom incorrect !" );
                nomPensionnaire_message.eq(i).css( "color" , "orange" );
                nomPensionnaire.eq(i).focus();
            }
            else
            {
                nomPensionnaire_message.eq(i).text("");
                
                if( prenomPensionnaire.eq(i).val() == "" )    prenomPensionnaire_message.eq(i).html( "" );
                else if( prenomPensionnaire_regex.test( prenomPensionnaire.eq(i).val() ) == false )
                {
                    evenement.preventDefault();
                    prenomPensionnaire_message.eq(i).text( "Format du prenom incorrect !" );
                    prenomPensionnaire_message.eq(i).css( "color" , "orange" );
                    prenomPensionnaire.eq(i).focus();
                }
                else
                {
                    prenomPensionnaire_message.eq(i).text( "" );
                    
                    if( numeroTelephone.eq(i).val() == "" )    numeroTelephone_message.eq(i).html( "" );
                    else if( numeroTelephone_regex.test( numeroTelephone.eq(i).val() ) == false )
                    {
                        evenement.preventDefault();
                        numeroTelephone_message.eq(i).text( "Format du Numéro incorrect !" );
                        numeroTelephone_message.eq(i).css( "color" , "orange" );
                        numeroTelephone.eq(i).focus();
                    }
                    else numeroTelephone_message.eq(i).text( "" );
                }
            }
        }
    });
});