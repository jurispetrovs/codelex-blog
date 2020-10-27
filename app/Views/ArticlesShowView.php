<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $article->title(); ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <a href="/">Back</a>
    <h1><?php echo $article->title(); ?></h1>
    <p><?php echo $article->content(); ?></p>
    <small>
        <strong><?php echo $article->createdAt(); ?></strong>
    </small>

    <hr>
    <?php if (!empty($comments)): ?>
        <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <?php echo $comment->getName() ?>: <?php echo $comment->getComment(); ?>
                    <small><strong>(<?php echo $comment->getCreatedAt(); ?>)</strong></small>
                    <form action="/articles/<?= $article->id(); ?>/comments/delete" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="<?php echo $comment->getId(); ?>">
                        <button type="submit" onclick="return confirm('Are you sure ?');">x</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No comments</p>
    <?php endif; ?>
    <hr>

    <form action="/articles/<?= $article->id(); ?>/comments" method="post">
        <div>
            <label for="name"></label>
            <input type="text" id="name" name="name" class="commentator-name" placeholder="Name">
        </div>
        <div class="comment">
            <label for="comment"></label>
            <textarea id="comment" name="comment" placeholder="Write something"></textarea>
        </div>
        <div>
            <button type="submit" class="submit-comment">Submit</button>
        </div>
    </form>
</body>
</html>