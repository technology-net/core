$(document).ready(function () {
  let list = $('#nestable');
  let nestableList = $("#nestable > .dd-list");
  let menuItemName = $('#menu-item-name');
  let menuItemIcon = $('#menu-item-icon');
  let menuItemUrl = $('#menu-item-url');

  let updatePosition = function () {
    let output = list.data('output');

    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize')));
    } else {
      alert('JSON browser support required for this page.');
    }
    // console.log(list.nestable('serialize'))
  };

  list.nestable({
    maxDepth: 2,
  }).on('change', updatePosition);

  /*************** Add Or Edit ***************/
  let newId = 1;
  $('body').on('click', '#add-item', function () {
    let valName = menuItemName.val();
    let valIcon = menuItemIcon.val();
    let valUrl = menuItemUrl.val();
    let label = menuItemName.attr('label');
    let messages = '';
    if (valName === '') {
      messages = VALIDATE_MESSAGE.required.replace(':attribute', label);
      showError(label, messages)
      return false;
    }
    if ($(this).attr('data-id') !== undefined) {
      // update input
      let id = $(this).attr('data-id');
      let target = $('.dd-item[data-id="' + id + '"]');
      target.attr('data-name', valName);
      target.attr('data-icon', valIcon);
      target.attr('data-url', valUrl);
      target.find('.dd-handle').text(valName);
    } else {
      let html = `
      <li class="dd-item" data-id="new-${newId}" data-name="${valName}" data-url="${valUrl}" data-icon="${valIcon}">
        <div class="dd-handle form-control">${valName}</div>
        <div class="input-group-append dd-item-group">
          <span class="input-group-text btn btn-danger button-delete">
              <i class="fas fa-times" aria-hidden="true"></i>
          </span>
          <span class="input-group-text btn btn-info button-edit">
              <i class="fas fa-pencil-alt" aria-hidden="true"></i>
          </span>
        </div>
      </li>
    `;
      nestableList.append(html);
      newId ++;
    }

    updatePosition($('#nestable').data('output', $('#nestable-output')));
    if (nestableList.height() > 506) {
      nestableList.addClass('scroll-y');
    }

    resetFormMenuItem();
  });

  /*************** Fill Data Edit ***************/
  $('body').on('click', '.button-edit', function () {
    let target = $(this).closest('li');
    let id = target.attr('data-id');
    let name = target.attr('data-name');
    let url = target.attr('data-url');
    let icon = target.attr('data-icon');

    menuItemName.val(name);
    menuItemIcon.val(url);
    menuItemUrl.val(icon);

    $('#add-item').attr('data-id', id).html(TEXT_EDIT_ITEM);
  });

  /*************** Delete ***************/
  $('body').on('click', '.button-delete', function () {
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
    if (nestableList.find('li').length <= 12) {
      nestableList.removeClass('scroll-y');
    }
  });

  function resetFormMenuItem() {
    menuItemName.val('');
    menuItemIcon.val('');
    menuItemUrl.val('');

    $('#add-item').removeAttr('data-id').html(TEXT_ADD_ITEM);
  }

  updatePosition($('#nestable').data('output', $('#nestable-output')));
});
