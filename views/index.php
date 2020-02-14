<?php require_once('header.php');?>

<div class="gallery">
<!--<h1>--><?//=$data['title']?><!--</h1>-->
    <?php include 'pagination.php'?>
<?php foreach ($data['posts'] as $post): ?>

<article>
    <?php if ($_SESSION['user']['role'] == 1) :?>
    <button class="userblocker" onclick="<?php echo (int)$post['blocked'] == 1 ? "unblockUser" : "blockUser";?>(<?=$post['user_id']?>)"><?php echo (int)$post['blocked'] == 1 ? "unblock" : "block";?> user</button>
    <?php endif;?>
    <?php if ((isset($_SESSION['user']['id']) && $post['user_id'] == $_SESSION['user']['id']) || $_SESSION['user']['role'] == 1): ?>
<!--    <a href="#" title="delete" class="delete-post">X</a>-->
    <button class="post-deleter" id="deleter-<?=$post['post_id']?>" onclick="deletePost(this)">X</button>
    <?php endif;?>
    <p>
        <img src="<?=$post['pic']?>" width="100px" class="post-pic"><a class="post-author" href="/profile/<?=$post['user_id']?>"><?=$post['username']?></a>
        <br/>
        <span class="post-date"><?php $date = new DateTime($post['created_at']); echo 'created '.$date->format('d.m.Y \a\t H:i')?></span>
    </p>
<!--    <br/>-->
    <p class="post-description"><?=$post['description']?> </p>
    <p class="post-image"><img src="<?=$post['image_path']?>"></p>
    <p><img src="/views/styles/pic/thumb.svg" width="25px" class="like" onclick="setLike(<?=$post['post_id']?>)"> <span class="post-likes" id="<?php echo 'likes-'.$post['post_id']?>"></span></p>

    <div class="post-comments" id="<?php echo 'comments-'.$post['post_id']?>">
        <?php if(isset($_SESSION['user']['id'])) : ?>
        <div class="comment-new-container clearfix">
            <textarea class="comment-new" id="new-comment-<?=$post['post_id']?>"></textarea>
            <button class="submit-comment" id="submit-comment-<?=$_SESSION['user']['id']?>-<?=$post['post_id']?>">Comment</button>
        </div>
            <?php endif;?>

        <?php if (isset($data['comments'][$post['post_id']])) :?>
        <div class="comments-all">
            <?php foreach ($data['comments'][$post['post_id']] as $comment) :?>
                <div class='comment'>
                    <img src="<?=$comment['pic']?>" width="50px" class="comment-author-pic">
                    <a href='/profile/<?=$comment['author']?>' class='comment-author'><?=$comment['username']?></a>
                    <?php $date = new DateTime($comment['created_at']);?>
                    <p class='comment-date'><?=$date->format('d.m.Y H:i')?></p>
                    <p class='comment-content'><?=$comment['content']?></p>
                </div>
            <?php endforeach?>
        </div>
        <?php endif; ?>

    </div>
</article>
<?php endforeach?>
    <div id="btnTop" hidden>Go up</div>
    <?php include 'pagination.php'?>
</div>
<?php require_once('footer.php');?>


<script src="/views/js/getLikes.js"></script>
<script src="/views/js/deletePost.js"></script>
<script src="/views/js/users.js"></script>
<script>

    btnTop.onclick = function() {
        window.scrollTo(pageXOffset, 0);
    };

    window.addEventListener('scroll', function() {
        btnTop.hidden = (pageYOffset < document.documentElement.clientHeight);
    });

</script>