<?php
session_start();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color: #cccfcd;
        }

        .card {
            padding-left: 0;
            padding-right: 0;
        }
    </style>
</head>

<body>
    <div class="container mt-2">
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
                    <div class="toast-header bg-<?= $_SESSION['type']; ?> text-light">
                        <strong class="me-auto">Notifikasi</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?= $_SESSION['message']; ?>
                    </div>
                </div>
            </div>

            <?php
            unset($_SESSION['message']);
            unset($_SESSION['type']);
            ?>

        <?php endif; ?>
        <div class="accordion mb-4" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Form TO DO LIST
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <form action="proses.php" method="post">
                            <div class="mb-3">
                                <label for="InputName" class="form-label">Nama Projek</label>
                                <input type="text" name="name" class="form-control" id="InputName" placeholder="Input Todo List">
                            </div>
                            <div class="mb-3">
                                <label for="InputName" class="form-label">Priority Level</label>
                                <select name="priority" id="" class="form-select">
                                    <option value="low" class="bg-success">Low</option>
                                    <option value="medium" class="bg-warning">Medium</option>
                                    <option value="high" class="bg-danger">High</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="task-list row">
            <div class="card border-info mb-3 col m-3">
                <div class="card-header bg-info text-dark">Task</div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['TODOLIST']) && !empty($_SESSION['TODOLIST'])) :

                        usort($_SESSION['TODOLIST'], function ($a, $b) {
                            $priorityOrder = ['high' => 1, 'medium' => 2, 'low' => 3];
                            return $priorityOrder[$a['priority']] <=> $priorityOrder[$b['priority']];
                        });

                        foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) :
                            if ($TODOLIST['status'] == 'Task') :
                                if ($TODOLIST['priority'] == 'high') {
                                    $class = 'border-danger';
                                } elseif ($TODOLIST['priority'] == 'medium') {
                                    $class = 'border-warning';
                                } elseif ($TODOLIST['priority'] == 'low') {
                                    $class = 'border-success';
                                }
                    ?>
                                <!-- Tampilkan data dari session -->
                                <div class="card <?= $class ?> mb-3" style="max-width: 18rem;">
                                    <?php
                                    if (isset($_GET['edit']) && $_GET['edit'] == 'yes' && $TODOLIST['id'] == $_GET['id']) :
                                    ?>
                                        <form action="proses.php?edit=yes&id=<?= $TODOLIST['id'] ?>" method="post">
                                            <input type="hidden" name="id" value="<?= $TODOLIST['id'] ?>">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <input type="text" name="name" id="InputName" value="<?= $TODOLIST['name'] ?>">
                                                </h5>
                                                <p class="card-text">
                                                    Priority:
                                                    <select name="priority" id="">
                                                        <option value="low" class="bg-success" <?= $TODOLIST['priority'] == 'low' ? 'selected' : '' ?>>Low</option>
                                                        <option value="medium" class="bg-warning" <?= $TODOLIST['priority'] == 'medium' ? 'selected' : '' ?>>Medium</option>
                                                        <option value="high" class="bg-danger" <?= $TODOLIST['priority'] == 'high' ? 'selected' : '' ?>>High</option>
                                                    </select>
                                                </p>
                                            </div>

                                            <div class="card-button d-flex justify-content-end mb-2">
                                                <a href="index.php" class="btn btn-secondary me-2 btn-sm">Cancel</a>
                                                <button type="submit" class="btn btn-primary btn-sm me-2">Update</button>
                                            </div>
                                        </form>
                                    <?php
                                    else :
                                    ?>
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $TODOLIST['name'] ?></h5>
                                            <p class="card-text">Priority: <?= ucfirst($TODOLIST['priority']) ?></p>
                                        </div>
                                        <div class="card-button d-flex justify-content-end mb-2">
                                            <a href="index.php?edit=yes&id=<?= $TODOLIST['id'] ?>" class="btn btn-primary me-2 btn-sm">Edit</a>
                                            <a href="proses.php?delete=yes&id=<?= $TODOLIST['id'] ?>" class="btn btn-danger me-2 btn-sm" onclick="return confirm('Yakin ingin dihapus?')">Delete</a>
                                            <a href="proses.php?inprogress=yes&id=<?= $TODOLIST['id'] ?>" class="btn btn-success me-2 btn-sm">Mark as Progress</a>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                        <?php
                            endif;
                        endforeach;
                        ?>

                        <a href="clearAll.php?task=yes" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin dihapus?')">Clear All</a>

                    <?php
                    else :
                        echo "<p>Belum ada tugas yang ditambahkan.</p>";
                    endif;
                    ?>
                </div>

            </div>

            <div class="card border-warning mb-3 col m-3">
                <div class="card-header bg-warning text-dark">In Progress</div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['TODOLIST']) && !empty($_SESSION['TODOLIST'])) :

                        usort($_SESSION['TODOLIST'], function ($a, $b) {
                            $priorityOrder = ['high' => 1, 'medium' => 2, 'low' => 3];
                            return $priorityOrder[$a['priority']] <=> $priorityOrder[$b['priority']];
                        });

                        foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) :
                            if ($TODOLIST['status'] == 'In Progress') :
                    ?>
                                <!-- Tampilkan data dari session -->
                                <div class="card text-bg-warning mb-3" style="max-width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $TODOLIST['name'] ?></h5>
                                        <p class="card-text">Priority: <?= ucfirst($TODOLIST['priority']) ?></p>
                                    </div>
                                    <div class="card-button d-flex justify-content-end mb-2">
                                        <a href="proses.php?delete=yes&id=<?= $TODOLIST['id'] ?>" class="btn btn-danger me-2 btn-sm" onclick="return confirm('Yakin ingin dihapus?')">Delete</a>
                                        <a href="proses.php?done=yes&id=<?= $TODOLIST['id'] ?>" class="btn btn-success me-2 btn-sm">Mark as Done</a>
                                    </div>
                                </div>
                        <?php
                            endif;
                        endforeach;
                        ?>

                        <a href="clearAll.php?progress=yes" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin dihapus?')">Clear All</a>

                    <?php
                    else :
                        echo "<p>Belum ada tugas yang ditambahkan.</p>";
                    endif;
                    ?>
                </div>
            </div>

            <div class="card border-success mb-3 col m-3">
                <div class="card-header bg-success text-light">Done</div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['TODOLIST']) && !empty($_SESSION['TODOLIST'])) :

                        usort($_SESSION['TODOLIST'], function ($a, $b) {
                            $priorityOrder = ['high' => 1, 'medium' => 2, 'low' => 3];
                            return $priorityOrder[$a['priority']] <=> $priorityOrder[$b['priority']];
                        });

                        foreach ($_SESSION['TODOLIST'] as $index => $TODOLIST) :
                            if ($TODOLIST['status'] == 'Done') :
                    ?>
                                <!-- Tampilkan data dari session -->
                                <div class="card text-bg-success mb-3" style="max-width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $TODOLIST['name'] ?></h5>
                                        <p class="card-text">Priority: <?= ucfirst($TODOLIST['priority']) ?></p>
                                    </div>
                                    <div class="card-button d-flex justify-content-end mb-2">
                                        <a href="proses.php?delete=yes&id=<?= $TODOLIST['id'] ?>" class="btn btn-danger me-2 btn-sm" onclick="return confirm('Yakin ingin dihapus?')">Delete</a>
                                    </div>
                                </div>

                        <?php
                            endif;
                        endforeach;
                        ?>

                        <a href="clearAll.php?done=yes" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin dihapus?')">Clear All</a>

                    <?php
                    else :
                        echo "<p>Belum ada tugas yang ditambahkan.</p>";
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <?php
        if (isset($_SESSION['TODOLIST']) && !empty($_SESSION['TODOLIST'])) :
        ?>
            <a href="clearAll.php" class="btn btn-danger m-2" onclick="return confirm('Yakin ingin dihapus?')">Clear All Task</a>
        <?php
        endif;
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toastElement = document.getElementById('liveToast');
            if (toastElement) {
                var toast = new bootstrap.Toast(toastElement);
                toast.show();
            }
        });
    </script>
</body>

</html>