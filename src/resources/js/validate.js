$(document).ready(function () {
  $(document).on('blur', '[validate="true"]', function () {
    let clientId = $(this)
    setTimeout(function () {
      clientId.val($.trim(clientId.val()))
    })
  })

  $(document).on('keyup change', '[validate="true"]', function () {
    // Remove errors
    $(this).removeClass('is-invalid')
    $(this).siblings('.text-danger').addClass('d-none')
    if ($(this).siblings('.icon-eye').length) {
      $(this).siblings('.icon-eye').removeClass('icon-eye-invalid')
    }

    let patterns = $(this).attr('validate-pattern').split('|')
    let name = $(this).attr('label')
    let message = ''

    $.each(patterns, function (key, pattern) {
      if (pattern.includes('required')) {
        message = validateMessage.required.replace(':attribute', name)

        return false
      }

      if (pattern.includes('email')) {
        const rules = /([a-z\d\.-]+)@([a-z\d-]+)(\.[a-z]{2,8}){1,}?$/
        if (!rules.test(value)) {
          message = validateMessage.email.replace(':attribute', name)

          return false
        }
      }
    })

    if (!name) {
      let idError = $(this).attr('name')
      showError(idError, message)
    }
  })
})

showError = function (id, error) {
  if (error.length > 0) {
    let el = $(`#error_${id}`)
    el.removeClass('d-none')
    el.addClass('text-danger')
    let listElInput = el.parent().children('input')
    $.each(listElInput, function (key, input) {
      if ($(input).attr('type') !== 'hidden' && $(input).attr('id') !== 'changePassword') {
        $(input).addClass('is-invalid')
      }
    })

    el.parent().children('textarea,select').addClass('is-invalid')
    if (id === 'f_password') {
      $('.icon-eye').addClass('icon-eye-invalid')
      el.parent().children('input').css('background-image', 'none')
    }

    el.text(error)
  }
}

// resetError
resetError = function () {
  $('[validate="true"]').removeClass('is-invalid')
  $('[validate="true"]').siblings('.text-danger').addClass('d-none')
}


checkValidate = ((form) => {
  let hasValidateError = $(`${form} input, select, textarea`).hasClass('is-invalid')
  if (hasValidateError) {
    $('div.spanner').addClass('show')
    setTimeout(() => {
      $("div.spanner").removeClass("show")
    }, 200)
  }
  return hasValidateError
})
