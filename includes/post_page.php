<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Post Viewer</title>
</head>
<body>
    <section id="post__container"></section>
    <script>
        const currentUrl = window.location.href;
        const myUrl = new URL(currentUrl);
        const postId = myUrl.searchParams.get('post');

        async function fetchPosts(postId) {
            try {
                const response = await fetch(`https://test/includes/get_post.php?post=${postId}`); 
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const post = await response.json(); 

                const postsContainer = document.getElementById('post__container'); 
                postsContainer.innerHTML = '';

                const postElement = document.createElement('div');
                const dateParts = post.date.split(' ')[0].split('-'); 
                const formattedDate = `${dateParts[2]}.${dateParts[1]}.${dateParts[0]}`;
                postElement.className = 'post';
                postElement.innerHTML = `
                    <p class="bread-crumps">Главная / ${post.title}</p>
                    <h2 class="title">${post.title}</h2>
                    <div class="post__content">
                    <div class="post__info">
                        <div class="post__date">${formattedDate}</div>
                        <h2 class="post__title">${post.announce}</h2>
                        ${post.content}
                    </div>
                    <img src="https://test/includes/get_images.php?image=${post.image}" class="post-image">
                    </div>
                    <a class="post__more-info" href="http://test/">
                        <img src="../images/assets/Arrow.png" style="transition: background 0.3s, color 0.3s; transform: rotate(180deg)"> Назад к новостям 
                    </a>
                `;
                postsContainer.appendChild(postElement);
            } catch (error) {
                console.error('Ошибка при получении данных:', error);
                const postsContainer = document.getElementById('news__container'); 
                postsContainer.innerHTML = `<p>Ошибка при загрузке поста. Пожалуйста, попробуйте позже.</p>`;
            }
        }

        if (postId) {
            fetchPosts(postId);
        } else {
            document.getElementById('news__container').innerHTML = '<p>Пост не найден. Убедитесь, что ID поста передан в URL.</p>';
        }
    </script>
</body>
</html>
