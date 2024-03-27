<?php
require_once '../../init.php';

Auth::preventUnauthenticated();

Auth::preventUnauthorized(['admin']);

if (!isset($_GET['type']) || !isset($_GET['action']) || ($_GET['action'] == 'edit' && !isset($_GET['id']))) {
    Utils::navigateTo('index.php');
}

$form = null;

$data_id = isset($_GET['id']) ? $_GET['id'] : null;

$values = null;

switch ($_GET['type']) {
    case 'kategori':
        $form = $forms['kategori'];
        if ($_GET['action'] == 'edit') {
            $values = Kategori::getArray($data_id);
            if (!$values) {
                Utils::navigateTo('index.php');
            }
            $values = $values[0];
        }
        break;
    case 'buku':
        $form = $forms['buku'];
        if ($_GET['action'] == 'edit') {
            $values = Buku::getArray($data_id);
            if (!$values) {
                Utils::navigateTo('index.php');
            }
            $values = $values[0];
        }
        break;
    case 'anggota':
        $form = $forms['anggota'];
        if ($_GET['action'] == 'edit') {
            $values = Anggota::getArray($data_id);
            if (!$values) {
                Utils::navigateTo('index.php');
            }
            $values = $values[0];
        }
        break;
    case 'admin':
        $form = $forms['admin'];
        if ($_GET['action'] == 'edit') {
            $values = Admin::getArray($data_id);
            if (!$values) {
                Utils::navigateTo('index.php');
            }
            $values = $values[0];
        }
        break;
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
        case 'kategori':
            $success = $_GET['action'] == 'add' ? Kategori::create($_POST) : Kategori::update($data_id, $_POST);
            if ($success) {
                Utils::navigateTo('index.php?page=kategori');
            } 
            break;
        case 'buku':
            $success = $_GET['action'] == 'add' ? Buku::create($_POST, $_FILES) : Buku::update($data_id, $_POST, $_FILES);
            if ($success) {
                Utils::navigateTo('index.php?page=buku');
            }
            break;
        case 'anggota':
            $success = $_GET['action'] == 'add' ? Anggota::create($_POST) : Anggota::update($data_id, $_POST);
            if ($success) {
                Utils::navigateTo('index.php?page=anggota');
            }
            break;
        case 'peminjaman':
            $success = $_GET['action'] == 'add' ? Peminjaman::create($_POST) : Peminjaman::update($data_id, $_POST);
            if ($success) {
                Utils::navigateTo('index.php?page=peminjaman');
            }
            break;
        case 'admin':
            $success = $_GET['action'] == 'add' ? Admin::create($_POST) : Admin::update($data_id, $_POST);
            if ($success) {
                Utils::navigateTo('index.php?page=admin');
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
            <?php elseif ($input['type'] == 'file') : ?>
                <div class="upload">
                    <input type="file" name="<?= $input['name'] ?>" id="file" <?= $_GET['action'] == 'add' ? 'required':'' ?> accept="image/*" >
                    <?php if ($_GET['action'] == 'edit') : ?>
                        <input hidden name="old_img" value="<?= $values[$index] ?>">
                    <?php endif; ?>
                    <div class="preview-img">
                        Preview
                    </div>
                </div>
                <div id="image-prev"></div>
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