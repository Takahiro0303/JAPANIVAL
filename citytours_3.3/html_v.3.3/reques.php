<?php
if (!isset($_REQUEST['event_id']) || empty($_REQUEST['event_id'])) {
    // パラメータがなければ、timeline.phpに遷移
    header('Location: edit_index.php');
    exit();
}
?>