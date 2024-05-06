jQuery.noConflict();

// jQuery(document).ready(function() {
//     jQuery('.woof_container_inner_').click(function() {
//         // Найдем блок .woof_block_html_items внутри нажатого .woof_container_inner_
//         var woofBlock = jQuery(this).find('.woof_block_html_items');
        
//         // Переключим класс 'woof_closed_block' на этом блоке
//         woofBlock.toggleClass('woof_closed_block');
//     });
// });

jQuery(document).ready(function() {
    jQuery(document).on('click', '.woof_container_inner_', function() {
        let woofBlock = jQuery(this).find('.woof_block_html_items');
        woofBlock.toggleClass('woof_closed_block');
    });
});
