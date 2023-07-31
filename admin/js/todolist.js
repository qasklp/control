(function($) {
  'use strict';
  $(function() {
    var todoListItem = $('.todo-list');
    var todoListInput = $('.todo-list-input');
    $('.todo-list-add-btn').on("click", function(event) {
      event.preventDefault();

      var item = $(this).prevAll('.todo-list-input').val();

      if (item) {
        $.ajax({
          url: 'todo.php?text=' + item + '&action=1',
          success: function(data){
            //$('#hall').html(xmldata);
            todoListItem.append("<li><div class='form-check'><label class='form-check-label'><input class='checkbox' type='checkbox' id='"+ data +"'/>" + item + "<i class='input-helper'></i></label></div><i class='remove ti-close' id='" + data + "'></i></li>");
            todoListInput.val("");
          }
        });
      }

    });

    todoListItem.on('change', '.checkbox', function() {
      if ($(this).attr('checked')) {
        //alert($(this).attr('id'));
        $.ajax({
          url: 'todo.php?id=' + $(this).attr('id') + '&action=3&chk=0',
          success: function(data){
            //$('#hall').html(xmldata);
            //alert(data);
          }
        });
        $(this).removeAttr('checked');
      } else {
        $.ajax({
          url: 'todo.php?id=' + $(this).attr('id') + '&action=3&chk=1',
          success: function(data){
            //$('#hall').html(xmldata);
           // alert(data);
          }
        });
        $(this).attr('checked', 'checked');
      }

      $(this).closest("li").toggleClass('completed');

    });

    todoListItem.on('click', '.remove', function() {
      //alert($(this).attr('id'));
       $.ajax({
          url: 'todo.php?id=' + $(this).attr('id') + '&action=2',
          success: function(data){
            //$('#hall').html(xmldata);
            //alert(data);
          }
        });
      $(this).parent().remove();
    });

  });
})(jQuery);