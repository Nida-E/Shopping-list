<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voeg een nieuw artikel toe</title>
    <style>
        body {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    background: linear-gradient(135deg, #0070C9, #005bb5);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    color: white;
}

h2 {
    color: white;
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    box-sizing: border-box;
    color: #333;
}

form label {
    font-size: 16px;
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

form input[type="text"], form input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
}

form input[type="submit"] {
    background-color: #0070C9;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #005bb5;
}

table {
    margin-top: 20px;
    border-collapse: collapse;
    width: 100%;
    max-width: 600px;
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    color: #333;
}
 
table, th, td {
    border: 1px solid #ddd;
}
 
th, td {
    padding: 12px;
    text-align: left;
}
 
th {
    background-color: #0070C9;
    color: white;
}
 
td form {
    display: inline-block;
}
 
td input[type="number"] {
    width: 60px;
}
 
td input[type="submit"] {
    margin-top: 5px;
    font-size: 14px;
}
#afbeelding {
    margin: auto;
    animation: mymove 5s infinite;
        }
@keyframes mymove {
    100% {transform: rotate(360deg);}
}
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
<div class="hamburger" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="dropdown" id="dropdownMenu">
        <a href="register.php">Registreer</a>
        <a href="lijst.php">Lijst</a>
    </div>
    
    <img src="R.png" alt="ah" width="200px" id="afbeelding">
 
    <h2>Voeg een nieuw artikel toe</h2><!-- text dat bovenaan staat -->
    <form action="lijst.php" method="post"><!-- een formulier en wat je invult komt naar lijst pagina -->
        <label for="product">Product:</label><br><!-- label zodat je weet wat je moet invullen -->
        <input type="text" id="product" name="product" required><br><!-- hier kan je pruduct invullen-->
        <label for="voorraad">Voorraad:</label><br><!-- label zodat je weet wat je moet invullen -->
        <input type="text" id="voorraad" name="voorraad" pattern="[0-9]+" title="Voorraad" required><br><!-- hier kan je hoeveelheid van product invullen-->
        <input type="submit" value="Toevoegen"><!-- knop om op te drukken -->
    </form>
 
    <h2>Productlijst</h2><!-- text dat boven de producten staat -->
    <?php
    session_start();//sessie start
 
    if(!isset($_SESSION["login"])){ //kijkt of login niet is ingestelt
        header("location: login.php");//stuurt door naar login.php
    }
 
    function lijst() {//functie aanmaken
        $host = "localhost";//de naam van de databse-server
        $user = "root";//gebruikersnaam om verbinding te maken met database
        $wachtwoord = "";//de wachtwoord om verbinding te maken met de database
        $database = "alberthijm";//de naam van de database
 
        try {//eerst probeert hij dit
            $conn = new mysqli($host, $user, $wachtwoord, $database);//hij maakt een object en maakt een connectie met de database
 
            if ($conn->connect_error) {//kijkt of er een fout zit bij verbinden met database
                throw new Exception($conn->connect_error);//foutmelding als er geen verbinding is
            }
 
 
            // CREATE (NIEUW PRODUCT TOEVOEGEN IN DE DATABASE)
 
            if ($_SERVER["REQUEST_METHOD"] == "POST"//controleert of de verzoek een POST verzoek is
                && isset($_POST['product'])//controleert of de POST als product is meegezonden
                && isset($_POST['voorraad'])//controleert of de POST als voorraad is meegezonden
                && !isset($_POST['update_voorraad'])//controleert of de POST als update van voorraad is meegezonden
                && !isset($_POST['verwijder_product'])) {//controleert of de POST als verwijder product is meegezonden
 
                $product = $_POST['product'];//haalt de waarde op
                $voorraad = $_POST['voorraad'];//haalt de waarde op
                $sql = "INSERT INTO winkelmand (product, voorraad) VALUES (?, ?)";//hij zet de gegevens die je invult in de database
                $stmt = $conn->prepare($sql);//hij berijd zich voor
                $stmt->bind_param("ss", $product, $voorraad);//hij bind de $product met $voorraad


 
                if (!$stmt->execute()) {//uitvoeren. als het niet lukt error geven
                    throw new Exception($stmt->error);//foutmelding als er geen verbinding is
                }else {
                    echo '<p style="font-size: 30px; color: #10187C;">Toegevoegd!</p>';
                    echo '<img src="ah.gif" alt="duim" style="width: 600px;">';
                }
            
            }


            //UPDATE (VOORRAAD BIJWERKEN)
 
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_voorraad'])) {//controleert of het een POST verzoek is en
                //controleert of POST parameter van update_voorraad is ingevult
                $product = $_POST['product'];//Haalt de waarde van product op uit de POST gegevens en slaat deze op in de variabele $product
                $nieuwe_voorraad = $_POST['nieuwe_voorraad'];//Haalt de waarde van product op uit de POST gegevens en slaat deze op in de variabele $nieuwe_voorraad
                $sql = "UPDATE winkelmand SET voorraad = ? WHERE product = ?";//hij kijkt in de database en bewerkt de product
                $stmt = $conn->prepare($sql);//hij berijd zich voor voor de bind param
                $stmt->bind_param("ss", $nieuwe_voorraad, $product);// kijken wat ik heb
 
                if (!$stmt->execute()) {//kijkt of er een fout zit bij verbinden met database
                    throw new Exception($stmt->error);//foutmelding als er geen verbinding is
                }else {
                    echo '<p style="font-size: 30px; color: #10187C;">Bijgewerkt!</p>';
                    echo '<img src="update.gif" alt="duim" style="width: 600px;">';
                }
            }
 
            //DELETE (PRODUCT VERWIJDEREN)
 
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verwijder_product'])) {//controleert of het een POST verzoek is en
                //controleert of POST parameter van update_voorraad is ingevult
                $product = $_POST['product'];//Haalt de waarde van product op uit de POST gegevens en slaat deze op in de variabele $product
                $sql = "DELETE FROM winkelmand WHERE product = ?";//verwijdert de product van de database
                $stmt = $conn->prepare($sql);//hij berijd zich voor voor de bind param
                $stmt->bind_param("s", $product);// kijken wat ik heb
 
                if (!$stmt->execute()) {//kijkt of er een fout zit bij verbinden met database
                    throw new Exception($stmt->error);//foutmelding als er geen verbinding is
                }else {
                    echo '<p style="font-size: 30px; color: #10187C;">verwijdert!</p>';
                    echo '<img src="trash2.gif" alt="duim" style="width: 600px;">';
                 //   echo '<img src="trash.gif" alt="duim" style="width: 600px;">';
                }
            }
 
            //READ (GEGEVENS OPHALEN EN WEERGEVEN)
 
            $sql = "SELECT product, voorraad FROM winkelmand";//selecteert product en voorraad van winkelmand
            $stmt = $conn->prepare($sql);//hij berijd zich voor voor de bind param
            $stmt->execute();//voert het uit
            $stmt->bind_result($product, $voorraad);//laat het uitgevoerde zien
 
            echo "<table border='1'>  <!-- totaale border en begin van de tabel -->
            <tr> <!-- tabel rij maken -->
                <th>Product</th> <!-- tabel header voor product -->
                <th>Voorraad</th> <!-- tabel header voor voorraad -->
                <th>Vooraad bewerken</th> <!-- tabel header voor bewerken -->
                <th>Verwijderen</th> <!-- tabel header voor verwijderen -->
            </tr>";
 
            while ($stmt->fetch()) {//de resultaten in de onderstaande doen
                echo "<tr> <!-- tabel rij maken -->
                        <td>" . htmlspecialchars($product) . "</td> <!-- tabel cel maken voor product -->
                        <td>" . htmlspecialchars($voorraad) . "</td> <!-- tabel cel maken voor voorraad -->
                        <td> <!-- tabel cel maken voor wat je invult -->
                            <form action='lijst.php' method='post' style='display:inline-block;'> <!-- hij laat de methode zien en waar de gegevens naartoe moeten gaan -->
                                <input type='hidden' name='product' value='" . htmlspecialchars($product) . "'>  <!-- een invulveld die het ingevulde in hlml taal zet -->
                                <input type='number' name='nieuwe_voorraad' min='0' required>  <!-- een input voor aleen nummers -->
                                <input type='submit' name='update_voorraad' value='Bijwerken'> <!-- een submit knop die de product update -->
                            </form>
                        </td>
                        <td> <!-- tabel cel maken voor wat je invult -->
                            <form action='lijst.php' method='post' style='display:inline-block;'> <!-- hij laat de methode zien en waar de gegevens naartoe moeten gaan -->
                                <input type='hidden' name='product' value='" . htmlspecialchars($product) . "'> <!-- een invulveld die het ingevulde in hlml taal zet -->
                                <input type='submit' name='verwijder_product' value='Verwijderen'> <!-- een submit knop die de voorraad verwijdert -->
                            </form>
                        </td>
                    </tr>";
            }
            echo "</table>";
 
        } catch (Exception $e) {//als try niet lukt voert hij dit uit
            echo "Error: " . $e->getMessage();//hij geeft error als het niet lukt
        } finally {//einde
            if (isset($stmt)) {//hij controleert of de variabele $stmt is ingesteld
                $stmt->close();;//sluit de stmt
            }
            if (isset($conn)) {//hij controleert of de variabele $conn is ingesteld
                $conn->close();//slut de conn
            }
        }
    }
 
    lijst();//roept de functie
    ?>

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