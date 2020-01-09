<?php require_once('header.php');?>

<div class="gallery">
<!--<h1>--><?//=$data['title']?><!--</h1>-->
<?php foreach ($data['posts'] as $post): ?>
<article>
  <h2> <?=$post['description']?> </h2>
  <p><img src="<?=$post['image_path']?>" width="800"></p>
    <p><a class="author" href="/profile/<?=$post['user_id']?>"><?=$post['username']?></a> <?php $date = new DateTime($post['created_at']); echo 'created '.$date->format('d.m.Y \a\t H:i')?></p>
</article>
<?php endforeach?>
</div>
<?php require_once('footer.php');?>
