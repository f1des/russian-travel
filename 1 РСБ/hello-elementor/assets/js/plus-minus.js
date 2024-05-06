jQuery.noConflict();

jQuery(document).ready(function() {
  jQuery('.quantity__minus').click(function () {
      let jQueryinput = jQuery(this).parent().find('input');
      let count = parseInt(jQueryinput.val()) - 1;
      count = count < 1 ? 1 : count;
      jQueryinput.val(count);
      jQueryinput.change();
      return false;
  });
  jQuery('.quantity__plus').click(function () {
      let jQueryinput = jQuery(this).parent().find('input');
      jQueryinput.val(parseInt(jQueryinput.val()) + 1);
      jQueryinput.change();
      return false;
  });
});