<?php require_once('header.php');?>

<div class="gallery">
<!--<h1>--><?//=$data['title']?><!--</h1>-->
    <?php include 'pagination.php'?>
<?php foreach ($data['posts'] as $post): ?>

<article>
    <h2><a class="post-author" href="/profile/<?=$post['user_id']?>"><?=$post['username']?></a></h2>
    <p class="post-date"><?php $date = new DateTime($post['created_at']); echo 'created '.$date->format('d.m.Y \a\t H:i')?></p>
    <br/>
    <p class="post-description"><?=$post['description']?> </p>
    <p class="post-image"><img src="<?=$post['image_path']?>"></p>
    <p><img src="/views/styles/pic/thumb.svg" width="25px" class="like" onclick="setLike(<?=$post['post_id']?>)"> <span class="post-likes" id="<?php echo 'likes-'.$post['post_id']?>"></span></p>

    <div class="post-comments" id="<?php echo 'comments-'.$post['post_id']?>">
        <?php if(isset($_SESSION['user']['id'])) : ?>
            <textarea id="new-comment-<?=$post['post_id']?>"></textarea>
            <button class="submit-comment" id="submit-comment-<?=$_SESSION['user']['id']?>-<?=$post['post_id']?>">Comment</button>
        <?php endif;?>

        <?php if (isset($data['comments'][$post['post_id']])) :?>
            <?php foreach ($data['comments'][$post['post_id']] as $comment) :?>
                <div class='comment'>
                    <a href='/profile/<?=$comment['author']?>' class='comment-author'><?=$comment['username']?></a>
                    <?php $date = new DateTime($comment['created_at']);?>
                    <p class='comment-date'><?=$date->format('d.m.Y H:i')?></p>
                    <p class='comment-content'><?=$comment['content']?></p>
                </div>
            <?php endforeach?>
        <?php endif; ?>

    </div>
</article>
<?php endforeach?>
    <?php include 'pagination.php'?>
</div>
<?php require_once('footer.php');?>


<script src="/views/getLikes.js"></script>
<script>

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



</script>