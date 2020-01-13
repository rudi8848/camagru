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
    <aside>
        <?php foreach($data['frames'] as $frame) :?>
            <label for="frame-<?=$frame['frame_id']?>">
                <input type="checkbox" id="frame-<?=$frame['frame_id']?>" class="frames">
                <img src="<?=$frame['path']?>" width="100px" id="image-frame-<?=$frame['frame_id']?>">
            </label>
        <?php endforeach;?>
    </aside>

  <button id="start">Turn on camera</button>
  <button id="snap">Snap Photo</button>
<div align="center">

<!--    <div class="video-wrapper">-->
    <div class="parent-container">
        <div class="img-container">
            <img src="/views/styles/frames/hair2.png" id="frame" style="display: none; position: absolute; bottom: 0px; left: 0px;" width="640" height="480" />
        </div>
        <div class="border-container">
            <div class="video-container">
                <video id="video" width="640" height="480" autoplay>Your browser is not supported</video>
            </div>
        </div>
    </div>



<!--    </div>-->
    <div class="canvas-wrapper">
        <canvas id="canvas">Your browser is not supported</canvas>
    </div>
</div>
<!--<img src="/views/styles/frames/hair2.png" id="frame" width="240">-->

  <p>Add description</p>
    <textarea name="description" id="description"></textarea>


<button onclick="submit()">Upload</button>


<?php endif ; ?>



<?php require_once('footer.php');?>
<script src="/views/new.js"></script>

