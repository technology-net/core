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
          showNotify(response.message, 'success');
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
});
