<?php
require_once '../../init.php';

Auth::preventUnauthenticated();

Auth::preventUnauthorized(['pustakawan']);

if (!isset($_GET['type']) || !isset($_GET['action']) || ($_GET['action'] == 'edit' && !isset($_GET['id']))) {
    Utils::navigateTo('index.php');
}

$form = null;

$data_id = isset($_GET['id']) ? $_GET['id'] : null;

$values = null;

switch ($_GET['type']) {
    case 'peminjaman':
        $form = $forms['peminjaman'];
        if ($_GET['action'] == 'edit') {
            $form = [
                'title' => $forms['peminjaman']['title'],
                'inputs' => $forms['peminjaman']['edit_inputs']
            ];
            $values = Peminjaman::getArray($data_id);
            if (!$values) {
                Utils::navigateTo('index.php');
            }
            $values = $values[0];
        }
        break;
}

if (!$form) {
    Utils::navigateTo('index.php');
}

if (isset($_POST['submit'])) {
    switch ($_GET['type']) {
        case 'peminjaman':
            $success = $_GET['action'] == 'add' ? Peminjaman::create($_POST) : Peminjaman::update($data_id, $_POST);
            if ($success) {
                Utils::navigateTo('index.php?page=peminjaman');
            }
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah - <?= $form['title'] ?></title>
    <link rel="stylesheet" href="<?= BASEURL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/form.css">
</head>
<body>
    <div class="overlay"></div>
    <?= Flasher::flash() ?>
    <form action="" method="post" enctype="multipart/form-data">
        <h2><?= ucfirst($_GET['action']) ?> Data <?= $form['title'] ?></h2>
        <?php $index = 0; ?>
        <?php foreach ($form['inputs'] as $input) : ?>
            <?php if ($input['type'] == 'textarea') : ?>
                <textarea name="<?= $input['name'] ?>" placeholder="<?= $input['placeholder'] ?>" cols="30" rows="8"
                <?= $_GET['action'] == 'edit' ? "value='".$values['f_deskripsi']."'" :'' ?>><?= $_GET['action'] == 'edit' ? $values[$index] : '' ?></textarea>
            <?php elseif ($input['type'] == 'select') : ?>
                <div class="select">
                    <select name="<?= $input['name'] ?>" id="<?= $input['name'] ?>">
                        <option disabled <?= $_GET['action'] == 'add'?'selected':'' ?>><?= $input['placeholder'] ?></option>
                        <?php foreach ($input['options'] as $option) : ?>
                            <option value="<?= $option['id'] ?>"
                            <?php if ($_GET['action'] == 'edit') : ?>
                                <?= ($option['value'] == $values[$index] ? 'selected' : '') ?>
                            <?php endif;?>
                            ><?= $option['value'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php else : ?>
                <?php if ($input['type'] == 'date') : ?>
                    <p id="date-placeholder"><?= $input['placeholder'] ?></p>
                <?php elseif ($input['type'] == 'password') : ?>
                    <input hidden value="<?= $values[$index] ?>" name="old_password">
                <?php endif; ?>
                <input type="<?= $input['type'] ?>" <?= $_GET['action'] == 'edit' ? "value='".$values[$index]."'" :'required' ?> name="<?= $input['name'] ?>" placeholder="<?= $input['placeholder'] ?>" <?= isset($input['atributes'])?$input['atributes']:"" ?> autocomplete="off">
            <?php endif;$index++; ?>
        <?php endforeach; ?>
        <button type="submit" name="submit"><?= $_GET['action'] == 'edit'?'Simpan':'Tambah' ?></button>
    </form>
    <script src="<?= BASEURL ?>/js/index.js"></script>
    <script src="<?= BASEURL ?>/js/utils.js"></script>
    <script src="<?= BASEURL ?>/js/preview-image.js"></script>
</body>
</html>