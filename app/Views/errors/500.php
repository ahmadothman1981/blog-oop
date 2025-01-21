<h1>Error 500</h1>
<p>Internal server error</p>
<p><?=htmlspecialchars($errorMessage) ; ?></p>
<?php if($isDebug): ?>
<p>Stack trace:</p>
<pre><?=htmlspecialchars($trace) ; ?></pre>
<?php endif; ?>

<p><a href="/">Home</a></p>
