"use strict";
const WIDTH = 640;
const HEIGHT = 480;


let video = document.getElementById('video');


document.getElementById('start').addEventListener('click',async(e) => {
    try {

        const stream = await navigator.mediaDevices.getUserMedia({video: true});
        video.srcObject = stream;
        document.getElementById('snap').style.display = "inline-block";
        document.getElementById('frame').style.display = 'block';

    }catch (e) {
        // console.log(e);
        let errorMessage = document.getElementById('error');
        errorMessage.innerText = `Failed getting image from camera: ${e.message}`;
        errorMessage.style.display = 'block';
    }
});


const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

// const back = document.createElement('canvas');
// const backContext = back.getContext('2d');

let image = new Image();
let chosenFrame;

canvas.width = WIDTH;
canvas.height = HEIGHT;

document.getElementById('snap').addEventListener('click', function() {

    context.drawImage(video, 0, 0, WIDTH, HEIGHT);
    image.src = canvas.toDataURL();
    // backContext.drawImage(video, 0, 0, WIDTH, HEIGHT);
    context.drawImage(document.getElementById('frame'),0,0);

    document.getElementById('submit').style.display = "block";
    // console.log(image);
});


async function submit() {

    // let imageBlob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
    let imageData = image.src;

    let formData = new FormData();
    formData.append('description', document.getElementById('description').value.trim());
    formData.append('frame', chosenFrame);
    formData.append('image', imageData);

    let response = await fetch('/new', {
        method: 'POST',
        body: formData
    });

    let result = await response.json();
    let resultMessage = document.getElementById('success');
    resultMessage.innerText = result.result;
    resultMessage.style.display = 'block';
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
    document.getElementById('description').value = '';
}

window.onload = function () {

    const frames = document.getElementsByClassName('frames');

    for (let i = 0; i < frames.length; ++i) {
        frames[i].addEventListener('change', choseFrame, false);
    }
    frames[0].checked = true;
}

function choseFrame() {
    // console.log(this.checked);
    if (this.checked === true) {

        document.getElementById('snap').style.display = 'inline-block';
        const otherFrames = document.getElementsByClassName('frames');
        for (let i = 0; i < otherFrames.length; ++i) {
            if (otherFrames[i] !== this) {
                otherFrames[i].checked = false;
            }
        }

        const id = this.getAttribute('id');
        const image = document.getElementById('image-' + id);
        const source = image.getAttribute('src');
        chosenFrame = id;
        document.getElementById('frame').setAttribute('src', source);
        document.getElementById('frame').style.display = 'block';

    } else {
        document.getElementById('frame').style.display = 'none';
        document.getElementById('snap').style.display = 'none';
    }
}


let isVisible = false;

document.getElementById('from-file').addEventListener('click', function () {

    if (isVisible == false) {

        document.getElementById('loading-form').style.display = "block";
        isVisible = true;
    }
    else {
        document.getElementById('loading-form').style.display = "none";
        isVisible = false;
    }
})



document.getElementById('file').addEventListener('change', handleFileSelect, false);

function handleFileSelect(evt) {

//change to https://stackoverflow.com/questions/21227078/convert-base64-to-image-in-javascript-jquery
    const file = evt.target.files; // FileList object
    const f = file[0];

    // console.log(file);
    // console.log(f);


    // Only process image files.
    if (!f.type.match('image.*')) {

        let errorMessage = document.getElementById('error');
        errorMessage.innerText = "File must be an image";
        errorMessage.style.display = 'block';
    }
    const reader = new FileReader();
    // Closure to capture the file information.
    reader.onload = (function(theFile) {

        return function(e) {

            // const span = document.createElement('span');

            // span.innerHTML = ['<img width="640px" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
            // document.getElementById('output').insertBefore(span, null);

            document.getElementById('video-container').innerHTML = '<img width="640px" id="video" src="' + e.target.result+ '" />';
            const img = new Image();
            img.src = e.target.result;
            img.onload = () => {context.drawImage(img, 0, 0, WIDTH, HEIGHT);}

        };
    })(f);
    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
}