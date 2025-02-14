<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Новости</title>
    <style>
        
    </style>
</head>
<body>
    <section class="news">
        <h1 class="news__title">Новости</h1>
        <div id="news__container"></div> 
        <div class="pagination" id="pagination"></div>
    </section>
    <script>
    let currentPage = 1;
    let totalPages = 1; 

    async function fetchPosts(page = 1) {
        try {
            const response = await fetch(`https://test/includes/get_news.php?page=${page}`); 
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json(); 

            const postsContainer = document.getElementById('news__container'); 
            postsContainer.innerHTML = '';

            data.posts.forEach(post => {
                const postElement = document.createElement('div');
                const dateParts = post.date.split(' ')[0].split('-'); 
                const formattedDate = `${dateParts[2]}.${dateParts[1]}.${dateParts[0]}`;
                postElement.className = 'post';
                postElement.innerHTML = `<div class="post__info"><div class="post__date">${formattedDate}</div><h2 class="post__title">${post.title}</h2>${post.announce}</div><a class="post__more-info" href="http://test/news.php?post=${post.id}">Подробнее <img src="../images/assets/Arrow.png" style="transition: background 0.3s, color 0.3s;"></a>`;
                postsContainer.appendChild(postElement);
            });

            currentPage = data.current_page; 
            totalPages = data.total_pages; 
            updatePagination();

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('page', currentPage);
            window.history.pushState({}, '', '?' + urlParams.toString());
        } catch (error) {
            console.error('Ошибка при получении данных:', error);
        }
    }

    function updatePagination() {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = ''; 

    if (currentPage > 1) {
    const prevLink = document.createElement('a');
    prevLink.className = 'button-prev';
    prevLink.href = '#';

    const prevImage = document.createElement('img');
    prevImage.src = '../images/assets/ButtonArrow.png'; 
    prevImage.alt = 'Назад'; 
    prevImage.style.transform = 'rotate(180deg)';
    prevLink.appendChild(prevImage); 
    prevLink.addEventListener('click', (event) => {
        event.preventDefault();
        fetchPosts(currentPage - 1);
    });
    paginationContainer.appendChild(prevLink);
}

    for (let i = 1; i <= totalPages; i++) {
        const pageLink = document.createElement('a');
        pageLink.href = '#';
        pageLink.innerText = i;
        pageLink.className = (i === currentPage) ? 'active' : '';
        pageLink.addEventListener('click', (event) => {
            event.preventDefault();
            fetchPosts(i);
        });

        paginationContainer.appendChild(pageLink);
    }

    if (currentPage < totalPages) {
        const nextLink = document.createElement('a');
        nextLink.className = 'button-next';
        nextLink.href = '#';

        const nextImage = document.createElement('img');
        nextImage.src = '../images/assets/ButtonArrow.png';
        nextImage.alt = 'Далее';

        nextLink.appendChild(nextImage); 
        nextLink.addEventListener('click', (event) => {
            event.preventDefault();
            fetchPosts(currentPage + 1);
        });
        paginationContainer.appendChild(nextLink);
    }
    }


    const urlParams = new URLSearchParams(window.location.search);
    currentPage = urlParams.get('page') ? parseInt(urlParams.get('page')) : 1; 
    fetchPosts(currentPage); 
    </script>
</body>
</html>
