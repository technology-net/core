$(document).ready(function() {
  let url = '';

  let selected = getSelectedOptionsTab();
  url = ROUTE_IDX + '?key=' + selected.join(',');
  getListsByKey(url);

  $('body').on('change', '.select-config', function () {
    let selected = getSelectedOptionsTab();
    url = ROUTE_IDX + '?key=' + selected.join(',') + '&is_change=true';
    getListsByKey(url);
  });

  function getSelectedOptionsTab() {
    return $(".select-config option:selected").map(function() {
      return $(this).val();
    }).get();
  }
  function getListsByKey(url) {
    $.ajax({
      type: 'GET',
      url: url,
      success: function (response) {
        if (response.success) {
          $('#list-setting').html(response.html);
        } else {

        }
      },
      error: function (jQxhr) {
        if (jQxhr.status === 500) {
          showNotify(jQxhr['responseJSON'].message, 'error');
        }
      }
    })
  }

  $('body').on('change', '.input-update', function () {
    let inputValues = {};
    let data = {};
    let id = $(this).attr('data-id');
    let url = $(this).attr('data-url');
    let hasEmptyInput = false;

    $('.tab-config.active .input-update').each(function() {
      let inputName = $(this).attr('name');
      let inputValue = $(this).val();
      let type = $(this).data('value');
      let idError = inputName + '-' + id;
      let messages = '';

      if (inputValue === '') {
        hasEmptyInput = true;
        messages = VALIDATE_MESSAGE.required.replace(':attribute', inputName);
        showError(idError, messages)
      }

      if (type === 'string') {
        data['value'] = inputValue;
      }
      if (type === 'json') {
        inputValues[inputName] = inputValue;
        data['value'] = JSON.stringify(inputValues);
      }
    });
    if (!hasEmptyInput) {
      $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function (response) {
          if (response.success) {
            showNotify(response.message, 'success', true);
          } else {
            showNotify(response.message, 'error');
          }
        },
        error: function (jQxhr) {
          if (jQxhr.status === 422) {
            let errors = jQxhr["responseJSON"].data
            for (let [key, value] of Object.entries(errors)) {
              showError(key, value[0])
            }
          }
          if (jQxhr.status === 500) {
            showNotify(jQxhr['responseJSON'].message, 'error');
          }
        }
      })
    }
  })
});
