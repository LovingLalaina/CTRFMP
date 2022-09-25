
var numeroPensionBC = $( ".NumeroPensionBC" );
var numeroEngagement = $( ".NumeroEngagement" );
var numeroBordereau = $( ".NumeroBordereau" );

var numeroPensionBC_message = $( ".NumeroPensionBC_message" );
var numeroEngagement_message = $( ".NumeroEngagement_message" );
var numeroBordereau_message = $( ".NumeroBordereau_message" );

$( ".BoutonBC" ).each( function( i )
{
    $( this ).click( function( evenement )
    {
        
        if( numeroEngagement.eq(i).val() == "" )
        {
            evenement.preventDefault();
            numeroEngagement_message.eq(i).text( "Numéro d'Engagement manquant !!!" );
            numeroEngagement_message.eq(i).css( "color" , "red" );
            numeroEngagement.eq(i).focus();
        }
        else if( numeroEngagement_regex.test( numeroEngagement.eq(i).val() ) == false )
        {
            evenement.preventDefault();
            numeroEngagement_message.eq(i).text( "Format du numéro incorrect !" );
            numeroEngagement_message.eq(i).css( "color" , "orange" );
            numeroEngagement.eq(i).focus();
        }
        else
        {
            numeroEngagement_message.eq(i).text("");
            if( numeroBordereau.eq(i).val() == "" )
            {
                evenement.preventDefault();
                numeroBordereau_message.eq(i).text( "Numéro de Bordereau manquant !!!" );
                numeroBordereau_message.eq(i).css( "color" , "red" );
                numeroBordereau.eq(i).focus();
            }
            else if( numeroBordereau_regex.test( numeroBordereau.eq(i).val() ) == false )
            {
                evenement.preventDefault();
                numeroBordereau_message.eq(i).text( "Format du numéro incorrect !" );
                numeroBordereau_message.eq(i).css( "color" , "orange" );
                numeroBordereau.eq(i).focus();
            }
            else
            {
                numeroBordereau_message.eq(i).text("");
                if( numeroPensionBC.eq(i).val() == "" )
                {
                    evenement.preventDefault();
                    numeroPensionBC_message.eq(i).text( "Numéro de Pension manquant !!!" );
                    numeroPensionBC_message.eq(i).css( "color" , "red" );
                    numeroPensionBC.eq(i).focus();
                }
                else if( numeroPension_regex.test( numeroPensionBC.eq(i).val() ) == false )
                {
                    evenement.preventDefault();
                    numeroPensionBC_message.eq(i).text( "Format du numéro incorrect !" );
                    numeroPensionBC_message.eq(i).css( "color" , "orange" );
                    numeroPensionBC.eq(i).focus();
                }
                else
                {
                    numeroPensionBC_message.eq(i).text("");
                
                }
            }  
        }  
    });
});