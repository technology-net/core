$(document).ready(function () {
  $('.btn-trigger-install-plugin').on('click', function(e) {
    e.preventDefault()
    let menu_items = $(this).attr('data-menu_items')
    let name_package = $(this).attr('data-name_package')
    let pluginId = $(this).attr('data-plugin_id')
    let data = {
      plugin_id: pluginId,
      menu_items,
      name_package
    }

    callAjax(route_install_package, data)
  })

  $('.btn-trigger-remove-plugin').on('click', function(e) {
    e.preventDefault()
    let name_package = $(this).attr('data-name_package')
    let pluginId = $(this).attr('data-plugin_id')
    let data = {
      plugin_id: pluginId,
      name_package
    }

    callAjax(route_uninstall_package, data)
  })

  function callAjax(url, data) {
    $.ajax({
      type: 'GET',
      url: url,
      data,
      success: function(response)
      {
        if (response.success) {
          toastr.success(response.message)
          setTimeout(() => {
            window.location.reload()
          }, 1000)
        }
      },
      error: function(jQxhr, textStatus, errorThrown)
      {
        if (jQxhr.status === 500) {
          toastr.error(jQxhr['responseJSON'].message)
        }
      }
    })
  }
})
