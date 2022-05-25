<?php
include "../inc/config.php";
include "../inc/connect.php";
include "inc/header.php";

$eroareTitlu = "";
$eroareInformatie = "";

$comanda = isset($_REQUEST['comanda']) ? $_REQUEST['comanda'] : "";
if (!empty($comanda)) {
  switch ($comanda) {
    case 'add':
      $titlu = $_REQUEST["titlu"];
      $informatie = $_REQUEST["informatie"];
      $valid = true;
      if (empty($titlu)) {
        $eroareTitlu = "Titlul nu poate fi vid!";
        $valid = false;
      }
      if (empty($informatie)) {
        $eroareInformatie = "Campul nu poate fi vid!";
        $valid = false;
      }
      if ($valid) {
        $sql = "INSERT INTO anunturi(titlu, informatie) VALUES ('$titlu','$informatie')";
        if (!mysqli_query($id_conexiune, $sql)) {
          die('Error: ' . mysqli_error($id_conexiune));
        }
        echo "<div class='succes; updateinfo'>Anunt adaugat cu succes</div>";
      }
      break;
    case 'delete':
      $id = $_REQUEST["id"];
      $sql = "DELETE FROM anunturi WHERE id=$id";
      if (!mysqli_query($id_conexiune, $sql)) {
        die('Error: ' . mysqli_error($id_conexiune));
      }
      echo "<div class='succes; updateinfo'>Anuntul cu id-ul $id a fost sters cu succes</div>";
      break;
    case 'edit':
      $id = $_REQUEST["id"];
      $sql = "SELECT * FROM anunturi WHERE id=$id";
      $result = mysqli_query($id_conexiune, $sql);
      if ($row = mysqli_fetch_array($result)) {
        $titlu = $row['titlu'];
        $informatie = $row['informatie'];
?>
        <!-- Forma de editare (begin) -->
        <h3 class="title">Editare</h3>
        <form action="anunturi.php" method="post">
          <input name="comanda" type="hidden" value="update" />
          <input name="id" type="hidden" value="<?php echo $id; ?>" />
          Titlu: <input type="text" name="titlu" size="20" value="<?php echo $titlu; ?>" />
          Informatie: <input type="text" name="informatie" size="50" value="<?php echo $informatie; ?>" />
          <input type="submit" value="Update" />
        </form>
        <!-- Forma de editare (end) -->
<?php
      } else {
        echo "<div class='error; updateinfo'>Anuntul cu id-ul $id nu exista!</div>";
      }
      break;
    case 'update':
      $id = $_REQUEST["id"];
      $titlu = $_REQUEST["titlu"];
      $informatie = $_REQUEST["informatie"];
      $valid = true;
      if (empty($titlu)) {
        $eroareTitlu = "Titlul nu poate fi vid!";
        $valid = false;
      }
      if (empty($informatie)) {
        $eroareInformatie = "Campul nu poate fi vid!";
        $valid = false;
      }
      if ($valid) {
        $sql = "UPDATE anunturi SET titlu='$titlu', informatie='$informatie' WHERE id=$id";
        if (!mysqli_query($id_conexiune, $sql)) {
          die('Error: ' . mysqli_error($id_conexiune));
          echo "<div class='error'>A aparut o eroare la actualizarea intrarii cu id-ul $id</div>";
        } else {
          echo "<div class='succes; updateinfo'>Anuntul cu id-ul $id a fost actualizat cu succes!</div>";
        }
      }
      break;
  }
}

function afisareAnunturi()
{
  print("<h1 class='title'>Gestionare anunturi</h1>\n");
  /** Afisarea anunturilor */
  global $id_conexiune;
  $query = "SELECT * FROM anunturi";
  $result = mysqli_query($id_conexiune, $query);
  if (mysqli_num_rows($result)) {
    print("<table class='table' border='1' cellspacing='0'>\n");
    print("<tr>\n");
    print("<th>#</th><th width='100'>Titlu</th><th width='300'>Informatie</th><th colspan='2'>Actiune</th>");
    print("</tr>\n");
    while ($row = mysqli_fetch_array($result)) {
      print("<tr>\n");
      print("<td align='center'>" . $row['id'] . "</td>\n");
      print("<td>" . $row['titlu'] . "</td>\n");
      print("<td>" . $row['informatie'] . "</td>\n");
      print("<td align='center'><a href='anunturi.php?comanda=delete&id=" . $row['id'] . "'>Delete</a></td>\n");
      print("<td align='center'><a href='anunturi.php?comanda=edit&id=" . $row['id'] . "'>Edit</a></td>\n");
      print("</tr>\n");
    }
    print("</table>");
  } else {
    print("<h3 class='title'> Nu exista anunturi!</h3>");
  }
}
AfisareAnunturi();
?>

<head>
  <title>Anunturi</title>
  <!-- <script type="text/javascript">
    function validezaForma() {
      var frm = document.anunturi;
      var valid = true;
      if (frm.titlu.value.length < 2) {
        alert("Numele trebuie sa aiba minim 2 caractere");
        frm.titlu.focus();
        valid = false;
      }
      if (frm.informatie.value.length < 2) {
        alert("Informatia trebuie sa aiba minim 2 caractere");
        frm.informatie.focus();
        valid = false;
      }
      return valid;
    }
  </script> -->
</head>

<body>

<h4 style="text-align:center">Adauga un anunt</h4>
<form action="anunturi.php" name="anunturi" onsubmit="return validezaForma()" method="post" align='center'>
  <input name="comanda" type="hidden" value="add" />

  <p>Titlu:
    <input type="text" name="titlu" value="" size="30" />
    <span class="error"><?php echo $eroareTitlu; ?></span>
  </p>
  <p>Informatie: <span class="error"><?php echo $eroareInformatie; ?></span><br />
    <textarea name="informatie" rows="5" cols="60"></textarea>
  </p>
  <input type="submit" value="Adauga" />
  <input type="reset" value="Reset" />
</form>
</body>