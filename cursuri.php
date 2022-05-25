<?php
include "inc/config.php";
include "inc/connect.php";
include "inc/header.php";
?>

<h1 class="text-center">Cursuri</h1>


<?php

function listCursuri()
{
    global $id_conexiune;
    $query = "SELECT * FROM cursuri";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) :
?>

            <div class="column" style="width:100%">
                <div class="card ">
                    <div class="container">
                        <h2><b><?php echo $row['nume'] ?></b></h2>
                        <div class="description">
                        <p ><?php echo $row['descriere'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

<?php
        endwhile;
    }
}


listCursuri();

include "inc/footer.php";
?>