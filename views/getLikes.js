window.onload = function () {

    const posts = document.getElementsByClassName('post-likes');

    let ids = {};
    for (let i = 0; i < posts.length; ++i) {
        const id = posts[i].getAttribute('id');

        const postId = id.slice(id.indexOf('-') + 1);
            ids[i] = postId;
    }

    getLikesCount(ids);
    // getComments(ids);
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

async function getComments(postsIds) {

    let data = new FormData();
    data.append('json', JSON.stringify(postsIds));

    let response = await fetch('/posts/comments', {
        method: 'POST',
        body: data
    });

    let result = await response.json();
    // console.log(result);
    for (let post in result) {
        // console.log(result[post]);
        for (let comment in result[post]) {

            let div = document.createElement('div');
            let date =  new Date(result[post][comment]['created_at']);
            console.log(date);
            let formatted_date = date.getDate() + "." + (date.getMonth() + 1) + "." + date.getFullYear() + " " + date.getHours()+":"+date.getMinutes()
            console.log(formatted_date)
            div.className = "comment";
            div.innerHTML = "<a href='/profile/"+result[post][comment]['author']+"' class='comment-author'>"+result[post][comment]['username']+"</a>" +
                "<p class='comment-date'>"+formatted_date+"</p>" +
                " <p class='comment-content'>"+result[post][comment]['content']+"</p>";
            document.getElementById('comments-'+ post).append(div);

        }
    }
}

