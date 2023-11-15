$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
})
// active sidebar if exist childrent
if ($('.nav-link.active').closest('.nav-treeview').length) {
  $('.nav-link.active').closest('.nav-treeview').parent().addClass('menu-open');
}
$(document).ready(function () {
  $('.nav-item.menu-items').each(function() {
    if ($(this).find('ul.sub-menu .active').length) {
      $(this).addClass('active')
      $(this).find('.collapse').addClass('show')
    }
  })

  $('body').on('change', '.editable', function () {
    let value = $(this).val();
    let name = $(this).attr('name');
    let id = $(this).attr('data-id');
    let url = $(this).attr('data-url');
    let idError = name + '-' + id;
    let messages = '';
    if (value === '') {
      messages = VALIDATE_MESSAGE.required.replace(':attribute', name);
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

  var selectedValues = [];
  // Click event for the "input-check-all" checkbox
  $('body').on('change', '.input-check-all', function () {
    if ($(this).is(':checked')) {
      $('.checkboxes').prop('checked', true);
      selectedValues = $('.checkboxes:checked').map(function() {
          return $(this).val();
      }).get();
      if (selectedValues.length > 0) {
        $(".delete-all").removeClass("d-none");
      } else {
        $(".delete-all").addClass("d-none");
      }
    } else {
      $('.checkboxes').prop('checked', false);
      $('.delete-all').addClass('d-none');
      selectedValues = [];
    }
  });

  // Click event for individual checkboxes
  $('body').on('change', '.checkboxes',function () {
    let value = $(this).val();
    if ($(this).is(':checked')) {
      selectedValues.push(value);
    } else {
      let index = selectedValues.indexOf(value);
      if (index !== -1) {
          selectedValues.splice(index, 1);
      }
    }
    if (selectedValues.length > 0) {
      $('.delete-all').removeClass('d-none');
    } else {
      $('.delete-all').addClass('d-none');
      $('.input-check-all').prop('checked', false);
    }
  });

  // Click event for the "delete-all" button
  $('body').on('click', '.delete-all',function () {
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
          method: 'POST',
          data: {
            ids: selectedValues
          },
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
    timer: 1500,
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

// datatable
if ($('#dataTable').length) {
  $('#dataTable').DataTable({
    'ordering':false
  });
}
