/**
 * Main Administrate JS file
 *
 * @depend admin/base.js
 * @depend admin/settings.js
 * @depend admin/metabox.js
 *
 * @depend common/message.js
 *
 */
(function ($) {
  $(document).ready(function () {
    var message = new $.ADMMessage();
    var base = new $.ADMBase(message);
    var settings = new $.ADMSettings(base, message);
    var metabox = new $.ADMMetabox(base, message);
  });
}(jQuery));
