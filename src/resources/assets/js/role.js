$(document).ready(function() {
  $('body').on('change', '#permission-all', function () {
    $('.permission-item').prop('checked', this.checked);
  });

  $('body').on('change', '.permission-item',function () {
    let allChecked = $('.permission-item:checked').length === $('.permission-item').length;
    $('#permission-all').prop('checked', allChecked);
  });
});
