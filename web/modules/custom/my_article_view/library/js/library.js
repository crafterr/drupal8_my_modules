(function ($, Drupal) {
Drupal.behaviors.myBehavior = {
  attach: function (context, settings) {
   // $('.drupal-page', context).once().each(function() {
     $('a.clicker',context).on('click',function() {
       //console.log(context);
       var h2 = $('h2.node__title',context);
       console.log(settings);
       //console.log(h2.text());
     });
   // });

  }
}
})(jQuery, Drupal);
