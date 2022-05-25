<?php
include "../inc/config.php";
include "../inc/connect.php";
include "inc/header.php";

$eroareNume = "";

$comanda = isset($_REQUEST['comanda']) ? $_REQUEST['comanda'] : "";
if (!empty($comanda)) {
    switch ($comanda) {
        case 'add':
            $nume = $_REQUEST["nume"];
            $name = $_FILES['file']['name'];
            $target_dir = "./img/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            // Check extension
            if (in_array($imageFileType, $extensions_arr)) {
                // Upload file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name)) {
                    // Convert to base64 
                    $image_base64 = base64_encode(file_get_contents('./img/' . $name));
                    $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;
                }
            }
            $valid = true;
            if (empty($nume)) {
                $eroareNume = "Numele nu poate fi vid!";
                $valid = false;
            }
            if ($valid) {
                $sql = "INSERT INTO organizatori(nume, img) VALUES ('$nume', '$image')";

                if (!mysqli_query($id_conexiune, $sql)) {
                    die('Error: ' . mysqli_error($id_conexiune));
                }
                echo "<div class='succes; updateinfo'>organizator adaugat cu succes</div>";
            }
            break;
        case 'delete':
            $id = $_REQUEST["id"];
            $sql = "DELETE FROM organizatori WHERE id=$id";
            if (!mysqli_query($id_conexiune, $sql)) {
                die('Error: ' . mysqli_error($id_conexiune));
            }
            echo "<div class='succes; updateinfo'>Organizatorul cu id-ul $id a fost sters cu succes</div>";
            break;
    }
}



function afisareorganizatori()
{
    print("<h1 class='title'>Gestionare organizatori</h1>\n");
    /** Afisarea Organizatorilor */
    global $id_conexiune;
    $query = "SELECT * FROM organizatori";
    $result = mysqli_query($id_conexiune, $query);

    if (mysqli_num_rows($result)) {
        print("<table class='table' border='1' cellspacing='0'>\n");
        print("<tr>\n");
        print("<th>#</th><th>Nume</th><th>Actiune</th>");
        print("</tr>\n");
        while ($row = mysqli_fetch_array($result)) {
            $image_src = $row['img'];
            print("<tr>\n");
            print("<td align='center'>" . $row['id'] . "</td>\n");
            print("<td>" . $row['nume'] . "</td>\n");
            print("<td align='center'><a href='organizatori.php?comanda=delete&id=" . $row['id'] . "'>Delete</a></td>\n");
            print("</tr>\n");
        }
        print("</table>");
    } else {
        print("<h3 class='title'> Nu exista organizatori!</h3>");
    }
}
afisareorganizatori();
?>

<head>

    <title>Organizatori</title>

    <!-- <script type="text/javascript">
        function validezaForma() {
            var frm = document.traineri;
            var valid = true;
            if (frm.nume.value.length < 2) {
                alert("Numele trebuie sa aiba minim 2 caractere");
                frm.nume.focus();
                valid = false;
            }
            return valid;
        }
    </script> -->

    <script>
        $(document).ready(function() {
            $('#insert').click(function() {
                var image_name = $('#image').val();
                if (image_name == '') {
                    alert("Please Select Image");
                    return false;
                } else {
                    var extension = $('#image').val().split('.').pop().toLowerCase();
                    if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        alert('Invalid Image File');
                        $('#image').val('');
                        return false;
                    }
                }
            });
        });
    </script>

</head>

<body>

    <h4 style="text-align:center">Adauga un organizator</h4>
    <form action="organizatori.php" method="post" name="organizatori" onsubmit="return validezaForma()" enctype="multipart/form-data" align='center'>
        <input name="comanda" type="hidden" value="add" />

        <p>Nume:
            <input type="text" name="nume" value="" size="50" />
            <span class="error"><?php echo $eroareNume; ?></span>
        </p>
        <p>Imagine:
            <input type="file" name="file" id="insert" />
        </p>
        <input type="submit" value="Adauga" />
        <input type="reset" value="Reset" />
    </form>

</body>