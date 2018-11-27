$(function ()
{
   $('#recherche').on('keyup',function()
   {
      let recherche = $(this).val().toUpperCase();

      $('.nom').each(function()
      {
          if($(this).html().indexOf(recherche) === -1)
          {
            $(this).parent().parent().hide();
          }
            else
            {
                $(this).parent().parent().show();
            }
      });
   });
});



