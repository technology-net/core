$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
})

$(document).ready(function () {
  $('.nav-item.menu-items').each(function() {
    if ($(this).find('ul.sub-menu .active').length) {
      $(this).addClass('active')
      $(this).find('.collapse').addClass('show')
    }
  })

  $('body').on('change', '.editable', function () {
    let value = $(this).val();
    let label = $(this).attr('label');
    let name = $(this).attr('name');
    let id = $(this).attr('data-id');
    let url = $(this).attr('data-url');
    let idError = name + '-' + id;
    let messages = '';
    if (value === '') {
      messages = validateMessage.required.replace(':attribute', label);
      showError(idError, messages)
      return false;
    }
    let data = {
      [name]: value
    }

    $.ajax({
      type: 'POST',
      url: url,
      data: data,
      success: function (response) {
        if (response.success) {
          toastr.success(response.message)
          setTimeout(() => {
            window.location.reload();
          }, 2000)
        } else {
          toastr.error(response.message)
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
          toastr.error(jQxhr['responseJSON'].message)
        }
      }
    })
  })
})

formatDateString = function (dateString) {
  return dateString.replace("T", " ").replace(".000000Z", "");
}

showLoading = function () {
  $("#overlay").fadeIn(300);
}

hideLoading = function () {
  $("#overlay").fadeOut(300);
}
