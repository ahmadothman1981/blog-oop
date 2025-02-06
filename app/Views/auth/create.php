<h2>Login</h2>
<?php if(isset($errors)): ?>
    <p style="color: red;">Invalid Credintials </p>
    <?php endif; ?>
<form action="/login" method="post">
    <!--CSRF token-->
    
    <div>
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    </div>
    <div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    </div>
    <div>
        <label for="remember">Remember Me</label>
        <input type="checkbox" name="remember" id="remember">
    </div>
    <div>
    <button type="submit">Login</button>
    </div>
</form>