<?php require_once('header.php');?>

<div class="gallery">
<!--<h1>--><?//=$data['title']?><!--</h1>-->
<?php foreach ($data['posts'] as $post): ?>

<article>
    <h2><a class="post-author" href="/profile/<?=$post['user_id']?>"><?=$post['username']?></a></h2>
    <p class="post-date"><?php $date = new DateTime($post['created_at']); echo 'created '.$date->format('d.m.Y \a\t H:i')?></p>
    <br/>
    <p class="post-description"><?=$post['description']?> </p>
    <p class="post-image"><img src="<?=$post['image_path']?>"></p>
    <p class="post-likes" id="<?php echo 'likes-'.$post['post_id']?>"></p>
    <p class="post-comments" id="<?php echo 'comments-'.$post['post_id']?>"></p>
</article>
<?php endforeach?>
</div>
<?php require_once('footer.php');?>
<script src="/views/getLikes.js"></script>