<!DOCTYPE html>
<div>
<html>
    <head>
        <title>Login</title>
    </head>
<body>
        <h1>Login Page</h1>
        <form action="/login" method="POST">
            @csrf
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>    
            <button type="submit">Login</button>
        </form>
    </body>
</div>
</html>
