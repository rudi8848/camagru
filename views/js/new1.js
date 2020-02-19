"use strict";
const WIDTH = 640;
const HEIGHT = 480;

let photo = new Image();
let oldImg;
document.getElementById('start').addEventListener('click',async(e) => {

try {

    const video = document.getElementById('video')
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

document.getElementById('snap').addEventListener('click', function() {

    oldImg = photo;
    photo = new Image();

    let canvas = document.getElementById('canvas');
    let context = canvas.getContext('2d');

    canvas.width = WIDTH;
    canvas.height = HEIGHT;

    context.drawImage(oldImg, 0, 0, WIDTH, HEIGHT);
    photo.src = canvas.toDataURL();

    context.drawImage(document.getElementById('frame'), 0, 0);

    document.getElementById('submit').style.display = "block";

});

let chosenFrame;

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

    const file = evt.target.files; // FileList object
    const f = file[0];



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
            photo = new Image();
            photo.src = e.target.result;

            let canvas = document.getElementById('canvas');
            let context = canvas.getContext('2d');
            canvas.width = WIDTH;
            canvas.height = HEIGHT;
            photo.onload = () => {context.drawImage(photo, 0, 0, WIDTH, HEIGHT);}

            document.getElementById('snap').style.display = "inline-block";
            document.getElementById('frame').style.display = 'block';
        };
    })(f);
    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
}


async function submit() {

    // let imageBlob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
    let imageData = oldImg.src;

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
    // resultMessage.innerText = result.result;
    resultMessage.innerHTML = '<img src="' + result.img + '">';
    console.log(result);
    resultMessage.style.display = 'block';
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
    document.getElementById('description').value = '';
}
