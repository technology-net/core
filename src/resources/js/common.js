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
})
