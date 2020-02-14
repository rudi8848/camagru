<?php require_once 'header.php';?>

<?php if (!empty($data['error'])):?>
    <div class="error"?><?=$data['error']?></div>
<?php endif;?>

<?php foreach ($data['users'] as $user):?>
<div>
    <img src="<?=$user['pic']?>" width="100px"><span><?=$user['username']?></span> <span><?=$user['email']?></span>
    <span><?php echo (int)$user['blocked'] == 1 ? "blocked" : "unblocked"?></span>
    <span><?php echo (int)$user['verified'] == 1 ? "verified" : "not verified"?></span>
    <button onclick="<?php echo (int)$user['blocked'] == 1 ? "unblockUser" : "blockUser";?>(<?=$user['user_id']?>)"><?php echo (int)$user['blocked'] == 1 ? "unblock" : "block";?> user</button>

</div>
<?php endforeach;?>

    <script src="/views/js/users.js"></script>
<?php require_once 'footer.php';?>