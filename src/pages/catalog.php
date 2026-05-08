<?php
if (isset($_SESSION["user_avatar"])):
?>
    <img src="<?= $_SESSION["user_avatar"] ?>" alt="avatar">
<?php endif ?>