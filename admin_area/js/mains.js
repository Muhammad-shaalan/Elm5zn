// // $(function () {
// // 	"use strict";
	 
    $(function () {
        "use strict";

        $("select").selectBoxIt({
            autoWidth: false
        });
        
       $('.live').keyup(function(){
           $($(this).data('class')).text($(this).val());
       });

       //INDEX.PHP
        // $('#x').on('click', function(){
        //     $($(this).data('class')).val($(this).data('id'));
        //     console.log($(this).data('id'));

        //     var id = $($(this).data('class')).val();
            
        //     var xhr = new XMLHttpRequest();
        //     xhr.onreadystatechange = function (){
        //         if(xhr.readyState == 4 && xhr.status == 200){
        //         }
        //     }
        //     xhr.open("POST","ajax.php?id="+id,true);
        //     xhr.send();
        // });

        
 });