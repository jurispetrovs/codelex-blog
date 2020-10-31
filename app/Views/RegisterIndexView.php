<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <a href="/">Home</a>
    <div class="register">
        <h3>Create User</h3>
        <form method="post" action="/register" novalidate>
            <label for="name">Name </label>
            <input type="text" name="name" id="name" placeholder="Name" required>
            <label for="email">E-mail </label>
            <input type="email" name="email" id="email" placeholder="E-mail" required>
            <label for="password">Password </label>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password_confirmation">Password Confirmation </label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Password Confirmation" required>
            <button type="submit" class="submit">Register</button>
        </form>
    </div>
</body>
</html>