"use strict";

async function blockUser(id) {
    console.log("block "+id);

    let resp = await fetch('block/'+id);

}

async function unblockUser(id) {
    console.log("unblock "+id);
    let resp = await fetch('unblock/' + id);
}