$(document).ready(function () {
  /** Create a user **/
  $(document).on('submit', '#submitFormUser',function (e) {
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
      success: function (response) {
        if (response.success) {
          showNotify(response.message, 'success');
        } else {
          showNotify(response.message, 'error');
        }
      },
      error: function (jQxhr, textStatus, errorThrown) {
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

  let page

  $(document).on('click', '.pagination a', function(event) {
    event.preventDefault()
    page = $(this).attr('href').split('page=')[1]

    getMoreUsers(page)
  })

  /** Update a user **/
  $(document).on('submit', '#updateFormUser', function (e) {
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
      success: function (response) {
        if (response.success) {
          showNotify(response.message, 'success');
        } else {
          showNotify(response.message, 'error');
        }
      },
      error: function (jQxhr, textStatus, errorThrown) {
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

  /** Delete a user **/
  $(document).on('click', '.btn-delete-user', function() {
    let parent = $(this).parent()
    let rowIndex = $(this).closest('tr').index()
    Swal.fire({
      title: 'Delete this user',
      text: 'Are you sure you want to delete this user?',
      icon: 'error',
      showCancelButton: true,
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel',
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $('div.spanner').addClass('show')
        $.ajax({
          url: $(this).data('url'),
          method: 'Delete',
          cache: false,
          contentType: false,
          processData: false,
          success: function (response) {
            if (response.success) {
              showMessages(response.message);
              if (rowIndex === 0 && page !== 1) {
                parent.closest('tr').remove()
                page--
                getMoreUsers(page)
              } else {
                parent.closest('tr').remove()
              }
            } else {
              showNotify(response.message, 'error');
            }
          },
          error: function (jQxhr, textStatus, errorThrown) {
            if (jQxhr.status === 422 || jQxhr.status === 500) {
              showNotify(jQxhr['responseJSON'].message, 'error');
            }
          }
        })
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // Do on cancel
      }
    })
  })

  function getMoreUsers(page) {
    $.ajax({
      type: "GET",
      url: ROUTE_IDX + "?page=" + page,
      success:function(data) {
        $('#user-table').html(data)
      }
    })
  }

  function showMessages(message) {
    Swal.fire({
      position: "center",
      icon: 'success',
      title: message,
      showConfirmButton: false,
      timer: 1000,
    });
  }
})
