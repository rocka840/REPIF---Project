<?php
function createGroupConf($connection, $input) {
    $groups = $connection->prepare("
        SELECT `Groups`.GroupName, `Groups`.GroupNo, Concern.PinNo FROM `Groups`
        INNER JOIN Concern ON Concern.GroupNo = `Groups`.GroupNo
        WHERE `Groups`.HostName = ?
    ");

    $scripts = $connection->prepare("
        SELECT `Use`.GroupNo, `Use`.ScriptName, Script.Path FROM `Use`
        INNER JOIN Script ON Script.ScriptName = `Use`.ScriptName
        INNER JOIN `Groups` ON `Groups`.HostName = ?
    ");

    $groups->bind_param('s', $input);

    $groups->execute();

    $groupsresult = $groups->get_result();

    $groupsdata = $groupsresult->fetch_all(MYSQLI_ASSOC);

    $scripts->bind_param('s', $input);

    $scripts->execute();

    $scriptsresult = $scripts->get_result();

    $scriptsdata = $scriptsresult->fetch_all(MYSQLI_ASSOC);

    $content = array();

    foreach($groupsdata as $obj) {
        if(!array_key_exists($obj["GroupName"], $content)) $content[$obj["GroupName"]] = [];
        array_push($content[$obj["GroupName"]], $obj["PinNo"]);
    }

    $fp = fopen("config/gl.txt", "wb", true);

    foreach($content as $i => $group) {
        $line = "".$i."=".implode(',', $group)."\n";
        fwrite($fp, $line);
    }

    foreach($scriptsdata as $script) {
        $line = "".$script["ScriptName"]."=\"".$script["Path"]."\"\n";
        fwrite($fp, $line);
    }

    fclose($fp);
}

function createExecConf($connection, $input) {
    $stmt= $connection->prepare("
        SELECT * FROM Switch_Execute
        INNER JOIN Pin ON Pin.PinNo = Switch_Execute.PinNo
        INNER JOIN `Groups` ON `Groups`.GroupNo = Switch_Execute.GroupNo
        WHERE Switch_Execute.HostName = ? AND Pin.HostName = Switch_Execute.HostName
    ");

    $stmt->bind_param('s', $input);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $fp = fopen("config/tefg.txt", "wb", true);

    foreach($data as $exec) {
        $duration = $exec["WaitingDuration"] ? ", ".$exec["WaitingDuration"] : '';
        $line = "".$exec["Designation"].", ".$exec["EventCode"]."=".$exec["TargetFunctionCode"].", ".$exec["GroupName"].":".$exec["TargetFunctionCode"]."".$duration."\n";
        fwrite($fp, $line);
    }

    fclose($fp);
}

function sendConf($input) {
    require("repif_db.php");

    createGroupConf($connection, $input);
    createExecConf($connection, $input);

    $sshconnection = ssh2_connect('192.168.6.231', 22); //ip address of the webserver

    ssh2_auth_password($sshconnection, 'pi', 'raspberry');

    ssh2_scp_send($sshconnection, $_SERVER['DOCUMENT_ROOT'] . "/config/gl.txt", '/home/pi/pif2122/data/gl.txt', 0644);
    ssh2_scp_send($sshconnection, $_SERVER['DOCUMENT_ROOT'] . "/config/tefg.txt", '/home/pi/pif2122/data/tefg.txt', 0644);
}

if(isset($_GET["HostName"])) {
    sendConf($_GET["HostName"]);
}