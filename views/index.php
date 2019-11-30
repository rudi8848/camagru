<?php require_once('header.php');?>

<a href="/new">Upload new photo</a><br/>
<?php foreach ($data['posts'] as $post): ?>
  <hr>
  <h2> <?=$post['description']?> </h2>
  <p><img src="<?=$post['image_path']?>"</p>
  <p><?=$post['created_at']?></p>

<?php endforeach?>

<?php require_once('footer.php');?>
