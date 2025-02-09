
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
   <link rel="stylesheet" href="/style.css"/>
</head>
<body>
    <header>
        <h1>My Blog</h1>
    </header>
    <nav>
        <a href="/">Home</a>
        <a href="/posts">Posts</a> 
    <?php  if($user): ?>
        <?php if(check('dashboard')): ?>
            <a href="/admin/dashboard">Admin</a>
        <?php endif; ?>
        <form action="/logout" method="post">
            <?= csrf_token(); ?>
            <button type="submit">Logout (<?= $user->email?>)</button>
        </form>
        <?php else: ?>
        <a href="/login">Login</a>
    <?php endif; ?>
    
    </nav>
    <main>
        <?=$content?>
    </main>
    <footer>
        &copy; <?=date('Y')?> My Blog
    </footer>
</body>
</html>
       