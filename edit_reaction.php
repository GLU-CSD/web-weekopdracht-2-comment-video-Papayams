<?php
include("config.php");
include("reactions.php");

if (!empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $reaction = Reactions::getReactionById($id);
}

if (!empty($_POST['update'])) {
    $postArray = [
        'id' => $_POST['id'],
        'name' => $_POST['naam'],
        'email' => $_POST['email'],
        'message' => $_POST['commentaar']
    ];
    Reactions::updateReaction($postArray);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reaction</title>
</head>
<body>
    <h2>Edit Reaction</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $reaction['id']; ?>">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" value="<?php echo htmlspecialchars($reaction['name']); ?>" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reaction['email']); ?>" required><br><br>
        
        <label for="commentaar">Commentaar:</label>
        <textarea id="commentaar" name="commentaar" required><?php echo htmlspecialchars($reaction['message']); ?></textarea><br><br>
        
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>