<?php

include 'db.php';

if (!checkConnection()) {
    echo "Db connection error: \n" . getError();
    exit();
} else {
    $answer = query("SELECT * FROM connectedusers WHERE id = 1;");
    $getRowAssoc = mysqli_fetch_assoc($answer);
    $amount = $getRowAssoc["amount"];

    $answer->close();
    closeConnection();
    echo "200, $amount";
    exit();
}
?>
