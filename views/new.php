<?php require_once('header.php');?>


<!--
  TEMPORARY CODE
  AFTER CREATION REDIRECT TO GALLERY/POST/ID
-->
<h1>Post creation</h1>
<!--<a href="/new">Add new post</a><hr>-->

<div id="error" style="display: none"></div>
<div id="success" style="display: none"></div>

<?php if (!empty($data['image'])) : ?>

  <div class="image">
    <img src="<?=$data['image']?>">
  </div>
  <p><?=$data['description']?></p>

<?php else: ?>

  <button id="start">Start</button>
<div class="video-wrapper">
  <video id="video" width="240" height="160" autoplay></video>
</div>
  <button id="snap">Snap Photo</button>
  <canvas id="canvas">Your browser is not supported</canvas>

<!---
  <form action="/new" method="post" enctype="multipart/form-data" id="new-shot">
  <input type="file" name="image" >
  <br/>
      <label for="filterGray">Monochrome
          <input type="checkbox" id="filterGray">
      </label>
      <label for="filterRed">Red filter
          <input type="checkbox" id="filterRed">
      </label>
      <label for="filterGreen">Green filter
          <input type="checkbox" id="filterGreen">
      </label>
      <label for="filterBlue">Blue filter
          <input type="checkbox" id="filterBlue">
      </label> <button type="submit">Upload</button>
  </form>
  -->
  <p>Add description</p>
  <input type="text" name="description" id="description">


<button onclick="submit()">Upload</button>


<?php endif ; ?>



<?php require_once('footer.php');?>
<script src="/views/new.js"></script>

