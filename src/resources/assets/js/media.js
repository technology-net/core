$(document).ready(function () {
  let page = 1;
  let lastPage = 1;
  let folderId = null;
  let parent = null;
  let lastItemMediaId = null;

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

  $(document).on('click', '#btn-grid, .js-refresh', function () {
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
    $('#btn-grid').addClass('active')
  })

  $(document).on('click', 'button.folder-container', function (event) {
    folderId = $(this).attr('data-id');
    $('.media-description').removeClass('d-none');
    getInfoFolder(folderId, page)
      .then(function(result) {
        getListOrGrid()
        let showItem = result.is_directory ? `<i class="fas fa-folder folder-icon-color"></i>` : `<img width="150" src="${result.image_medium}" alt="${result.name}">`;
        $('.media-thumbnail').html(showItem)
        $('.media-name').find('p').html(result['name'])
        $('.media-size').find('p').html($(`.folder-container-${result['id']}`).find('.folder-size').text())
        $('.media-uploaded-at').find('p').html(formatDateString(result['created_at']))
        $('.media-modified-at').find('p').html(formatDateString(result['updated_at']))
      });
    handleActiveItem(event, this);
    $('#tooltip').hide();
    lastItemMediaId = $(this).data('id');
  })

  $(document).on('click', function (event) {
    if (!$(event.target).closest('button.folder-container').length) {
      $('button.folder-container').removeClass('active-item');
      resetBlockThumbnail();
      $('#tooltip').hide();
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
          'class': 'breadcrumb-item active',
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
    $('.media-thumbnail').html(`<i class="fas fa-image"></i>`);
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
    showLoading()
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
          hideLoading()
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
    let input = $(this).find('input[name="name"]');
    let value = $(input).val();
    let name = $(input).attr('name');
    let messages = '';
    if (value === '') {
      messages = VALIDATE_MESSAGE.required.replace(':attribute', name);
      showError(name, messages);
      return false;
    }
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
    if ($(this).data('avatar') != undefined) {
      $('.modal-insert').attr('data-avatar', true);
    }
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

    // Tìm vị trí của phần tử có id là lastItemMediaId trong mảng objMedia
    let index = objMedia.findIndex(function(item) {
      return item.id === lastItemMediaId;
    });
    // Nếu phần tử có id là lastItemMediaId tồn tại trong mảng
    if (index !== -1) {
      // Di chuyển phần tử lên đầu mảng
      let removedItem = objMedia.splice(index, 1)[0];
      objMedia.unshift(removedItem);
    }

    if (objMedia.length) {
      showLoading();
    }

    let html = ``;
    if ($(this).data('avatar') == true) {
      html += `
        <div class="preview-avatar">
          <img width="100%" src="${MEDIA_URL + objMedia[0].image_sm}" alt="${objMedia[0].name}">
          <i class="fas fa-camera" id="openMedia" data-avatar="true"></i>
          <input type="hidden" name="media_id" value="${objMedia[0].id}">
        </div>
      `;
      $('#wrap-avatar').html(html);
      hideLoading();
    } else {
      $.each(objMedia, function (_i, _item) {
        html += `
          <div class="col-md-4 item-thumbnail">
            <div class="preview-image">
                <img width="100%" src="${MEDIA_URL + _item.image_sm}" alt="${_item.name}">
                <i class="far fa-times-circle remove-preview"></i>
                <input type="hidden" name="media_id[]" value="${_item.id}">
            </div>
          </div>
        `;
      });
      $('#wrap-preview').html(html).find('.remove-preview').show();
      $(".item-thumbnail:first").addClass("active-item");
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
    }
  });

  if ($("#wrap-preview .preview-image img:first").attr("alt") !== 'image-default') {
    $(".item-thumbnail:first").addClass("active-item");
    if ($('#wrap-preview').height() >= 260) {
      $('#wrap-preview').addClass('thumbnail-scroll');
    }
    $('#wrap-preview').find('.remove-preview').show();
  }

  $('body').on('click', '.remove-preview', function (event) {
    event.stopPropagation();
    $(this).hide().closest('.item-thumbnail').remove();
    if ($('#wrap-preview img').length < 7) {
      $('#wrap-preview').removeClass('thumbnail-scroll');
    }
    if (!$('.item-thumbnail').length) {
      $('#wrap-preview').html(`
        <div class="col-md-4">
          <div class="preview-image">
              <img width="100%" src="/cms/images/image-default.png" alt="image-default">
              <i class="far fa-times-circle remove-preview"></i>
          </div>
      </div>
      `);
    }
  });

  // handle default thumbnail post
  $('body').on('click', '.item-thumbnail', function () {
    // Remove the active-item class from all thumbnails
    $(".item-thumbnail").removeClass("active-item");
    // Add the active-item class to the clicked thumbnail
    $(this).addClass("active-item");
    // Detach and prepend the clicked thumbnail to the wrapper
    $(this).detach().prependTo($("#wrap-preview"));
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

  $('body').on('contextmenu', 'button.folder-container', function (event) {
    event.preventDefault();
    handleActiveItem(event, this);
    $('#tooltip').css({
      top: (event.clientY - 55) + 'px',
      left: (event.clientX + 15) + 'px',
      display: 'block'
    });
  });

  $('body').on('click', '.copy-address',function () {
    let lastActive = $(".folder-container.active-item").last();
    if (!$(lastActive).data('is_directory')) {
      let dataMedia = $(lastActive).data('media');
      let imageUrl = MEDIA_URL + dataMedia.image_lg;
      let tempInput = $('<input>');
      $('body').append(tempInput);
      tempInput.val(imageUrl).select();
      document.execCommand("copy");
      tempInput.remove();
      Swal.fire({
        position: "top-end",
        title: 'Copied to clipboard',
        timer: 1000,
        showConfirmButton: false
      });
    }
  });

  $('body').on('click', '.tooltip-item',function () {
    let mediaActive = $(".folder-container.active-item");
    let ids = [];

    $.each($(mediaActive), function (_i, _item) {
        ids.push($(_item).data('id'));
    });

    $.ajax({
      url: $(this).data('url'),
      method: 'POST',
      data: {
        ids: ids
      },
      xhrFields: {
        responseType: 'blob'
      },
      success: function (data, textStatus, jqXHR) {
        let filename = jqXHR.getResponseHeader('Content-Disposition')
          ? /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(jqXHR.getResponseHeader('Content-Disposition'))?.[1]?.replace(/['"]/g, '')
          : "";
        let downloadLink = document.createElement('a');
        let url = window.URL.createObjectURL(data);
        downloadLink.href = url;
        downloadLink.download = filename;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(downloadLink);
      },
      error: function(xhr, status, error) {
        if (xhr.status === 500) {
          showNotify(xhr['responseJSON'].message, 'error');
        }
      }
    });
  });

  function handleActiveItem(event, _this) {
    // handle btn shift
    if (event.shiftKey) {
      $(_this).addClass('active-item');
    } else {
      if ($(event.target).hasClass('icon-check')) {
        // If clicking on the icon-check, remove the active-item class of that item
        $(_this).removeClass('active-item');
      } else {
        // Remove the active-item class from all button.folder-container elements
        $('button.folder-container').removeClass('active-item');
        // Add the active-item class to the current item
        $(_this).addClass('active-item');
      }
    }
  }
})
