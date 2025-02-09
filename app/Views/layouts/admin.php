
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
        <h1>Dashboard</h1>
    </header>
    <nav>
        <a href="/Admin/dashboard">Dashboard</a>
        <a href="/admin/posts"> Manage Posts</a>     
        <form action="/logout" method="post">
            <?= csrf_token(); ?>
            <button type="submit">Logout (<?= $user->email?>)</button>
        </form>         
    </nav>
    <main>
        <?=$content?>
    </main>
    <footer>
        &copy; <?=date('Y')?> My Blog - Admin Panel
    </footer>
</body>
</html>
       