<?php

?>

<script type="text/javascript">
     jQuery(document).ready(function(){
         /* Album galeries */
         jQuery('.photo-principal').each(function(){
             var target = jQuery(this).attr('data-gallery-target');
             jQuery('.' + target).colorbox({
                 rel: target,
                 photo:true,
                 maxHeight: '97%',
                 current: '',
                 fixed:true
             });

             jQuery('.trigger-share').colorbox({
                 inline:true,
                 href:'#referrals_modal',
                 width:'50%',
                 onOpen: function(){
                    jQuery('#referrals_modal').show();
                 },
                 onClosed: function() {
                     jQuery('#referrals_modal').hide();
                 }
             });
         });
     });

     // Eliminar album
     function deleteAlbum(album){
         var conf = confirm("¿Está seguro que desea eliminar el álbum?");

         if(conf == true){
             jQuery.ajax({
                 type: 'get',
                 dataType: 'json',
                 url: 'actions/albumAction.php',
                 data: {a:<?php echo $rs_album->a_id;?>, act:"deleteAlbum"},
                 success: function(json){
                     if (json['success'] == true) {
                         jQuery('.album-section.album-'+album).remove();
                     }
                 }
             });
         }
     }
</script>