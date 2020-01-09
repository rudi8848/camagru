window.onload = function () {


    const posts = document.getElementsByClassName('post-likes');
    // console.log(posts);


    let ids = {};
    for (let i = 0; i < posts.length; ++i) {
        const id = posts[i].getAttribute('id');

        const postId = id.slice(id.indexOf('-') + 1);
            ids[i] = postId;
    }
    // console.log(JSON.stringify(arr));
    // sent fetch to db to get number of likes

     getLikesCount(ids);
    // console.log(likes);
    // document.getElementById(id).innerText = likes;
}

/*
*   будуємо масив з ай ді постів
* посилаємо усі зразу джейсоном
* отримуємо джейсон айді: лайки
* прикручуємо кількість лайків до ай ді
* */

async function getLikesCount(postsIds) {
    console.log(postsIds);

    let data = new FormData();
    data.append('json', JSON.stringify(postsIds));

    let response = await fetch('/posts/likes', {
        method: 'POST',
        body: data
    });

    let result = await response.json();

    console.log(result);
    for (let post in result) {
        document.getElementById('likes-'+ post).innerText =  result[post];
    }
}