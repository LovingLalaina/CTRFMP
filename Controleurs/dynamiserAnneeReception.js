
window.addEventListener( "load" , function()
{
    var dateReception = document.getElementsByClassName( "DateReception" );
    var anneeReception = document.getElementsByClassName( "AnneeReception" );

    for( var i = 0 ; i < dateReception.length ; ++i )
    {
        const j = i; // CAR BIZARREMENT A L'EXECUTION DE BLU ADDEVENT LISTENNER i sera deja =2 et non =0
        dateReception[i].addEventListener( "blur" , function()
        {
            var date = new Date( this.value );
            anneeReception[j].value = date.getFullYear();
        });
    }
    
});
