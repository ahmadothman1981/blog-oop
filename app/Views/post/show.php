<article>
    <h1><?=htmlspecialchars($post->title);?></h1>
    <p>Views: <?= $post->views; ?></p>
    
    <p><?= nl2br(htmlspecialchars($post->content)); ?></p>
</article>

<section>
    <h2>Comments</h2>
    <?php foreach($comments as $comment): ?>
        <article>
        <p><?= nl2br(htmlspecialchars($comment->content)); ?></p>
        <small>Posted On : <?= $comment->created_at; ?></small>
        </article>
    <?php endforeach; ?>
</section>