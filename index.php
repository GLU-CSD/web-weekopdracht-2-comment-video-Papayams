<?php
include("config.php");
include("reactions.php");

$getReactions = Reactions::getReactions();

if(!empty($_POST)){
    $postArray = [
        'name' => $_POST['naam'],
        'email' => $_POST['email'],
        'message' => $_POST['commentaar']
    ];

    $setReaction = Reactions::setReaction($postArray);

    if(isset($setReaction['error']) && $setReaction['error'] != ''){
        prettyDump($setReaction['error']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube remake</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=twI61ZGDECBr4ums" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

    <h2>Hieronder komen reacties</h2>
    <form action="" method="post">
        <label for="name">Naam:</label>
        <input type="text" id="name" name="naam" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="message">Commentaar:</label>
        <textarea id="message" name="commentaar" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
</form>
    </form>

    <h3>Reactions:</h3>
    <ul>
        <?php foreach ($getReactions as $reaction): ?>
            <li>
                <strong><?php echo htmlspecialchars($reaction['name']); ?></strong> (<?php echo htmlspecialchars($reaction['email']); ?>): 
                <?php echo htmlspecialchars($reaction['message']); ?>
                <form action="delete_reaction.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $reaction['id']; ?>">
                    <input type="submit" value="Delete">
                </form>
                <form action="edit_reaction.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $reaction['id']; ?>">
                    <input type="submit" value="Edit">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

<?php
if (isset($con)) {
    $con->close();
}
?>