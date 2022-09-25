
window.addEventListener( "load" , function()
{
    var critereNumero = document.getElementById( "critereNumero" );
    var critereFM = document.getElementById( "critereFM" );
    var rechercheParNumero = document.getElementById( "rechercheParNumero" );
    var rechercheParFM = document.getElementById( "rechercheParFM" );
    
    critereNumero.addEventListener( "click" , function()
    {
        rechercheParNumero.style.display = "block";
        rechercheParFM.style.display = "none";
    });
    critereFM.addEventListener( "click" , function()
    {
        rechercheParFM.style.display = "block";
        rechercheParNumero.style.display = "none";
    });
});