$(document).ready(function () {
  let page = 1
  let lastPage = 1
  let folderId = null
  getFolders(folderId, page)
    .then(res => {
      if (res.data.data.length > 0) {
        $('#fill-media').html(res.html)
      }
    })

  $(document).on('click', '#btn-list', function () {
    resetInfoFolder()
    activeList()
    getFolders(folderId, page)
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
    getFolders(folderId, page)
      .then(res => {
        if (res.data.data.length > 0) {
          $('#fill-media').append(res.html)
          getListOrGrid()
        }
      })
    $('#btn-list').removeClass('active')
    $(this).addClass('active')
  })

  $(document).on('click', 'button.folder-container', function () {
    folderId = $(this).attr('data-id')
    $('.media-description').removeClass('d-none')
    getInfoFolder(folderId, page)
      .then(function(result) {
        getListOrGrid()
        if (result['is_directory']) {
          $('.media-thumbnail').addClass('item-border-bottom').find('i').removeClass('mdi-image').addClass('mdi-folder')
        } else {
          $('.media-thumbnail').addClass('item-border-bottom').find('i').removeClass('mdi-folder').addClass('mdi-image')
        }
        $('.media-name').find('p').html(result['name'])
        $('.media-size').find('p').html($(`.folder-container-${result['id']}`).find('.folder-size').text())
        // $('.media-full-url').find('p').html(result['full_url'])
        $('.media-uploaded-at').find('p').html(result['created_at'])
        $('.media-modified-at').find('p').html(result['updated_at'])
      })
  })

  $(document).on('dblclick', 'button.folder-container', function () {
    page = 1
    let folderName = $(this).find('.folder-name').text()
    folderId = $(this).attr('data-id')
    $("#fill-media").attr("data-parent_id", folderId)
    let isDirectory = $(this).attr('data-is_directory')
    if (isDirectory) {
      $('.media-description').removeClass('d-none')
      getFolders(folderId, page)
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
    getFolders(folderId, page)
      .then(res => {
        if (res.data.data.length > 0) {
          $('#fill-media').html(res.html)
          getListOrGrid()
        }
      })
    $('li.breadcrumb-item.mt-1.active').remove()
  })

  function getListOrGrid() {
      if ($('#btn-list').hasClass('active')) {
        activeList()
      } else {
        activeGrid()
      }
  }

  function resetInfoFolder() {
    page = 1
    folderId = $("#fill-media").attr("data-parent_id")
    $('#fill-media').html('')
    $('.media-name').find('p').html('')
    $('.media-size').find('p').html('')
    // $('.media-full-url').find('p').html(result['full_url'])
    $('.media-uploaded-at').find('p').html('')
    $('.media-modified-at').find('p').html('')
  }

  function activeList() {
    $('#main-folders').addClass('flex-column').find('.grid-view').removeClass('col-1 grid-view').addClass('col-12 list-view')
    $('.more-info-folder').removeClass('d-none')
    $('.folder-name-grid').removeClass('folder-name-grid')
    $(this).removeClass('active')
    $(this).addClass('active')
  }

  function activeGrid() {
    $('#main-folders').removeClass('flex-column').find('.list-view').removeClass('col-12 list-view').addClass('col-1 grid-view')
    $('.more-info-folder').addClass('d-none')
    $('.folder-name').addClass('folder-name-grid')
    $(this).removeClass('active')
    $(this).addClass('active')
  }

  function getInfoFolder(folderId) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        type: 'GET',
        url: route_show.replace('__folderId', folderId),
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
        getFolders(folderId, page)
          .then(res => {
            if (res.data.data.length > 0) {
              $('#fill-media').append(res.html)
              getListOrGrid()
            }
          })
      }
    }
  })

  function getFolders(folderId, page) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        type: 'GET',
        url: route_index,
        data: {
          id: folderId,
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

    for (let i = 0; i < files.length; i++) {
      formData.append('files[]', files[i]);
    }

    $.ajax({
      url: upload_file_url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
          console.log(response)
      },
      error: function(xhr, status, error) {

      }
    });
  });
})
