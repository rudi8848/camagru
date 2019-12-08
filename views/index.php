<?php require_once('header.php');?>

<div class="gallery">
<h1><?=$data['title']?></h1>
<?php foreach ($data['posts'] as $post): ?>
<article>
  <h2> <?=$post['description']?> </h2>
  <p><img src="<?=$post['image_path']?>" width="800"></p>
  <p><?=$post['created_at']?></p>
</article>
<?php endforeach?>
</div>
<?php require_once('footer.php');?>
