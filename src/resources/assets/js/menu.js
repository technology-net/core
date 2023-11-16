$(document).ready(function () {
  let list = $('#nestable');

  let updatePosition = function () {
    let output = list.data('output');

    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize')));
    } else {
      alert('JSON browser support required for this page.');
    }
    console.log(list.nestable('serialize'))
  };

  list.nestable({
    maxDepth: 2,
  }).on('change', updatePosition);

  /*************** Delete ***************/
  $('body').on('click', '#nestable .button-delete', function () {
    let target = $(this).closest('li');
    if ($(target).length) {
      $(target).fadeOut(function () {
        $(target).remove();
        updatePosition($('#nestable').data('output', $('#nestable-output')));
      });
    }
    if (target.closest("ol[is-child='true']").find("li").length == 1) {
      target.parent().siblings('button').remove();
      target.parent().remove();
    }
  });


  updatePosition($('#nestable').data('output', $('#nestable-output')));
})
