(function ($, Drupal) {
Drupal.behaviors.myBehavior = {
  attach: function (context, settings) {
    //$('.drupal-page').once().each(function() {
     //$('a.clicker',context).on('click',function() {
       //console.log(context);
       var h2 = $('h2.node__title',context);
       //console.log('adam ma kota');
       //console.log(h2.text());
        $('a.clicker').once().on('click',function(){
           console.log('weszlo');
        });
        $('select.myselect').once().on('change',function(){
           console.log($(this).val());
        });


    // });
    //});

  }
}
})(jQuery, Drupal);
