jQuery.noConflict();

jQuery(document).ready(function() {
  jQuery("#showMyPopup").click(function() {
    jQuery("#elementor-popup-modal-164").toggle(); // Показать popup

    // Установить позицию относительно блока .container
    var containerOffset = jQuery(".elementor-element-1112b4a").offset();
    jQuery("#elementor-popup-modal-164").css({
      top: containerOffset.top + jQuery(".elementor-element-1112b4a").outerHeight(),
      left: containerOffset.left
    });
  });
});