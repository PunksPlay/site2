document.addEventListener('DOMContentLoaded', () => {
    const loadMoreButton = document.getElementById('loadMore');
    let offset = 10;

    loadMoreButton.addEventListener('click', () => {
        fetch(`load_articles.php?offset=${offset}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.articles-list').insertAdjacentHTML('beforeend', data);
                offset += 10;
            })
            .catch(error => console.error('Ошибка загрузки:', error));
    });
});