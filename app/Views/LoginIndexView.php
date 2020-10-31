<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<a href="/">Home</a>
<div class="register">
    <h3>Login</h3>
    <form method="post" action="/login">
        <label for="email">E-mail </label>
        <input type="text" name="email" id="email" placeholder="E-mail" required>
        <label for="password">Password </label>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <button type="submit" class="submit">Login</button>
    </form>
</div>
</body>
</html>