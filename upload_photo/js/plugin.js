(function( $ ) {
   $.fn.getUpload = function(options) {
      var settings = $.extend( {
         'cropType'         : 'userCrop',
         'maxSize'          : '1024000',
         'width'            : '230',
         'height'           : '230',
         'count'            : '1',
         'afterResize'      : 'false',
         'sizes'            : 's#230#230'
      }, options);
      $json = JSON.stringify(settings);
      $(this).wrap('<form method="POST" action="/uploadphoto"></form>');
      $(this).before("<input type='hidden' name='data' value='" + $json + "' />");
   };
})(jQuery);