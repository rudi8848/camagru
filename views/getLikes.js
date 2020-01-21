window.onload = function () {

    const posts = document.getElementsByClassName('post-likes');

    let ids = {};
    for (let i = 0; i < posts.length; ++i) {
        const id = posts[i].getAttribute('id');

        const postId = id.slice(id.indexOf('-') + 1);
            ids[i] = postId;
    }

    getLikesCount(ids);

    const commentBtns = document.getElementsByClassName("submit-comment");

    for (let i = 0; i < commentBtns.length; ++i) {
        commentBtns[i].addEventListener('click', submitComment, false);
    }
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


async function setLike(postId) {

    let data = new FormData();
    data.append('json', JSON.stringify({'post' : postId}));

    let response = await fetch('/post/setlike', {
        method: 'POST',
        body: data
    });

    let result = await response.json();
    let code = parseInt(result['inserted']);
    let element = document.getElementById('likes-'+postId);
    let likes = parseInt(element.innerText);
    if (isNaN(likes)) likes = 0;
    likes += code;
    element.innerText = likes;

}

async function submitComment(){

    const id = this.getAttribute("id");

    const postId = id.slice(id.lastIndexOf('-') + 1);

    const msg = document.getElementById('new-comment-'+postId).value.trim();

    if (msg === "") return ;

    let formData = new FormData();
    formData.append('comment', msg);
    formData.append('post', postId);

    let response = await fetch('/posts/comment', {
        method: 'POST',
        body: formData
    });

    let result = await response.json();

    let content = document.createElement('div');
    content.className = 'comment';

    if(result['content']) {
        document.getElementById('new-comment-'+postId).value = '';

        content.innerHTML = '<img src="'+ result['pic'] +'" width="50px" class="comment-author-pic"><a href="/profile/' + result['id'] + '" class="comment-author">' + result['author'] + '</a>' +
            '<p class="comment-date">' + result['date'] + '</p>' +
            '<p class="comment-content">' + result['content'] + '</p>';

    } else{
        content.innerText = "Error";
    }
    document.getElementById('comments-'+postId).append(content);
}

