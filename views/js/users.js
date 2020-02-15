"use strict";

async function blockUser(id, element) {

    let resp = await fetch('block/'+id);
    document.getElementById(element).innerText = "unblock user";

    document.getElementById(element).onclick = function() { unblockUser(id, element); };
}

async function unblockUser(id, element) {

    let resp = await fetch('unblock/' + id);
    document.getElementById(element).innerText = "block user";

    document.getElementById(element).onclick = function() { blockUser(id, element); };
}