<?php
include "inc/config.php";
include "inc/connect.php";
include "inc/header.php";

function listOrganizatori()
{
    global $id_conexiune;
    $query = "SELECT * FROM organizatori";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) :
            $image_src = $row['img'];
?>

            <div class="column">
                <div class="card">
                    <img class="orgimg" src='<?php echo $image_src; ?>' />
                    <div class="container">
                        <h2><b><?php echo $row['nume'] ?></b></h2>
                    </div>
                </div>
            </div>

<?php
        endwhile;
    }
}
?>
<h1 class="text-center">Organizatorii nostri</h1>

<?php
listOrganizatori();
include "inc/footer.php";
?>
