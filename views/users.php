<?php require_once 'header.php';?>

<?php if (!empty($data['error'])):?>
    <div class="error"?><?=$data['error']?></div>
<?php endif;?>
<article>
<?php if (!empty($data['users'])):?>
<?php foreach ($data['users'] as $user):?>
<div class="wrapper">
    <div class="settings-item">
        <img src="<?=$user['pic']?>" width="100px">
    </div>

    <div class="settings-item">
        <a href="/profile/<?=$user['user_id'];?>"><?=$user['username']?></a>
        <p><?=$user['email']?></p>
        <p><?php echo (int)$user['blocked'] == 1 ? "blocked" : "unblocked"?>
        <?php echo (int)$user['verified'] == 1 ? "verified" : "not verified"?></p>
    </div>
    <div class="settings-item">
        <button id="blocker-<?=$user['user_id']?>" onclick="<?php echo (int)$user['blocked'] == 1 ? "unblockUser" : "blockUser";?>(<?=$user['user_id']?>, this.id)"><?php echo (int)$user['blocked'] == 1 ? "unblock" : "block";?> user</button>
    </div>
</div>
<?php endforeach;?>
<?php endif;?>
</article>
    <script src="/views/js/users.js"></script>
<?php require_once 'footer.php';?>