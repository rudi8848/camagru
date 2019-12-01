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

  function hasGetUserMedia() {
    return (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
  }

  if (hasGetUserMedia()) {
    console.log('norm media');
  } else {
    alert('getUserMedia is not supported by your browser');
  }

  var video = document.getElementById('video');

/*
  if (navigator.getUserMedia) {
    navigator.getUserMedia({audio: false, video: true}, function(stream){
      video.src = stream;
    }, onFailSoHard);
  } else if (navigator.webkitGetUserMedia) {
    navigator.webkitGetUserMedia('video', function(stream) {
      video.src = window.webkitUrl.createObjectUrl(stream);
    }, onFailSoHard);
  }
*/



  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {

    navigator.mediaDevices.getUserMedia({video:true}).then(function(stream){
      video.scrObject = stream;
      video.play();
    });
  } else { console.log('unsupported');}

  var canvas = document.getElementById('canvas');
  var context = canvas.getContext('2d');

  document.getElementById('snap').addEventListener('click', function() {
    context.drawImage(video, 0, 0, 240, 160);
  });

</script>
