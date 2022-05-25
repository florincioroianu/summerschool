<?php
include "inc/config.php";
include "inc/connect.php";
include "inc/header.php";
?>

<body>
    <h1 class="text-center">Anunturi importante</h1>
</body>
<?php


function listAnunturi()
{
    global $id_conexiune;
    $query = "SELECT titlu, informatie FROM anunturi";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) :
?>
            <div class="column">
                <div class="card">
                    <div class="container">
                        <h2><b><?php echo $row['titlu'] ?></b></h2>
                        <p><?php echo $row['informatie'] ?></p>
                    </div>
                </div>
            </div>
<?php
        endwhile;
    }
}


listAnunturi();
?>

<?php
include "inc/footer.php";
?>