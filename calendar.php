<?php
include "inc/config.php";
include "inc/connect.php";
include "inc/header.php";
?>

<h1 class="text-center">Calendar</h1>
<h4>Cursurile scolii de vara se vor desfasura in perioada 24 iunie - 12 iulie 2019</h4>
<?php
function listCalendar()
{
    global $id_conexiune;
    $query = "SELECT nume, orar FROM cursuri";
    $result = mysqli_query($id_conexiune, $query);
    if (mysqli_num_rows($result)) {
        echo "<div class='row'>";
        while ($row = mysqli_fetch_array($result)) :
            if ($row['orar']) :
?>
                <div class="column">
                    <div class="card" style="width:500px">
                        <div class="container">
                            <h2><b><?php echo $row['nume'] ?></b></h2>
                            <p><?php echo $row['orar'] ?></p>
                        </div>
                    </div>
                </div>

<?php
            endif;
        endwhile;
        echo "</div>";
    }
}

listCalendar();
?>

<?php
include "inc/footer.php";
?>