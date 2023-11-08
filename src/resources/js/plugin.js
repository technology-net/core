$(document).ready(function () {
  $('.btn-trigger-install-plugin').on('click', function(e) {
    e.preventDefault()
    let menu_items = $(this).attr('data-menu_items')
    let name_package = $(this).attr('data-name_package')
    let plugin_id = $(this).attr('data-plugin_id')
    let composer_name = $(this).attr('data-composer_name')
    let version = $(this).attr('data-version')
    let data = {
      plugin_id,
      menu_items,
      name_package,
      composer_name,
      version
    }

    callAjax(route_install_package, data)
  })

  $('.btn-trigger-remove-plugin').on('click', function(e) {
    e.preventDefault()
    let menu_items = $(this).attr('data-menu_items')
    let name_package = $(this).attr('data-name_package')
    let plugin_id = $(this).attr('data-plugin_id')
    let composer_name = $(this).attr('data-composer_name')
    let version = $(this).attr('data-version')
    let data = {
      plugin_id,
      menu_items,
      name_package,
      composer_name,
      version
    }

    callAjax(route_uninstall_package, data)
  })

  function callAjax(url, data) {
    showLoading();
    $.ajax({
      type: 'GET',
      url: url,
      data,
      success: function(response)
      {
        if (response.success) {
          showNotify(response.message, 'success', true);
        } else {
          showNotify(response.message, 'error');
        }
      },
      error: function(jQxhr, textStatus, errorThrown)
      {
        if (jQxhr.status === 500) {
          showNotify(jQxhr['responseJSON'].message, 'error');
        }
      },
      complete: function () {
        hideLoading();
      }
    })
  }
})
