<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h1>Articles</h1>
    <?php foreach ($articles as $article): ?>
        <hr>
        <h3>
            <a href="/articles/<?php echo $article->id(); ?>">
                <?php echo $article->title(); ?>
            </a>
        </h3>
        <form method="post" action="/articles/<?= $article->id(); ?>">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" onclick="return confirm('Are you sure ?');">Delete</button>
        </form>
        <p><?php echo $article->content(); ?></p>
        <p>
            <small>
                <?php echo $article->createdAt(); ?>
            </small>
        </p>
        <p>Likes: <?= $article->getLikes(); ?></p>
        <form action="/articles/<?= $article->id(); ?>/like" method="post">
            <button type="submit" name="like" value="1">Like</button>
            <button type="submit" name="like" value="-1">Dislike</button>
        </form>
    <?php endforeach; ?>
</body>
</html>