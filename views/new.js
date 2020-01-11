"use strict";
const WIDTH = 640;
const HEIGHT = 480;


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
    context.drawImage(document.getElementById('frame'),0,0);
});


/*document.getElementById('filterGray').addEventListener('change', function(){
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
}*/

async function submit() {
    let imageBlob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));

    let formData = new FormData();
    formData.append('description', document.getElementById('description').value);
    formData.append('image', imageBlob, 'image.png');

    let response = await fetch('/new', {
        method: 'POST',
        body: formData
    });

    let result = await response.json();
    let resultMessage = document.getElementById('success');
    resultMessage.innerText = result.result;
    // console.log(result);
    resultMessage.style.display = 'block';
}