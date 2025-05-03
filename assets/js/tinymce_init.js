// assets/js/tinymce_init.js
tinymce.init({
    selector: '#full_text, #summary',
    plugins: [
        'undo', 'redo',
        'advlist', 'lists',
        'link', 'image', 'media',
        'charmap', 'hr', 'anchor',
        'searchreplace', 'visualblocks',
        'code', 'fullscreen',
        'table', 'emoticons',
        'removeformat',
        'superscript', 'subscript',
        'textcolor', 'fontsize'
    ].join(' '),

    toolbar: [
        'undo redo |',
        'formatselect fontsizeselect |',
        'bold italic underline strikethrough removeformat |',
        'alignleft aligncenter alignright alignjustify |',
        'bullist numlist |',
        'blockquote |',
        'table image media link hr charmap |',
        'forecolor backcolor'
    ].join(' '),

    menubar: false,
    toolbar_mode: 'wrap',
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',

    skin: 'oxide-dark',
    height: 400,
    branding: false,
    content_css: '../assets/css/output.css',

    // включаем обработчик загрузки изображений
    images_upload_url: '../public/image_upload.php',
    automatic_uploads: true,
    file_picker_types: 'image',

    // открываем файл-пикер, и TinyMCE сам вызовет ваш upload handler
    file_picker_callback: function(callback, value, meta) {
        if (meta.filetype === 'image') {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];
                var formData = new FormData();
                formData.append('file', file);

                fetch('/public/image_upload.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.location) {
                            callback(data.location, { alt: file.name });
                        } else {
                            console.error('Upload error:', data.error);
                        }
                    })
                    .catch(err => console.error('Fetch error:', err));
            };
            input.click();
        }
    },
    image_caption: true,
    valid_elements: '*[*]',
    entity_encoding: 'raw',
    paste_as_text: true,
    content_style: `
    body {
      background-color: #1e1e1e;
      color: #d4d4d4;
      padding: 10px;
    }
  `,
    setup: function (editor) {
        editor.on('change', function() {
            editor.save();
        });
    }
});