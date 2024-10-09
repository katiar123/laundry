<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('../img/laundry.jpg');
            background-size: cover;
            background-position: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 400px; /* Responsive max-width */
            width: 100%; /* Full width for mobile */
            z-index: 1;
            position: relative;
        }

        h2 {
            text-align: center;
            font-size: 1.8rem; /* Adjusted for mobile */
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem; /* Adjusted for mobile */
        }

        .button {
            width: 100%;
            padding: 10px;
            background-color: dodgerblue;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem; /* Adjusted for mobile */
        }

        .button:hover {
            background-color: #218838;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #007bff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px; /* Reduced padding for small screens */
            }

            h2 {
                font-size: 1.5rem; /* Further reduced heading size */
            }

            .button {
                font-size: 1rem; /* Slightly smaller button text */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" action="../routes/auth.php" method="post">
            <input type="text" id="loginEmail" class="input-field" placeholder="Username" name="username" required>
            <input type="password" id="loginPassword" class="input-field" placeholder="Password" name="password" required>
            <button type="submit" class="button" name="action" value="login">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            <?php 
                session_start();
                if (isset($_SESSION['error'])): ?>
                alert('Username atau password salah!');
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
