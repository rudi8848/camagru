<?php require_once 'header.php'?>

<article>

    <div class="wrapper">
        <div class="settings-item">Change user picture</div>
        <div class="settings-item"><img src="<?=$data['settings']['pic']?>" width="100px"> </div>
        <div class="settings-item">

            <form action="/change-picture" enctype="multipart/form-data" method="post">
            <input type="file" name="image">
            <input type="submit" name="submit">
                <small>2 Mb maximum</small>
            </form>
        </div>
        <div class="settings-item">Name</div>
        <div class="settings-item" id="settings-name"><?=$_SESSION['user']['name']?>
            <div id="settings-name-form" style="display: none">
                <form action="/change-name" method="post">
                    <input type="text" name="name">
                    <input type="submit" name="submit">
                </form>
            </div>
        </div>
        <div class="settings-item"><a href="" onclick="changeName(event)">edit</a></div>

        <div class="settings-item">Email</div>
        <div class="settings-item"> <?=$data['settings']['email']?>
            <div id="settings-email-form" style="display: none">
                <form action="/change-email" method="post">
                    <input type="text" name="email">
                    <input type="submit" name="submit">
                </form>
            </div>
        </div>
        <div class="settings-item"><a href="" onclick="changeEmail(event)">edit</a></div>


        <div class="settings-item">Password</div>
        <div class="settings-item">
            <div id="settings-password-form" style="display: none">
                <form action="/change-password" method="post">
                    <label>Current password
                    <input type="password" name="oldPassword" required></label><br/>
                    <label>New password
                    <input type="password" name="newPassword1" required></label><br/>
                    <label>Repeat new password
                    <input type="password" name="newPassword2" required></label>
                    <input type="submit" name="submit">
                </form>
            </div>
        </div>
        <div class="settings-item"><a href=""  onclick="changePassword(event)">edit</a></div>
        <div class="settings-item"><label for="notifications">
            Receive notifications about new comments</label></div>
        <div class="settings-item"><input type="checkbox" id="notifications" name="notifications" <?php if($data['settings']['notifications'] == 1) echo "checked";?>>
        </div>
    </div>

</article>
<script src="/views/settings.js"></script>
<?php require_once 'footer.php'?>
