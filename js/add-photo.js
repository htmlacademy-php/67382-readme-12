(function () {
  var fileChooser = document.querySelector('#file-photo');
  var classNamePart;
  if (fileChooser) {
    classNamePart = 'adding-post';
  } else {
    fileChooser = document.querySelector('#file-userpic');
    if (fileChooser) {
      classNamePart = 'registration';
    }
  }
  if (fileChooser) {
    var previewArea = document.querySelector('.js-preview');
    var dropArea = document.querySelector('.js-dropzone');
    var currentFile = document.querySelector('.js-preview-img');
    var errorWrap = document.querySelector('.js-file-error');
    if (!currentFile) {
      currentFile = false;
    }
    var queue = [];
    var file;
    var FILE_TYPES = ['gif', 'jpg', 'jpeg', 'png'];
    var isError = false;

    fileChooser.addEventListener('change', function () {
      file = this.files[0];
      processFile(file);
    });

    dropArea.addEventListener('dragover', function(evt) {
      evt.stopPropagation();
      evt.preventDefault();
      evt.dataTransfer.dropEffect = 'copy';
    }, false);

    dropArea.addEventListener('drop', function(evt) {
      evt.stopPropagation();
      evt.preventDefault();
      file = evt.dataTransfer.files[0];
      processFile(file);
    }, false);

    function previewFile(file) {

      var reader = new FileReader();

      reader.addEventListener("load", function(event) {
        var fileName = file.name.toLowerCase();
        if (!currentFile) {
          var filePreview = document.createElement("div");
          var fileWrap = document.createElement("div");
          fileWrap.classList.add(classNamePart + "__image-wrapper");
          fileWrap.classList.add("form__file-wrapper");
          currentFile = document.createElement('img');
          currentFile.setAttribute('src', reader.result);
          currentFile.setAttribute('alt', fileName);
          currentFile.classList.add('form__image');
          currentFile.classList.add('js-preview-img');
          fileWrap.appendChild(currentFile);
          filePreview.appendChild(fileWrap);
          previewArea.appendChild(filePreview);
          var filePreviewData = document.createElement("div");
          filePreviewData.classList.add(classNamePart + "__file-data");
          filePreviewData.classList.add("form__file-data");
          filePreviewData.innerHTML = '<span class="' + classNamePart + '__file-name form__file-name">' + fileName + '</span><button class="' + classNamePart + '__delete-button form__delete-button button js-del-img" type="button"><span>Удалить</span><svg class="' + classNamePart + '__delete-icon form__delete-icon" viewBox="0 0 18 18" width="12" height="12"><path d="M18 1.3L16.7 0 9 7.7 1.3 0 0 1.3 7.7 9 0 16.7 1.3 18 9 10.3l7.7 7.7 1.3-1.3L10.3 9z"></path></svg></button>';
          filePreview.appendChild(filePreviewData);

          var delPreviewBtn = filePreview.querySelector(".js-del-img");
          var delPreviewBtnHandler = function(event) {
            event.preventDefault();
            delPreviewBtn.removeEventListener("click", delPreviewBtnHandler);
            removePreview(filePreview);
          }
          delPreviewBtn.addEventListener("click", delPreviewBtnHandler);
        } else {
          currentFile.src = reader.result;
        }

        queue.push({
          "file": file,
          "filePreview": filePreview
        });

      });

      reader.readAsDataURL(file);
    }

    function removePreview(filePreview) {
      queue = queue.filter(function(element) {
        return element.filePreview != filePreview;
      });
      filePreview.parentNode.removeChild(filePreview);
      currentFile = false;
    }

    function setError() {
      isError = true;
      errorWrap.classList.add('form__input-section--error');
      errorWrap.setAttribute('style', 'border: 2px solid #f02323!important;border-radius: 10px!important;');
      errorWrap.querySelector('.form__error-desc').textContent = 'Загрузите изображение в формате jpeg, png или gif';
    }

    function removeError() {
      isError = false;
      errorWrap.classList.remove('form__input-section--error');
      errorWrap.removeAttribute('style');
    }

    function processFile(file) {
      var matches = FILE_TYPES.some(function (it) {
        return file.name.endsWith(it);
      });
      if (matches) {
        if (isError) {
          removeError();
        }
        previewFile(file);
      } else {
        if (!isError) {
          setError();
        }
      }
    }
  }

})();
