// assets/js/tinymce_init.js
tinymce.init({
    selector: '#full_text, #summary', // Поля для редактирования полного текста и краткого содержания
    plugins: 'quickbars advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking table emoticons template paste help',
    toolbar: 'undo redo | formatselect alignleft aligncenter alignright alignjustify | fontsize bold italic underline strikethrough removeformat | bullist numlist | table image media link | hr',
    menubar: false, // Отключаем верхнее меню для упрощения интерфейса
    toolbar_mode: 'wrap',
    skin: 'oxide-dark',
    height: 400, // Высота текстового редактора
    branding: false, // Убираем брендинг TinyMCE
    content_css: './css/output.css', // Подключение кастомных стилей для отображения
    content_style: `
                    body { background-color: #1e1e1e; color: #d4d4d4; }
                  `,
    valid_elements: '*[*]', // Разрешаем сохранение всех элементов для сохранения форматирования
    entity_encoding: 'raw', // Кодировка для корректной обработки спецсимволов
    paste_as_text: false, // Сохраняет форматирование при вставке текста
    setup: function (editor) {
        editor.on('change', function () {
            editor.save(); // Автоматически сохраняем изменения в поле формы
        });
    }
});