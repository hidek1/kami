<?php 

$sql = 'SELECT * FROM `kami_event_joinings` LEFT JOIN `kami_events` ON `kami_event_joinings`.`event_id`=`kami_events`.`event_id` WHERE `member_id`=? ORDER BY `answer_limitation` ASC';
  $data = array($_SESSION['id']);
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);

   while(true) {
      $tsuuti_event = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($event_joining);
//       exit();
    if ($tsuuti_event == false) {
         break;
      }
 $join_sql = 'SELECT COUNT(*) AS `join_count` FROM `kami_event_joinings` WHERE `event_id`=?';
    $join_data = array($tsuuti_event['event_id']);
    $join_stmt = $dbh->prepare($join_sql);
    $join_stmt->execute($join_data);

    $j_count = $join_stmt->fetch(PDO::FETCH_ASSOC);
    $tsuuti_event['join_count'] = $j_count['join_count'];
    $tsuuti_events[] = $tsuuti_event;
  }
?>