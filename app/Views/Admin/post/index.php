<h2>Manage Posts Admin</h2>
<a href="/admin/post/create">Create New Post</a>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Created at</th>
            <th>Action</th>
        </tr>
        <tbody>
            <?php foreach($posts as $post): ?>
                <tr>
                    <td>
                        <?=htmlspecialchars($post->title) ?>
                    </td>
                    <td><?= $post->created_at?></td>
                    <td>
                        <a href="/admin/post/<?= $post->id ?>/edit">Edit</a>
                        <form action="/admin/post/<?=$post->id?>/delete" method="post">
                            <?= csrf_token()?>
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                     </td>
                </tr>
            <?php endforeach?>
        </tbody>
    </thead>
</table>