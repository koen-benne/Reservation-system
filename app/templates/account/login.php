<header><h1><?= $pageTitle ?? '' ?></h1></header>

<?php if (count($errors) !== 0): ?>
    <span>Je logingegevens zijn onjuist.</span>
<?php endif; ?>
<div id="loginBox">
    <form action="" method="post" id="loginForm">
        <label for="email">Email</label>
        <input type="text" name="email" value=<?= $email ?>><br>
        <label for="Password">Password</label>
        <input type="password" name="password"><br>
        <input type="submit" value="Log in" name="submit" id="submit">
    </form>
</div>
<br>
<a href="/">Terug naar reserveren</a>