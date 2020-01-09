window.onload = function () {

    const posts = document.getElementsByClassName('post-likes');

    let ids = {};
    for (let i = 0; i < posts.length; ++i) {
        const id = posts[i].getAttribute('id');

        const postId = id.slice(id.indexOf('-') + 1);
            ids[i] = postId;
    }

     getLikesCount(ids);
}


async function getLikesCount(postsIds) {

    let data = new FormData();
    data.append('json', JSON.stringify(postsIds));

    let response = await fetch('/posts/likes', {
        method: 'POST',
        body: data
    });

    let result = await response.json();

    for (let post in result) {
        document.getElementById('likes-'+ post).innerText =  result[post];
    }
}

