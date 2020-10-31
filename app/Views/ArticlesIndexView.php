<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h1>Articles</h1>
    <?php if(isset($_SESSION['auth_id'])): ?>
    <div class="authorization">
        <form method="post" action="/logout">
            <button type="submit">Logout</button>
        </form>
    </div>
    <?php else: ?>
    <div class="authorization">
        <form method="post" action="/register">
            <button type="submit">Register</button>
        </form>
        <form method="post" action="/login">
            <button type="submit">Login</button>
        </form>
    </div>
    <?php endif; ?>
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
        <form method="post" action="/articles/<?= $article->id(); ?>/like">
            <button type="submit" name="like" value="1">Like</button>
            <button type="submit" name="like" value="-1">Dislike</button>
        </form>
    <?php endforeach; ?>
</body>
</html>