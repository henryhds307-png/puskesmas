<?php
require_once('../src/db/koneksi.php');

// Include necessary controllers
require_once('../src/controllers/PendaftaranController.php');

// Initialize the PendaftaranController
$pendaftaranController = new PendaftaranController();

// Handle routing logic
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'pendaftaran':
        $pendaftaranController->showForm();
        break;
    case 'submit':
        $pendaftaranController->submitForm();
        break;
    default:
        // Load the main landing page or redirect
        include('../src/views/pendaftaran.php');
        break;
}
?>