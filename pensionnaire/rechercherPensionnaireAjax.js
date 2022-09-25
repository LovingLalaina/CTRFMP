$(document).ready( function() 
{
    $( "#RecherchePensionnaire" ).keyup( function()
    {
        var resultatRecherche = $(this).val();
        if( resultatRecherche != "" )
        {
            $.ajax({
                url: "rechercherPensionnaire.php" ,
                method: "GET",
                data:"getRecherchePensionnaire=" + $( this ).val(),
                success:function( data )
                {
                    $(".div-table-pensionnaire").html( data );
                }
            });

        }
        else
        {
            $(".div-table-pensionnaire").html( "" );
            $.ajax({
                url: "rechercherPensionnaire.php" ,
                method: "GET",
                data:"getRecherchePensionnaire=" + $( this ).val(),
                success:function( data )
                {
                    $(".div-table-pensionnaire").html( data );
                }
            });
        }

        
    });
});
