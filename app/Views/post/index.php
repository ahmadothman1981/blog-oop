
<h1>Welcome To My Blog</h1>
<h2>All  Posts</h2>
<form action="" method="get">
    <input type="text" name="search" placeholder="Search Posts" value="<?=htmlspecialchars($search)?>"/>
    <button type="submit">Search</button>
</form>
<?= partial('_posts' , ['posts' => $posts]) ?>