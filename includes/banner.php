<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section id="banner" class="banner">
        <div class="banner__content">
            <h1 id="banner__title">Загрузка...</h1>
            <p id="banner__description">Пожалуйста, подождите...</p>
            <img src="test/get_images.php?image=0cdfb0183c985bea52e35b50e99f0909.jpg" alt="" id="news_image">
        </div>
    </section>

    <script>
        async function fetchLatestNews() {
            try {
                const response = await fetch('https://test/includes/get_last.php');
                if (!response.ok) {
                    throw new Error('Сеть не отвечает');
                }
                const news = await response.json();
                displayNews(news);
            } catch (error) {
                console.error('Ошибка:', error);
                document.getElementById('banner__title').innerText = 'Ошибка загрузки новости';
                document.getElementById('banner__description').innerText = error.message;
                document.getElementById('banner').style.backgroundColor = '#ffcccc'; 
            }
        }

        function displayNews(news) {
            document.getElementById('banner__title').innerText = news.title;
            document.getElementById('banner__description').innerHTML = news.announce; 
            document.getElementById('banner').style.backgroundImage = `url("https://test/includes/get_images.php?image=${news.image}")`;
        }

        fetchLatestNews();
    </script>
</body>
</html>
