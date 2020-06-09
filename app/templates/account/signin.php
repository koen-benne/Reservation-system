<header><h1><?= $pageTitle ?? '' ?></h1></header>

<?php foreach ($errors as $error): ?>
    <span><?= $error; ?></span><br>
<?php endforeach; ?>
<div>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="text" name="email" value=<?= $email ?>>
        <label for="username">Username</label>
        <input type="text" name="username" value=<?= $username ?>>
        <label for="Password">Password</label>
        <input type="password" name="password">
        <input type="submit" value="submit" name="submit">
    </form>
</div>
<br>
<a href="/">Terug naar reserveren</a>