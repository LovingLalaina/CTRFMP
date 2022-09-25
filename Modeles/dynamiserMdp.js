
document.getElementById( "AfficherMdp" ).addEventListener( "click" , function()
{
    document.FormulaireLogin.MotDePasse.focus();
    if( this.className == "fas fa-eye-slash text-purple" )
    {
        document.FormulaireLogin.MotDePasse.type = "text";
        this.className = "fas fa-eye text-purple";

        setTimeout( function()
        {
            document.FormulaireLogin.MotDePasse.type = "password";
            document.getElementById( "AfficherMdp" ).className = "fas fa-eye-slash text-purple";
        } , 4000 )
    }
    else
    {
        document.FormulaireLogin.MotDePasse.type = "password";
        this.className = "fas fa-eye-slash text-purple";
    }
});
        