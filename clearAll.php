<?php
session_start();

if (isset($_GET['task']) && $_GET['task'] == 'yes') {
    foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) {
        if ($TODOLIST['status'] == 'Task') {
            unset($_SESSION['TODOLIST'][$index]);
        }
    }
} elseif (isset($_GET['progress']) && $_GET['progress'] == 'yes') {
    foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) {
        if ($TODOLIST['status'] == 'In Progress') {
            unset($_SESSION['TODOLIST'][$index]);
        }
    }
} elseif (isset($_GET['done']) && $_GET['done'] == 'yes') {
    foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) {
        if ($TODOLIST['status'] == 'Done') {
            unset($_SESSION['TODOLIST'][$index]);
        }
    }
} else {
    unset($_SESSION['TODOLIST']);
}

header("Location: index.php");