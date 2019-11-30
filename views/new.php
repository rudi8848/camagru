<?php require_once('header.php');?>


<!--
  TEMPORARY CODE
  AFTER CREATION REDIRECT TO GALLERY/POST/ID
-->
<h1>Post creation</h1>
<a href="/new">Add new post</a><hr>

<?php if (!empty($data['image'])) : ?>

  <div class="image">
    <img src="<?=$data['image']?>">
  </div>
  <p><?=$data['description']?></p>

<?php else: ?>

  <form action="/new" method="post" enctype="multipart/form-data" id="new-shot">
  <input type="file" name="image">
  <br/>
  <p>Add description</p>
  <input type="text" name="description">
  <button type="submit">Upload</button>
  </form>

<?php endif ; ?>



<?php require_once('footer.php');?>
