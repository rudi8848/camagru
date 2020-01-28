"use strict";

function changeName(event) {

    event.preventDefault();

    const form = document.getElementById('settings-name-form');
    form.style.display = 'block';
}

function changeEmail(event) {

    event.preventDefault();

    const form = document.getElementById('settings-email-form');
    form.style.display = 'block';

}

function changePassword(event) {

    event.preventDefault();

    const form = document.getElementById('settings-password-form');
    form.style.display = 'block';

}

notifications.addEventListener('change', changeNotificationSettings);

async function changeNotificationSettings() {

    let formData = new FormData();

    formData.append('notifications', this.checked);

    let response = await fetch('/notifications', {
        method: 'POST',
        body: formData
    });

    let result = await response.json();

}