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
    console.log(list.nestable('serialize'))
  };

  list.nestable({
    maxDepth: 2,
  }).on('change', updatePosition);

  updatePosition($('#nestable').data('output', $('#nestable-output')));


  /*************** Add Or Edit ***************/
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
    let iExist = false;
    $.each( $('.dd-handle'), function () {
      if ($(this).text().trim().toLowerCase() === valName.trim().toLowerCase()) {
        iExist = true;
      }
    });

    if (iExist) {
      messages = VALIDATE_MESSAGE.unique.replace(':attribute', label);
      showError(label, messages)
      return false;
    }

    if ($(this).attr('data-id') !== undefined) {
      // update input
      let id = $(this).attr('data-id');
      let target = $('.dd-item[data-id="' + id + '"]');
      target.data('name', valName);
      target.data('icon', valIcon);
      target.data('url', valUrl);
      target.find('.dd-handle').text(valName);
    } else {
      let html = `
      <li class="dd-item" data-id="0" data-name="${valName}" data-url="${valUrl}" data-icon="${valIcon}">
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
    menuItemIcon.val(icon);
    menuItemUrl.val(url);

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

  $('body').on('submit', '#formSubmitSimple',function (e) {
    e.preventDefault()
    let form = $(this);
    let url = form.attr('action');
    let formData = new FormData(form[0]);
    let menuItems = list.nestable('serialize');

    formData.append("menu_items", JSON.stringify(menuItems));

    $.ajax({
      type: form.attr('method'),
      url: url,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success) {
          showNotify(response.message, 'success', true);
        } else {
          showNotify(response.message, 'error');
        }
      },
      error: function (_xhr) {
        if (_xhr.status === 422) {
          let errors = _xhr["responseJSON"].data
          for (let [key, value] of Object.entries(errors)) {
            showError(key, value[0]);
          }
        }
        if (_xhr.status === 500) {
          showNotify(_xhr['responseJSON'].message, 'error');
        }
      }
    })
  });

  $('body').on('click', '#reset-item',function (e) {
    resetFormMenuItem();
  });
});
