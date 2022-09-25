
document.getElementById( "AfficherMdpReception" ).addEventListener( "click" , function()
{

    document.FormulaireLoginReception.MotDePasse.focus();
    if( this.className == "fas fa-eye-slash text-purple" )
    {
        document.FormulaireLoginReception.MotDePasse.type = "text";
        this.className = "fas fa-eye text-purple";

        setTimeout( function()
        {
            document.FormulaireLoginReception.MotDePasse.type = "password";
            document.getElementById( "AfficherMdpReception" ).className = "fas fa-eye-slash text-purple";
        } , 4000 )
    }
    else
    {
        document.FormulaireLoginReception.MotDePasse.type = "password";
        this.className = "fas fa-eye-slash text-purple";
    }
});
        