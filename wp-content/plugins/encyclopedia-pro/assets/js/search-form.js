(function($){

  $('form.encyclopedia.search-form input[name="s"]').each(function(){
    var
      $input = $(this),
      $form = $input.parents('form:first');

    $input.autocomplete({
      minLength: Encyclopedia_Search.minLength,
      delay: Encyclopedia_Search.delay,
      source: Encyclopedia_Search.ajax_url,
      appendTo: $form,
      select: function(event, ui){
        $input.val(ui.item.value);
        $form.submit();
      }
    });

  });

}(jQuery));
