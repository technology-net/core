$(document).ready(function () {
  let page = 1;
  let lastPage = 1;
  let folderId = null;
  let parent = null;
  let domain = location.origin;

  if (typeof IS_MEDIA !== 'undefined') {
    getFolders(folderId, page, parent)
      .then(res => {
        if (res.data.data.length > 0) {
          $('#fill-media').html(res.html);
        }
      });
  }

  $(document).on('click', '#btn-list', function () {
    resetInfoFolder()
    activeList()
    getFolders(folderId, page, parent)
      .then(res => {
        if (res.data.data.length > 0) {
          $('#fill-media').append(res.html)
          getListOrGrid()
        }
      })
    $('#btn-grid').removeClass('active')
    $(this).addClass('active')
  })

  $(document).on('click', '#btn-grid', function () {
    resetInfoFolder()
    activeGrid()
    getFolders(folderId, page, parent)
      .then(res => {
        if (res.data.data.length > 0) {
          $('#fill-media').append(res.html)
          getListOrGrid()
        }
      })
    $('#btn-list').removeClass('active')
    $(this).addClass('active')
  })

  $(document).on('click', 'button.folder-container', function (event) {
    folderId = $(this).attr('data-id');
    $('.media-description').removeClass('d-none');
    getInfoFolder(folderId, page)
      .then(function(result) {
        getListOrGrid()
        let showItem = result.is_directory ? `<i class="mdi mdi-folder folder-icon-color"></i>` : `<img width="150" src="${result.image_medium}" alt="${result.name}">`;
        $('.media-thumbnail').html(showItem)
        $('.media-name').find('p').html(result['name'])
        $('.media-size').find('p').html($(`.folder-container-${result['id']}`).find('.folder-size').text())
        $('.media-uploaded-at').find('p').html(formatDateString(result['created_at']))
        $('.media-modified-at').find('p').html(formatDateString(result['updated_at']))
      });
    // handle btn shift
    if (event.shiftKey) {
      $(this).addClass('active-item');
    } else {
      if ($(event.target).hasClass('icon-check')) {
        // If clicking on the icon-check, remove the active-item class of that item
        $(this).removeClass('active-item');
      } else {
        // Remove the active-item class from all button.folder-container elements
        $('button.folder-container').removeClass('active-item');
        // Add the active-item class to the current item
        $(this).addClass('active-item');
      }
    }
  })

  $(document).on('click', function (event) {
    if (!$(event.target).closest('button.folder-container').length) {
      $('button.folder-container').removeClass('active-item');
      resetBlockThumbnail();
    }
  });

  $(document).on('dblclick', 'button.folder-container', function () {
    page = 1
    let lastElement = $(".breadcrumb-item:last");
    parent = lastElement.find("a").attr("data-folder");
    let folderName = $(this).find('.folder-name').text()
    folderId = $(this).attr('data-id');
    $("#fill-media").attr("data-parent_id", folderId)
    let isDirectory = $(this).attr('data-is_directory')
    if (isDirectory) {
      $('.media-description').removeClass('d-none')
      getFolders(folderId, page, parent)
        .then(res => {
          $('#fill-media').html(res.html)
          getListOrGrid()
        })
      $('.folder-breadcrumb').append(
        $('<li/>', {
          'class': 'breadcrumb-item mt-1 active',
          html: $('<a/>', {
            href: '#',
            'data-folder': folderId,
            'class': 'change-folder',
            text: folderName
          })
        })
      )
    }
  })

  $(document).on('click', '.change-folder', function() {
    page = 1
    folderId = $(this).attr('data-folder')
    $("#fill-media").attr("data-parent_id", folderId)
    // remove breadcrumbs
    $(".change-folder").each(function() {
      if ($(this).data("folder") == folderId) {
        $(this).parent().nextAll().remove();
      }
    });
    let lastElement = $(".breadcrumb-item:last");
    parent = lastElement.prev().find("a").attr("data-folder");
    getFolders(folderId, page, parent)
      .then(res => {
        if (res.data.data.length > 0) {
          $('#fill-media').html(res.html)
          getListOrGrid()
        }
      })
  })

  function getListOrGrid() {
      if ($('#btn-list').hasClass('active')) {
        activeList()
      } else {
        activeGrid()
      }
  }

  function resetInfoFolder() {
    page = 1;
    folderId = $("#fill-media").attr("data-parent_id");
    $('#fill-media').html('');
    resetBlockThumbnail();
  }

  function resetBlockThumbnail() {
    $('.media-name').find('p').html('');
    $('.media-size').find('p').html('');
    $('.media-uploaded-at').find('p').html('');
    $('.media-modified-at').find('p').html('');
    $('.media-thumbnail').html(`<i class="mdi mdi-image"></i>`);
  }

  function activeList() {
    $('#main-folders').addClass('flex-column').find('.grid-view').removeClass('col-1 grid-view').addClass('col-12 list-view');
    $('.more-info-folder').removeClass('d-none');
    $('.folder-name-grid').removeClass('folder-name-grid').removeClass('text-ellipsis');
    $(this).removeClass('active');
    $(this).addClass('active');
  }

  function activeGrid() {
    $('#main-folders').removeClass('flex-column').find('.list-view').removeClass('col-12 list-view').addClass('col-1 grid-view');
    $('.more-info-folder').addClass('d-none');
    $('.folder-name').addClass('folder-name-grid').addClass('text-ellipsis');
    $(this).removeClass('active');
    $(this).addClass('active');
  }

  function getInfoFolder(folderId) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        type: 'GET',
        url: ROUTE_SHOW.replace('__folderId', folderId),
        data: {
          id: folderId
        },
        success: function(response)
        {
          resolve(response.data)
        },
        error: function(err) {
          reject(err)
        }
      })
    })
  }

  $('#scroll-folder').on('scroll', function () {
    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 10) {
      if (page < lastPage) {
        page++
        getFolders(folderId, page, parent)
          .then(res => {
            if (res.data.data.length > 0) {
              $('#fill-media').append(res.html)
              getListOrGrid()
            }
          })
      }
    }
  })

  function getFolders(folderId, page, parent) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        type: 'GET',
        url: MEDIA_IDX,
        data: {
          id: folderId,
          parent: parent,
          page
        },
        success: function(response)
        {
          lastPage = response.data.last_page
          resolve(response)
        },
        error: function(err) {
          reject(err)
        }
      })
    })
  }

  $('#input-file').on('change', function() {
    let formData = new FormData();
    let files = $(this)[0].files;
    formData.append('parent_id', $('#fill-media').attr('data-parent_id'))
    formData.append('parent', parent);

    for (let i = 0; i < files.length; i++) {
      formData.append('files[]', files[i]);
    }
    showLoading();
    $.ajax({
      url: UPLOAD_FILE_URL,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          $('#fill-media').html(response.html);
          showMessages(response.message);
          page = 1;
          if ($('#btn-list').hasClass('active')) {
            $('#btn-list').trigger('click');
          }
        } else {
          showNotify(response.message, 'error');
        }

        let id = response.data ? response.data.id : '';
        if (id) {
          $(`button.folder-container-${id}`).trigger('click');
        }
      },
      error: function(xhr, status, error) {
        if (xhr.status === 500) {
          showNotify(xhr['responseJSON'].message, 'error');
        }
      },
      complete: function () {
        $('#input-file').val('');
        hideLoading();
      }
    });
  });

  $('body').on('submit', '#create-folder-form', function (e) {
    e.preventDefault();
    let form = $(this);
    let formData = new FormData(form[0]);
    formData.append('parent_id', $('#fill-media').attr('data-parent_id'))
    formData.append('parent', parent);

    $.ajax({
      type: form.attr('method'),
      url: form.attr('action'),
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        $('#makeFolder').modal('hide');
        form[0].reset();
        if (response.success) {
          $('#fill-media').html(response.html);
          showMessages(response.message);
          page = 1;
          if ($('#btn-list').hasClass('active')) {
            $('#btn-list').trigger('click');
          }
        } else {
          showNotify(response.message, 'error');;
        }
      },
      error: function (jQxhr) {
        if (jQxhr.status === 500) {
          showNotify(jQxhr['responseJSON'].message, 'error');;
        }
      }
    })
  });

  $('body').on('hidden.bs.modal', '#makeFolder', function () {
    $('#create-folder-form')[0].reset();
  });

  $('body').on('click', '#openMedia', function () {
    getFolders(folderId, page, parent)
      .then(res => {
        if (res.data.data.length > 0) {
          $('#fill-media').html(res.html);
        }
      });
    $('#modalOpenMedia').modal('show');
  });

  $('body').on('click', '.modal-insert', function () {
    let mediaActive = $(".folder-container.active-item");
    let objMedia = [];
    $.each($(mediaActive), function (_i, _item) {
      if (!$(_item).attr('data-is_directory') && $(_item).attr('data-mime_type') == 'image/webp') {
        objMedia.push($(_item).data('media'))
      }
    });
    if (objMedia.length) {
      showLoading();
    }
    let html = ``;
    $.each(objMedia, function (_i, _item) {
      html += `
        <div class="col-md-4 item-thumbnail">
          <div class="preview-image">
              <img width="100%" src="${domain + '/storage' + _item.image_sm}" alt="${_item.name}">
              <i class="mdi mdi-close-circle-outline remove-preview"></i>
              <input type="hidden" name="media_id[]" value="${_item.id}">
          </div>
        </div>
      `;
    });
    $('#wrap-preview').html(html).find('.remove-preview').show();
    let images = $('#wrap-preview img');
    let imageCount = images.length;
    let imagesLoaded = 0;
    images.on('load', function () {
      imagesLoaded++;
      if (imagesLoaded === imageCount) {
        hideLoading();
        if ($('#wrap-preview').height() >= 260) {
          $('#wrap-preview').addClass('thumbnail-scroll');
        }
        if (imageCount < 7) {
          $('#wrap-preview').removeClass('thumbnail-scroll');
        }
      }
    });
  });

  $('body').on('click', '.remove-preview', function () {
    $(this).hide().closest('.item-thumbnail').remove();
    if ($('#wrap-preview img').length < 7) {
      $('#wrap-preview').removeClass('thumbnail-scroll');
    }
    if (!$('.item-thumbnail').length) {
      $('#wrap-preview').html(`
        <div class="col-md-4">
          <div class="preview-image">
              <img width="100%" src="${domain + '/cms/images/image-default.png'}" alt="image-default">
              <i class="mdi mdi-close-circle-outline remove-preview"></i>
          </div>
      </div>
      `);
    }
  });

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
