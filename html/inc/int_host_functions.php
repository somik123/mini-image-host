<?php

$int_file_hash_db = '../db/int_file_hash.db';

initialize_int_file_hash_db();


// Initialize the internal SQLite database for file hashes if it doesn't exist
function initialize_int_file_hash_db()
{
    global $int_file_hash_db;
    if (!file_exists($int_file_hash_db)) {
        $db = new SQLite3($int_file_hash_db, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        $db->busyTimeout(5000); // Set busy timeout to 5 seconds

        $db->exec('CREATE TABLE IF NOT EXISTS file_hashes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            file_name TEXT NOT NULL,
            file_ext TEXT NOT NULL,
            file_hash TEXT NOT NULL,
            upload_time DATETIME DEFAULT CURRENT_TIMESTAMP
        )');
        $db->close();
    }
}


// Add a new file hash entry to the database
function add_file_hash($file_name, $file_ext, $file_hash)
{
    global $int_file_hash_db;
    $db = new SQLite3($int_file_hash_db, SQLITE3_OPEN_READWRITE);
    $db->busyTimeout(5000); // Set busy timeout to 5 seconds

    $stmt = $db->prepare('INSERT INTO file_hashes (file_name, file_ext, file_hash) VALUES (:file_name, :file_ext, :file_hash)');
    $stmt->bindValue(':file_name', $file_name, SQLITE3_TEXT);
    $stmt->bindValue(':file_ext', $file_ext, SQLITE3_TEXT);
    $stmt->bindValue(':file_hash', $file_hash, SQLITE3_TEXT);
    $stmt->execute();
    $db->close();
}


// Retrieve a file entry by its hash
function get_file_by_hash($file_hash)
{
    global $int_file_hash_db;
    $db = new SQLite3($int_file_hash_db, SQLITE3_OPEN_READONLY);
    $db->busyTimeout(5000); // Set busy timeout to 5 seconds

    $stmt = $db->prepare('SELECT file_name, file_ext FROM file_hashes WHERE file_hash = :file_hash LIMIT 1');
    $stmt->bindValue(':file_hash', $file_hash, SQLITE3_TEXT);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();

    return $row ? $row : null;
}


// Delete a file hash entry from the database
function delete_hash_entry($file_path)
{
    global $int_file_hash_db;
    $db = new SQLite3($int_file_hash_db, SQLITE3_OPEN_READWRITE);
    $db->busyTimeout(5000); // Set busy timeout to 5 seconds

    $file_name = pathinfo($file_path, PATHINFO_FILENAME);
    $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);

    $stmt = $db->prepare('DELETE FROM file_hashes WHERE file_name = :file_name AND file_ext = :file_ext');
    $stmt->bindValue(':file_name', $file_name, SQLITE3_TEXT);
    $stmt->bindValue(':file_ext', $file_ext, SQLITE3_TEXT);
    $stmt->execute();
    $db->close();
}



// Check if a file with the same hash already exists in the database
function is_duplicate_file($file_path, $new_file_name, $new_file_ext)
{
    if (file_exists($file_path) && is_readable($file_path)) {
        $file_hash = hash_file('sha256', $file_path);

        if ($file_hash) {
            $existing_file = get_file_by_hash($file_hash);
            if ($existing_file) { // File already exists
                return $existing_file;
            } else { // Add file hash to database if file does not exist
                add_file_hash($new_file_name, $new_file_ext, $file_hash);
                return null;
            }
        } else {
            throw new Exception("Failed to compute file hash.");
        }
    } else {
        throw new Exception("File does not exist or is not readable.");
    }
}


// Delete the entire file hash database (use with caution)
function delete_file_hash_db()
{
    global $int_file_hash_db;
    if (file_exists($int_file_hash_db)) {
        @unlink($int_file_hash_db);
    }
}


// Resize and save image using Imagick
function resizeAndSaveImage($source, $dest, $maxSize = 200)
{
    if (!file_exists($source)) {
        return false;
    }

    try {
        $im = new Imagick($source);
        $im->thumbnailImage($maxSize, $maxSize, true); // maintain aspect ratio
        $im->writeImage($dest);
        $im->destroy();
        return true;
    } catch (ImagickException $e) {
        error_log("Image resizing failed: " . $e->getMessage());
        return false;
    }
}