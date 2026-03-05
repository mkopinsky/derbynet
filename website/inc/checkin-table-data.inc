<?php

function get_partitions() {
    global $db;
    $stmt = $db->query('SELECT partitionid, name,'
        .'  (SELECT COUNT(*) FROM RegistrationInfo'
        .'     WHERE RegistrationInfo.partitionid = Partitions.partitionid) AS count'
        .' FROM Partitions'
        .' ORDER BY sortorder');
    $partitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($partitions) == 0) {
        // 0 won't be used as a partitionid, but will cause the server to create a new
        // partition with default name.
        $partitions[] = array('partitionid' => 0,
            'name' => DEFAULT_PARTITION_NAME);
    }

    return $partitions;
}

function get_racers($order)
{
    global $db;

    $sql = checkin_table_SELECT_FROM_sql()
        .' ORDER BY '
        .($order == 'car' ? 'carnumber, lastname, firstname' :
            ($order == 'class'  ? 'class_sort, rank_sort, lastname, firstname' :
                ($order == 'partition' ? 'partition_sortorder, lastname, firstname' :
                    'lastname, firstname')));

    $stmt = $db->prepare($sql);
    $stmt->execute(array(':xbs_award_name' => xbs_award()));
    return $stmt;
}
