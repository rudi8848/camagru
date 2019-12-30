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

  <button id="start">Start</button>
  <video id="video" width="240" height="160" autoplay></video>
  <button id="snap">Snap Photo</button>
  <canvas id="canvas" width="240" height="160"></canvas>


  <form action="/new" method="post" enctype="multipart/form-data" id="new-shot">
  <input type="file" name="image" >
  <br/>
  <p>Add description</p>
  <input type="text" name="description">
  <button type="submit">Upload</button>
  </form>

<?php endif ; ?>



<?php require_once('footer.php');?>
<script>

document.getElementById('start').addEventListener('click',async(e) => {
    const stream = await navigator.mediaDevices.getUserMedia({video: true})
    document.getElementById('video').srcObject = stream;
});

 var canvas = document.getElementById('canvas');
 var context = canvas.getContext('2d');

 document.getElementById('snap').addEventListener('click', function() {
    context.drawImage(video, 0, 0, 240, 160);
    });
</script>
