<?php
include "../inc/config.php";
include "../inc/connect.php";
include "inc/header.php";


$eroareNume = "";
$eroareDescriere = "";

$comanda = isset($_REQUEST['comanda']) ? $_REQUEST['comanda'] : "";
if (!empty($comanda)) {
  switch ($comanda) {
    case 'add':
      $nume = $_REQUEST["nume"];
      $descriere = $_REQUEST["descriere"];
      $valid = true;
      if (empty($nume)) {
        $eroareNume = "Numele nu poate fi vid!";
        $valid = false;
      }
      if (empty($descriere)) {
        $eroareDescriere = "Campul nu poate fi vid!";
        $valid = false;
      }
      if ($valid) {
        $sql = "INSERT INTO cursuri(nume, descriere) VALUES ('$nume','$descriere')";
        if (!mysqli_query($id_conexiune, $sql)) {
          die('Error: ' . mysqli_error($id_conexiune));
        }
        echo "<div class='succes; updateinfo'>Curs adaugat cu succes</div>";
      }
      break;
    case 'delete':
      $id = $_REQUEST["id"];
      $sql = "DELETE FROM cursuri WHERE id=$id";
      if (!mysqli_query($id_conexiune, $sql)) {
        die('Error: ' . mysqli_error($id_conexiune));
      }
      echo "<div class='succes; updateinfo'>Cursul cu id-ul $id a fost sters cu succes</div>";
      break;
    case 'edit':
      $id = $_REQUEST["id"];
      $sql = "SELECT * FROM cursuri WHERE id=$id";
      $result = mysqli_query($id_conexiune, $sql);
      if ($row = mysqli_fetch_array($result)) {
        $nume = $row['nume'];
        $descriere = $row['descriere'];
        $orar = $row['orar'];
?>
        <!-- Forma de editare (begin) -->
        <h3 class="title">Editare</h3>
        <form action="cursuri.php" method="post">
          <input name="comanda" type="hidden" value="update" />
          <input name="id" type="hidden" value="<?php echo $id; ?>" />
          Nume: <input type="text" name="nume" size="50" value="<?php echo $nume; ?>" />
          <br><br>Descriere: <textarea rows="7" cols="80" name="descriere"><?php echo $descriere; ?></textarea>
          <br><br>Orar: <textarea class="textarea" name="orar" id="editor"><?php echo $orar; ?></textarea>
          <input type="submit" value="Update" />
        </form>
        <!-- Forma de editare (end) -->
<?php
      } else {
        echo "<div class='error; updateinfo'>Cursul cu id-ul $id nu exista!</div>";
      }
      break;
    case 'update':
      $id = $_REQUEST["id"];
      $nume = $_REQUEST["nume"];
      $descriere = $_REQUEST["descriere"];
      $orar = $_REQUEST["orar"];
      $valid = true;
      if (empty($nume)) {
        $eroareNume = "Numele nu poate fi vid!";
        $valid = false;
      }
      if (empty($descriere)) {
        $eroareDescriere = "Campul nu poate fi vid!";
        $valid = false;
      }
      if ($valid) {
        $sql = "UPDATE cursuri SET nume='$nume', descriere='$descriere', orar='$orar' WHERE id='$id'";
        if (!mysqli_query($id_conexiune, $sql)) {
          die('Error: ' . mysqli_error($id_conexiune));
          echo "<div class='error'>A aparut o eroare la actualizarea intrarii cu id-ul $id</div>";
        } else {
          echo "<div class='succes; updateinfo'>Cursul cu id-ul $id a fost actualizat cu succes!</div>";
        }
      }
      break;
  }
}



function afisareCursuri()
{
  print("<h1 class='title'>Gestionare cursuri</h1>\n");
  /** Afisarea cursurilor */
  global $id_conexiune;
  $query = "SELECT * FROM cursuri";
  $result = mysqli_query($id_conexiune, $query);
  if (mysqli_num_rows($result)) {
    print("<table class='table' border='1' cellspacing='0'>\n");
    print("<tr>\n");
    print("<th>#</th><th width='100'>Nume</th><th width='300'>Descriere</th><th colspan='2'>Actiune</th>");
    print("</tr>\n");
    while ($row = mysqli_fetch_array($result)) {
      print("<tr>\n");
      print("<td align='center'>" . $row['id'] . "</td>\n");
      print("<td>" . $row['nume'] . "</td>\n");
      print("<td>" . $row['descriere'] . "</td>\n");
      print("<td align='center'><a href='cursuri.php?comanda=delete&id=" . $row['id'] . "'>Delete</a></td>\n");
      print("<td align='center'><a href='cursuri.php?comanda=edit&id=" . $row['id'] . "'>Edit</a></td>\n");
      print("</tr>\n");
    }
    print("</table>");
  } else {
    print("<h3 class='title'> Nu exista cursuri!</h3>");
  }
}
afisareCursuri();
?>

<head>
  <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
</head>

<h4 style="text-align:center">Adauga un curs</h4>
<form action="cursuri.php" method="post" align='center'>
  <input name="comanda" type="hidden" value="add" />

  <p>Nume:
    <input type="text" name="nume" value="" size="40" />
    <span class="error"><?php echo $eroareTitlu; ?></span>
  </p>
  <p>Descriere: <span class="error"><?php echo $eroareDescriere; ?></span><br />
    <textarea class="textarea" name="descriere" id="editor"></textarea>
    <script>
      ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
          console.error(error);
        });
    </script>
  </p>
  <input type="submit" value="Adauga" />
  <input type="reset" value="Reset" />
</form>

<?php
include "inc/footer.php";
?>