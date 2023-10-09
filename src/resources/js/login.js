$(document).ready(function () {
  $('#form_login').submit(function(e) {
    e.preventDefault()
    let form = $(this)
    let url = form.attr('action')
    let formData = new FormData(form[0])
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function(response)
      {
        if (response.success) {
          toastr.success(response.message)
          setTimeout(() => {
            window.location.href = dashboard_url
          }, 1000)
        }
      },
      error: function(jQxhr, textStatus, errorThrown)
      {
        if (jQxhr.status === 422) {
          let errors = jQxhr["responseJSON"].errors ?? jQxhr["responseJSON"].data;
          for (let [key, value] of Object.entries(errors)) {
            showError(key, value[0])
          }
        }

        if (jQxhr.status === 401) {
          toastr.error(jQxhr["responseJSON"].message)
        }
      }
    })
  })
})
