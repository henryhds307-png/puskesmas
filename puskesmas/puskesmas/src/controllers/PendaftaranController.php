<?php

namespace App\Controllers;

use App\Database\Connection;

class PendaftaranController
{
    protected $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function showRegistrationForm()
    {
        include '../src/views/pendaftaran.php';
    }

    public function registerPatient($data)
    {
        $insertSQL = sprintf(
            "INSERT INTO pasien (nm_pasien, jenkel, tmpt_lahir, tgl_lahir, alamat, kd_poli, nm_dokter, tgl_berobat, keluhan, no_hp) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            $this->getSQLValueString($data['nm_pasien'], "text"),
            $this->getSQLValueString($data['jenkel'], "text"),
            $this->getSQLValueString($data['tmpt_lahir'], "text"),
            $this->getSQLValueString($data['tgl_lahir'], "date"),
            $this->getSQLValueString($data['alamat'], "text"),
            $this->getSQLValueString($data['kd_poli'], "text"),
            $this->getSQLValueString($data['nm_dokter'], "text"),
            $this->getSQLValueString($data['tgl_berobat'], "date"),
            $this->getSQLValueString($data['keluhan'], "text"),
            $this->getSQLValueString($data['no_hp'], "text")
        );

        $result = mysqli_query($this->db, $insertSQL);

        if ($result) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location.href = '../public/jadwal_penanganan.php';</script>";
        } else {
            die(mysqli_error($this->db));
        }
    }

    private function getSQLValueString($theValue, $theType)
    {
        $theValue = mysqli_real_escape_string($this->db, $theValue);

        switch ($theType) {
            case "text":
                return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            case "long":
            case "int":
                return ($theValue != "") ? intval($theValue) : "NULL";
            case "double":
                return ($theValue != "") ? doubleval($theValue) : "NULL";
            case "date":
                return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            default:
                return "NULL";
        }
    }
}