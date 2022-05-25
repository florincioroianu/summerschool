<?php

function doLogin($user, $password)
{
    global $id_conexiune;
    $logat = FALSE;
    if (isLogged())
        doLogout();
    $sql = sprintf(
        "SELECT * FROM admin WHERE nume='%s' AND parola= md5('%s')",
        mysqli_real_escape_string($id_conexiune, $user),
        mysqli_real_escape_string($id_conexiune, $password)
    );
    if (!($result = mysqli_query($id_conexiune, $sql))) {
        echo ('Error: ' . mysqli_error($id_conexiune));
    }
    if ($row = mysqli_fetch_array($result)) {
        $logat = TRUE;
        $_SESSION['user'] = $user;
        $_SESSION['logat'] = TRUE;
    }
    return $logat;
}

function doLogout()
{
    unset($_SESSION['user']);
    unset($_SESSION['logat']);
}

function isLogged()
{
    return isset($_SESSION['logat']) && $_SESSION['logat'] == TRUE;
}

function getLoggedUser()
{
    return isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
}
