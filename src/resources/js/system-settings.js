$(document).ready(function () {
  $('body').on('submit', '#formSubmit',function (e) {
    e.preventDefault()
    let form = $(this);
    let url = form.attr('action');
    let formData = new FormData(form[0]);
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success) {
          toastr.success(response.message)
          setTimeout(() => {
            window.location.href = ROUTE_IDX
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
              toastr.success(response.message)
              setTimeout(() => {
                window.location.href = ROUTE_IDX
              }, 2000)
            } else {
              toastr.error(response.message)
            }
          },
          error: function (jQxhr, textStatus, errorThrown) {
            if (jQxhr.status === 500) {
              toastr.error(jQxhr['responseJSON'].message)
            }
          }
        });
      }
    });
  });
});
