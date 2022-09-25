

window.addEventListener( "load" , function()
{
    document.formTable.TousSelectionner.addEventListener( "change" , function()
    {
        for( var i = 0 ; i < document.formTable.elements.length ; ++i )
        {
            var elementActuel = document.formTable.elements[i];
            if( elementActuel.type === "checkbox" )
            {
                elementActuel.checked = this.checked;
            }
        }
    });
});