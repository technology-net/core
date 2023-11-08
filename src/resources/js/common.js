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
  })

  $('body').on('click', '.btn-delete', function() {
    Swal.fire({
      text: DELETE_CONFIRM,
      icon: 'error',
      showCancelButton: true,
      confirmButtonText: BTN_CONFIRM,
      cancelButtonText: BTN_CANCEL,
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: $(this).data('url'),
          method: 'Delete',
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
          error: function (jQxhr, textStatus, errorThrown) {
            if (jQxhr.status === 500) {
              showNotify(jQxhr['responseJSON'].message, 'error');
            }
          }
        });
      }
    });
  });
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

showNotify = function (title, icon, isReload = false) {
  Swal.fire({
    position: "center",
    icon: icon,
    title: title,
    timer: 2000,
    timerProgressBar: true,
    showConfirmButton: false
  }).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer) {
      if (icon === 'success') {
        if (isReload ) {
          location.reload();
        } else {
          location.href = ROUTE_IDX
        }
      }
    }
  });
}