$(document).ready( function()
{
    $("tbody tr").each( function(i)
    {
        $(this).mouseover( function(){
            $(this).addClass( "couleur-blancCasse" );
        });
        $(this).mouseout( function(){
            $(this).removeClass("couleur-blancCasse");
        });
        $(this).dblclick( function()
        {
            document.getElementsByClassName( "LienVersDossier" )[i].click();
        });
    });
});