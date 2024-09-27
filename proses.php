<?php

session_start();

if (isset($_GET['edit']) && $_GET['edit'] == 'yes') {

    // Proses edit data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $priority = $_POST['priority'];


        $editTask = [
            'id' => $id,
            'name' => $name,
            'priority' => $priority,
            'status' => 'Task',
        ];

        if (!empty($name) && !empty($priority)) {
            foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) {
                if ($TODOLIST['id'] == $id) {
                    $_SESSION['TODOLIST'][$index] = $editTask;
                    break;
                }
            }

            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Task berhasil diedit';
        } else {
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Task gagal diedit';
        }

        header("Location: index.php");
        exit();
    }

    // Proses hapus data
} elseif (isset($_GET['delete']) && $_GET['delete'] == 'yes') {
    if (isset($_SESSION['TODOLIST'])) {
        foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) {
            if ($TODOLIST['id'] == $_GET['id']) {
                unset($_SESSION['TODOLIST'][$index]);
                break;
            }
        }

        $_SESSION['type'] = 'danger';
        $_SESSION['message'] = 'Task berhasil dihapus';
        header("Location: index.php");
        exit();
    }

    // Proses penandaan task yang sedang berjalan
} elseif (isset($_GET['inprogress']) && $_GET['inprogress'] == 'yes') {
    if (isset($_SESSION['TODOLIST'])) {
        foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) {
            if ($TODOLIST['id'] == $_GET['id']) {
                $_SESSION['TODOLIST'][$index]['status'] = 'In Progress';
                break;
            }
        }
        header("Location: index.php");
        exit();
    }

    // Proses penandaan task yang selesai
} elseif (isset($_GET['done']) && $_GET['done'] == 'yes') {
    if (isset($_SESSION['TODOLIST'])) {
        foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) {
            if ($TODOLIST['id'] == $_GET['id']) {
                $_SESSION['TODOLIST'][$index]['status'] = 'Done';
                break;
            }
        }
        header("Location: index.php");
        exit();
    }
} else {

    // Proses create data Task
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $_POST['name'];
        $priority = $_POST['priority'];

        $newTask = [
            'id' => uniqid(),
            'name' => $name,
            'priority' => $priority,
            'status' => 'Task',
        ];

        if (!isset($_SESSION['TODOLIST'])) {
            $_SESSION['TODOLIST'] = [];
        }

        if (!empty($name) && !empty($priority)) {
            $_SESSION['TODOLIST'][] = $newTask;

            $_SESSION['type'] = 'success';
            $_SESSION['message'] = 'Task berhasil ditambahkan';
        } else {
            $_SESSION['type'] = 'danger';
            $_SESSION['message'] = 'Nama tidak boleh kosong';
        }


        header("Location: index.php");
        exit();
    }
}
