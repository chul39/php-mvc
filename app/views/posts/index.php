<!DOCTYPE html>
<html>
<head>    
    <meta charset="UTF-8">
</head>
<body>
    <h1>POSTS</h1>
    <ul>
        <?php foreach ($posts as $post): ?>
            <h2><?php echo $post['title'] ?></h2>
            <p><?php echo $post['content'] ?></p>
        <?php endforeach; ?>
    </ul>
</body>
</html>
