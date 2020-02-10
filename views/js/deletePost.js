"use strict";

async function deletePost(elem) {


    const id = elem.getAttribute("id");

    const postId = id.slice(id.lastIndexOf('-') + 1);

    let formData = new FormData();
    formData.append('post', postId);

    let response = await fetch('/post/delete', {
        method: 'POST',
        body: formData
    });

    let result = await response.json();
    let post = elem.parentNode;
    if (result['error'] == false) {

        post.style.display = "none";
    } else {
        let errorMsg = document.createElement('div');
        errorMsg.className = 'error';

        if(result['message']) {

            errorMsg.innerText = result['message'];
        }
        post.insertBefore(errorMsg, elem);
    }
}