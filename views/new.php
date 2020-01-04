<?php require_once('header.php');?>


<!--
  TEMPORARY CODE
  AFTER CREATION REDIRECT TO GALLERY/POST/ID
-->
<h1>Post creation</h1>
<a href="/new">Add new post</a><hr>

<div id="error" style="display: none"></div>

<?php if (!empty($data['image'])) : ?>

  <div class="image">
    <img src="<?=$data['image']?>">
  </div>
  <p><?=$data['description']?></p>

<?php else: ?>

  <button id="start">Start</button>
<div class="video-wrapper">
  <video id="video" width="500" height="400" autoplay></video>
</div>
  <button id="snap">Snap Photo</button>
  <canvas id="canvas"></canvas>


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
      </label>

  <p>Add description</p>
  <input type="text" name="description">
  <button type="submit">Upload</button>
  </form>

<?php endif ; ?>



<?php require_once('footer.php');?>
<script>
"use strict";
const WIDTH = 500;
const HEIGHT = 400;


let video = document.getElementById('video');


document.getElementById('start').addEventListener('click',async(e) => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({video: true});
        video.srcObject = stream;
    }catch (e) {
        console.log(e);
        let errorMessage = document.getElementById('error');
        errorMessage.innerText = `Failed getting image from camera: ${e.message}`;
        errorMessage.style.display = 'block';
    }
});


const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

const back = document.createElement('canvas');
const backContext = back.getContext('2d');

let image = new Image();

canvas.width = WIDTH;
canvas.height = HEIGHT;

document.getElementById('snap').addEventListener('click', function() {

    context.drawImage(video, 0, 0, WIDTH, HEIGHT);
    });


document.getElementById('filterGray').addEventListener('change', function(){
    let width =  video.clientWidth;

    let height = video.clientHeight;


    canvas.width = width;
    canvas.height = height;
    back.width = width;
    back.height = height;
    draw(video, context, backContext, width, height);
}, false);

function  draw(video, context, backContext, width, height) {

    backContext.drawImage(video, 0, 0, width, height);

    let idata = backContext.getImageData(0, 0, width, height);

    for (let i = 0; i < idata.data.length;  i += 4){
        let r = idata.data[i];
        let g = idata.data[i + 1];
        let b = idata.data[i + 2];

        let brightness = ( 3 * r + 4 * g + b)>>>3;
        idata.data[i] = brightness;
        idata.data[i + 1] = brightness;
        idata.data[i + 2] = brightness;
    }

    context.putImageData(idata, 0, 0);
}

</script>

