
    <?php
    include_once("repif_db.php");

    $sql = $connection->prepare("SELECT * from users");
    $sql->execute();
    $result = $sql->get_result();

    while($row=$result->fetch_assoc()){
        print $row;
    }

    ?>