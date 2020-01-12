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
  <button id="snap">Snap Photo</button>
<div align="center">
    <div class="video-wrapper">
        <video id="video" width="240" height="160" autoplay></video>
    </div>
    <div class="canvas-wrapper">
        <canvas id="canvas">Your browser is not supported</canvas>
    </div>
</div>
<img src="/views/styles/frames/fire.png" id="frame" width="240">

  <p>Add description</p>
  <input type="text" name="description" id="description">


<button onclick="submit()">Upload</button>


<?php endif ; ?>



<?php require_once('footer.php');?>
<script src="/views/new.js"></script>

