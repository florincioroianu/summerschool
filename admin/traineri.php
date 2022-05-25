<?php
include "../inc/config.php";
include "../inc/connect.php";
include "inc/header.php";

$eroareNume = "";
$EroarePozitie = "";

$comanda = isset($_REQUEST['comanda']) ? $_REQUEST['comanda'] : "";
if (!empty($comanda)) {
    switch ($comanda) {
        case 'add':
            $nume = $_REQUEST["nume"];
            $pozitie = $_REQUEST["pozitie"];
            $name = $_FILES['file']['name'];
            $target_dir = "./img/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            // Select file type
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
            if (empty($pozitie)) {
                $eroarePozitie = "Campul nu poate fi vid!";
                $valid = false;
            }
            if ($valid) {
                $sql = "INSERT INTO traineri(nume, pozitie, img) VALUES ('$nume','$pozitie', '$image')";

                if (!mysqli_query($id_conexiune, $sql)) {
                    die('Error: ' . mysqli_error($id_conexiune));
                }
                echo "<div class='succes; updateinfo'>Trainer adaugat cu succes</div>";
            }
            break;
        case 'delete':
            $id = $_REQUEST["id"];
            $sql = "DELETE FROM traineri WHERE id=$id";
            if (!mysqli_query($id_conexiune, $sql)) {
                die('Error: ' . mysqli_error($id_conexiune));
            }
            echo "<div class='succes; updateinfo'>Trainerul cu id-ul $id a fost sters cu succes</div>";
            break;
    }
}



function afisaretraineri()
{
    print("<h1 class='title'>Gestionare traineri</h1>\n");
    /** Afisarea trainerilor */
    global $id_conexiune;
    $query = "SELECT * FROM traineri";
    $result = mysqli_query($id_conexiune, $query);

    if (mysqli_num_rows($result)) {
        print("<table class='table' border='1' cellspacing='0'>\n");
        print("<tr>\n");
        print("<th>#</th><th width='100'>Nume</th><th width='300'>pozitie</th><th>Actiune</th>");
        print("</tr>\n");
        while ($row = mysqli_fetch_array($result)) {
            print("<tr>\n");
            print("<td align='center'>" . $row['id'] . "</td>\n");
            print("<td>" . $row['nume'] . "</td>\n");
            print("<td>" . $row['pozitie'] . "</td>\n");
            print("<td align='center'><a href='traineri.php?comanda=delete&id=" . $row['id'] . "'>Delete</a></td>\n");
            print("</tr>\n");
        }
        print("</table>");
    } else {
        print("<h3 class='title'> Nu exista traineri!</h3>");
    }
}
afisaretraineri();
?>

<head>
    <title>Traineri</title>

    <!-- <script type="text/javascript">
        function validezaForma() {
            var frm = document.traineri;
            var valid = true;
            if (frm.nume.value.length < 2) {
                alert("Numele trebuie sa aiba minim 2 caractere");
                frm.nume.focus();
                valid = false;
            }
            if (/^[A-Za-z ]+$/.test(frm.nume.value)) {
                alert("Numele trebuie sa contina doar litere si spatii");
                frm.nume.focus();
                valid = false;
            }
            if (frm.pozitie.value.length < 2) {
                alert("Numele pozitiei trebuie sa aiba minim 2 caractere");
                frm.pozitie.focus();
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
    <h4 style="text-align:center">Adauga un trainer</h4>
    <form action="traineri.php" name="traineri" method="post" onsubmit="return validezaForma()" enctype="multipart/form-data" align='center'>
        <input name="comanda" type="hidden" value="add" />
        <p>Nume:
            <input type="text" name="nume" value="" size="30" />
            <span class="error"><?php echo $eroareNume; ?></span>
        </p>
        <p>Pozitie:
            <input type="text" name="pozitie" value="" size="30" />
            <span class="error"><?php echo $eroareNume; ?></span>
        </p>
        <p>Imagine de profil:
            <input type="file" name="file" id="insert" />
        </p>
        <input type="submit" value="Adauga" />
        <input type="reset" value="Reset" />
    </form>
</body>