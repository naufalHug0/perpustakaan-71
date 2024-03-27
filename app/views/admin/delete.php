<?php

require_once '../../init.php';

Auth::preventUnauthenticated();

$access_owner = ['admin'];

if (!isset($_GET['type']) && !isset($_GET['id'])) {
    Utils::navigateTo('index.php?page=' . $type);
}

Auth::preventUnauthorized($access_owner);

switch ($_GET['type']) {
    case 'kategori':
        Kategori::delete($_GET['id']);
        Utils::navigateTo('index.php?page=kategori');
        break;
    case 'buku':
        Buku::delete($_GET['id']);
        Utils::navigateTo('index.php?page=buku');
        break;
    case 'anggota':
        Anggota::delete($_GET['id']);
        Utils::navigateTo('index.php?page=anggota');
        break;
    case 'admin':
        Admin::delete($_GET['id']);
        Utils::navigateTo('index.php?page=admin');
        break;
}