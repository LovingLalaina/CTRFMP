
document.getElementById( "AfficherMdpEtude" ).addEventListener( "click" , function()
{
    document.FormulaireLoginEtude.MotDePasse.focus();
    if( this.className == "fas fa-eye-slash text-purple" )
    {
        document.FormulaireLoginEtude.MotDePasse.type = "text";
        this.className = "fas fa-eye text-purple";

        setTimeout( function()
        {
            document.FormulaireLoginEtude.MotDePasse.type = "password";
            document.getElementById( "AfficherMdpEtude" ).className = "fas fa-eye-slash text-purple";
        } , 4000 )
    }
    else
    {
        document.FormulaireLoginEtude.MotDePasse.type = "password";
        this.className = "fas fa-eye-slash text-purple";
    }
});
        