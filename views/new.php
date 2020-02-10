<?php require_once('header.php');?>


<!--
  TEMPORARY CODE
  AFTER CREATION REDIRECT TO GALLERY/POST/ID
-->
<!--<h1>Post creation</h1>-->
<!--<a href="/new">Add new post</a><hr>-->

<div id="error" style="display: none"></div>
<div id="success" style="display: none"></div>

<?php //if (!empty($data['image'])) : ?>
<!---->
<!--  <div class="image">-->
<!--    <img src="--><?//=$data['image']?><!--">-->
<!--  </div>-->
<!--  <p>--><?//=$data['description']?><!--</p>-->
<!---->
<?php //else: ?>


    <aside class="frames-container" >
        <?php foreach($data['frames'] as $frame) :?>
            <div class="frame-item">
                <label for="frame-<?=$frame['frame_id']?>">
                    <input type="checkbox" id="frame-<?=$frame['frame_id']?>" class="frames">
                    <img src="<?=$frame['path']?>" width="100px" id="image-frame-<?=$frame['frame_id']?>">
                </label>
            </div>
        <?php endforeach;?>
    </aside>
<div align="center">



    <div class="buttons-container">
        <button id="start">Turn on camera</button>
        <button id="snap" style="display: none">Snap Photo</button>
        <button id="from-file" >Load from file</button>
        <form action="/new" method="post" style="display: none" id="loading-form" enctype="multipart/form-data">
            <input type="file" name="image">
<!--            <input type="file" name="loadedImage">-->
            <input type="submit" value="load">
        </form>
    </div>
<!--    <div class="video-wrapper">-->
    <div class="parent-container">
        <div class="img-container">
            <img src="/views/styles/frames/explode.png" id="frame" style="display: none; position: absolute; bottom: 0px; left: 0px;" width="640" height="480" />
        </div>
        <div class="border-container">
            <div class="video-container">
            <?php if(!empty($data['image'])):?>
                <img src="<?=$data['image']?>" width="640">
                <?php else:?>
                <video id="video" width="640" height="480" autoplay>Your browser is not supported</video>
                <?php endif;?>
            </div>
        </div>
    </div>



<!--    </div>-->
    <div class="canvas-wrapper" width="640px">
        <canvas id="canvas">Your browser is not supported</canvas>
    </div>

<!--<img src="/views/styles/frames/hair2.png" id="frame" width="240">-->

        <label for="description" class="input-title">Add a description</label><br/>
            <textarea name="description" id="description"></textarea>
        <br/>

        <button id="submit" onclick="submit()" style="display: none">Save</button>
    </div>

<?php //endif ; ?>



<?php require_once('footer.php');?>
<script src="/views/js/new.js"></script>

