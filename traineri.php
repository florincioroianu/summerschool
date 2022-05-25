<?php
include "inc/config.php";
include "inc/connect.php";
include "inc/header.php";

function listTraineri()
{
    global $id_conexiune;
    $query = "SELECT * FROM traineri";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) :
            $image_src = $row['img'];
?>

            <div class="column" style="float:left">
                <div class="card">
                    <img class="avatar" src='<?php echo $image_src; ?>' />
                    <div class="container">
                        <h2><b><?php echo $row['nume'] ?></b></h2>
                        <p><?php echo $row['pozitie'] ?></p>
                    </div>
                </div>
            </div>

<?php
        endwhile;
    }
}

    ?>

    <h1 class="text-center">Trainerii nostri</h1>
    <p class="para">Cursurile scolii de vara vor fi sustinute de specialisti ai companiilor <a href="http://www.caphyon.ro">Caphyon</a>, <a href="http://www.netromsoftware.ro">NetRom Software</a> si <a href="https://novabooker.ro/">PRO BST IT</a>.</p>

    <?php
    listTraineri();
    include "inc/footer.php";
    ?>