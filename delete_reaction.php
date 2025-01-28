<?php
include("config.php");
include("reactions.php");

if (!empty($_POST['id'])) {
    $id = intval($_POST['id']);
    Reactions::deleteReaction($id);
}

header("Location: index.php");
exit();
?>