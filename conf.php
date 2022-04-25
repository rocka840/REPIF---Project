<?php
function createGroupConf($connection, $input) {
    $groups = $connection->prepare("
        SELECT `group`.GroupName, `group`.GroupNo, concern.PinNo FROM `group`
        INNER JOIN concern ON concern.GroupNo = `group`.GroupNo
        WHERE `group`.SmartBox = ?
    ");

    $scripts = $connection->prepare("
        SELECT `use`.GroupNo, `use`.ScriptName, script.Path FROM `use`
        INNER JOIN script ON script.ScriptName = `use`.ScriptName
        INNER JOIN `group` ON `group`.SmartBox = ?
    ");

    $groups->bind_param('s', $input["HostName"]);

    $groups->execute();

    $groupsresult = $groups->get_result();

    $groupsdata = $groupsresult->fetch_all(MYSQLI_ASSOC);

    $scripts->bind_param('s', $input["HostName"]);

    $scripts->execute();

    $scriptsresult = $scripts->get_result();

    $scriptsdata = $scriptsresult->fetch_all(MYSQLI_ASSOC);

    $content = array();

    foreach($groupsdata as $obj) {
        if(!array_key_exists($obj["GroupName"], $content)) $content[$obj["GroupName"]] = [];
        array_push($content[$obj["GroupName"]], $obj["PinNo"]);
    }

    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/config/gl.txt", "wb");

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
        SELECT * FROM switch_execute
        INNER JOIN pin ON pin.PinNo = switch_execute.PinNo
        INNER JOIN `group` ON `group`.GroupNo = switch_execute.GroupNo
        WHERE switch_execute.HostName = ? AND pin.HostName = switch_execute.HostName
    ");

    $stmt->bind_param('s', $input["HostName"]);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/config/tefg.txt", "wb");

    foreach($data as $exec) {
        $duration = $exec["WaitingDuration"] ? ", ".$exec["WaitingDuration"] : '';
        $line = "".$exec["Designation"].", ".$exec["EventCode"]."=".$exec["TargetFunctionCode"].", ".$exec["GroupName"].":".$exec["TargetFunctionCode"]."".$duration."\n";
        fwrite($fp, $line);
    }

    fclose($fp);
}

function sendConf($connection, $input) {
    createGroupConf($connection, $input);
    createExecConf($connection, $input);

    $sshconnection = ssh2_connect('192.168.178.52', 22);

    ssh2_auth_password($sshconnection, 'pi', 'phd');

    ssh2_scp_send($sshconnection, $_SERVER['DOCUMENT_ROOT'] . "/config/gl.txt", '/home/pi/pif2122/data/gl.txt', 0644);
    ssh2_scp_send($sshconnection, $_SERVER['DOCUMENT_ROOT'] . "/config/tefg.txt", '/home/pi/pif2122/data/tefg.txt', 0644);
}