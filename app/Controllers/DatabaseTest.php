<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class DatabaseTest extends Controller
{
    public function index()
    {
        try {
            // Get the default database connection
            $db = Database::connect();

            // Test the connection
            if ($db->connID) {
                echo "Database connection successful!";
            } else {
                echo "Failed to connect to the database.";
            }
        } catch (\Throwable $e) {
            // Catch and display connection errors
            echo "Error: " . $e->getMessage();
        }
    }
}
