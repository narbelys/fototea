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

        console.log('execute trigger share');

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