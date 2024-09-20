<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #0070C9, #005bb5);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            color: white;
            font-size: 36px;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
            color: #333;
            text-align: left;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #0070C9;
            color: #fff;
            border: none;
            padding: 14px 20px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #005bb5;
        }

        img {
            margin: auto;
            animation: mymove 5s infinite;
        }

        @keyframes mymove {
            100% {transform: rotate(360deg);}
        }

        /* Hamburger menu styling */
        .hamburger {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            width: 30px;
            height: 30px;
            justify-content: space-around;
            cursor: pointer;
        }

        .hamburger div {
            width: 30px;
            height: 3px;
            background-color: white;
            transition: all 0.3s ease;
        }

        /* Dropdown menu */
        .dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 10px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .dropdown a {
            display: block;
            padding: 10px 20px;
            color: #0070C9;
            text-decoration: none;
            font-weight: bold;
        }

        .dropdown a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <!-- Hamburger Menu Icon -->
    <div class="hamburger" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Dropdown Menu -->
    <div class="dropdown" id="dropdownMenu">
        <a href="register.php">Registreer</a>
        <a href="lijst.php">Lijst</a>
    </div>

    <img src="R.png" alt="ah" width="200px"><!-- AH logo afbeelding -->

    <h1>Login</h1><!-- text dat bovenaan staat -->
    <form action="login.php" method="POST"><!-- een formulier wat je invult komt naar loginpagina -->
        <!-- label zodat je weet wat je moet invullen -->
        <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required><br><br><!-- hier kan je gebruikersnaam invullen-->
        <!-- label zodat je weet wat je moet invullen -->
        <input type="password" name="wachtwoord" placeholder="Wachtwoord" required><br><br><!-- hier kan je wachtwoord invullen-->
        <button type="submit">Login</button><!-- knop om op te drukken -->
    </form>

    <script>
        const hamburger = document.getElementById('hamburger');
        const dropdownMenu = document.getElementById('dropdownMenu');

        hamburger.addEventListener('click', () => {
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            } else {
                dropdownMenu.style.display = 'block';
            }
        });

        window.addEventListener('click', function(e) {
            if (!hamburger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    </script>

</body>
</html>
