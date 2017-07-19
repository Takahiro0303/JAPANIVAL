<?php
// パラメータがなければ、edit_index.phpに遷移
if (!isset($_REQUEST['event_id']) || empty($_REQUEST['event_id'])) {
    header('Location: edit_index.php');
    exit();
}
?> 