<article>
    <h1><?=htmlspecialchars($post->title);?></h1>
    <p>Views: <?= $post->views; ?></p>
    
    <p><?= nl2br(htmlspecialchars($post->content)); ?></p>
</article>

<section>
    <h2 id="comments">Comments</h2>
    <?php if($user && check('comment')): ?>
        <form action="/posts/<?= $post->id ?>/comments" method="post">
        <?= csrf_token(); ?>
        <textarea name="content" id="content" cols="5" rows="3"></textarea>
        <button type="submit">Comment</button>
        </form>
        <?php else: ?>
            <p><a href="/login">Login</a> to leave a comment</p>
        <?php endif; ?>
    <?php foreach($comments as $comment): ?>
        <article>
        <p><?= nl2br(htmlspecialchars($comment->content)); ?></p>
        <small>Posted On : <?= $comment->created_at; ?></small>
        </article>
    <?php endforeach; ?>
</section>