<?php

// Read config file for settings
require_once("config.php");

// Allow cross site posting
header("Access-Control-Allow-Origin: *");

// To print the max file size in human readable format
$max_filesize_msg = human_readable_size($max_file_size, 0);

// If file has been posted
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    try {
        if (!file_exists($image_path))
            mkdir($image_path, 0777, true);
        if (!file_exists($thumb_path))
            mkdir($thumb_path, 0777, true);
        //getting file name
        $file_name = $_FILES['file']['name'];
        //getting temp_name of file
        $tmp_name = $_FILES['file']['tmp_name'];

        // Ensure the file has image size parameters
        $image_info = @getimagesize($tmp_name);

        if ($image_info == false)
            throw new Exception('Please upload valid image file.');

        // Check the types of files that are allowed to be uploaded
        $type = $_FILES['file']['type'];
        if (!in_array($type, $allowed_types))
            throw new Exception("Only jpg, jpeg, png, webp, and gif image type supported.");

        // Check the file size is acceptable
        if (filesize($tmp_name) > $max_file_size)
            throw new Exception("File over allowed size of {$max_filesize_msg}");

        // Get the extension of the file
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_id = rand_str(6);

        // Convert webp files into jpg image
        if ($type == 'image/webp') {
            $new_file_name = "{$file_id}.jpg";
            $new_thumb_name = "{$file_id}_thumb.jpg";

            // Convert webp to jpeg with 80% quality and save to save path
            $im = imagecreatefromwebp($tmp_name);
            imagejpeg($im, $image_path . $new_file_name, 80);
            imagedestroy($im);
        }
        // Resize image if it's JPEG and more then 1200px in any side
        elseif ($type == 'image/jpeg' && ($image_info[0] > $max_image_size || $image_info[1] > $max_image_size)) {
            $new_file_name = "{$file_id}.jpg";
            $new_thumb_name = "{$file_id}_thumb.jpg";

            // Resize image to a smaller size
            $source = $tmp_name;
            $dest = $image_path . $new_file_name;
            resizeAndSaveImage($source, $dest, $max_image_size);
        }
        // Move the uploaded file to save path
        else {
            $new_file_name = "{$file_id}.{$file_ext}";
            $new_thumb_name = "{$file_id}_thumb.{$file_ext}";

            // Move the uploaded file to save path (for all other formats)
            move_uploaded_file($tmp_name, $image_path . $new_file_name);
        }

        // Generate thumbnails
        $source = $image_path . $new_file_name;
        $dest = $thumb_path . $new_thumb_name;
        resizeAndSaveImage($source, $dest, 150);

        // Generate the file url and reply
        $url = $protocol . $domain . $image_url . $new_file_name;

        $out = array("status" => "OK", "url" => $url);
        echo json_encode($out);
    }
    // Catch and print the exception
    catch (Exception $e) {
        $out = array("status" => "FAIL", "msg" => $e->getMessage());
        echo json_encode($out);
    }
} elseif ($_REQUEST['delete'] && $_REQUEST['key']) {
    // Delete image and thumbnail if admin key is correct
    $file = $_REQUEST['delete'];
    $key = $_REQUEST['key'];
    if ($key === $admin_key) {
        $file_path = $image_path . $file;
        if (file_exists($file_path) && !is_dir($file_path)) {
            @unlink($file_path);
            $parts = explode(".", $file);
            $thumb_name = $parts[0] . "_thumb." . $parts[1];
            $thumb_path_full = $thumb_path . $thumb_name;
            if (file_exists($thumb_path_full) && !is_dir($thumb_path_full)) {
                @unlink($thumb_path_full);
            }
            echo "Image and thumbnail deleted.";
        } else {
            echo "Image not found.";
        }
    } else {
        echo "Invalid ADMIN_KEY.";
    }
} else {
    $v = "?v=" . rand(1111, 9999);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mini Image Host</title>
        <link rel="stylesheet" href="./static/style.css<?= $v ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    </head>

    <body>

        <?php
        // Display the images in gallery
        if (isset($_REQUEST['gallery'])) {
            $files = scandir($image_path);

            $files = array_diff($files, array('.', '..'));
            // Sort files by modified time, latest first
            usort($files, function ($a, $b) use ($image_path) {
                return filemtime($image_path . $b) - filemtime($image_path . $a);
            });
            if (count($files) == 0) {
                echo "<div class=\"wrapper\"><header onclick=\"location.href='.';\">Mini Image Host</header><p>No images found.</p></div>";
                exit;
            }
        ?>
            <div class="wrapper wrapper-big">
                <i class="fa-solid fa-cloud-arrow-up" onclick="location.href='.';"></i>
                <header onclick="location.href='.';">Mini Image Host</header>
                <div style="margin: 30px 0;">
                    <?php
                    $i = 0;
                    foreach ($files as $file) {
                        $parts = explode(".", $file);
                        $thumb_name = $parts[0] . "_thumb." . $parts[1];
                        $file_url = $protocol . $domain . $image_url . $file;

                        $file_exists = false;
                        if (file_exists($thumb_path . $thumb_name)) {
                            $file_exists = true;
                            $img_scr_url = $protocol . $domain . $thumb_url . $thumb_name;
                        } elseif (!is_dir($image_path . $file)) {
                            $file_exists = true;
                            $img_scr_url = $file_url;
                        }

                        if ($file_exists) {
                    ?>
                            <div class="popup" onclick="showPopup('popup_<?= $i ?>','<?= $file_url ?>')"
                                oncontextmenu="return showDeleteConfirm('<?= $file ?>');">
                                <img src="<?= $img_scr_url ?>" alt="<?= $file_url ?>" />
                                <span class="popuptext" id="popup_<?= $i ?>">Link copied.</span>
                            </div>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>

        <?php } else { ?>

            <div class="wrapper">
                <header onclick="location.href='.';">Mini Image Host</header>
                <div class="mirror-div">
                    Select mirror:
                    <select id="mirror">
                        <?php
                        foreach ($mirror_list as $mirror => $host) {
                            echo "<option value=\"$host\">$mirror</option>";
                        }
                        if ($enable_external_hosts) {
                        ?>
                            <option disabled>--External--</option>
                            <option value="1">PostImages</option>
                            <option value="2">CatBox.moe</option>
                            <option value="3">Pomf2.lain.la</option>
                            <option value="4">0x0.st</option>
                            <option value="5">UploadImgur</option>
                            <option value="6">MyImgs.org</option>
                            <option disabled>──Chevereto──</option>
                            <option value="7">ImgBB</option>
                            <option value="8">FreeImage.host</option>
                            <option value="9">HostImage.org</option>
                            <option value="10">PasteImg</option>
                            <option value="11">ImgBB.ws</option>
                            <option value="12">img.in.th</option>
                            <option value="13">Dodaj.rs</option>
                            <option value="14">Inspirats</option>
                            <option value="15">FxPics.ru</option>
                            <option value="16">Poop.pictures</option>
                            <option value="17">Site.pictures</option>
                            <option value="18">SnappyPic</option>
                            <option value="19">Eikona.info</option>
                        <?php
                        }
                        ?>
                    </select>
                    <i class="fa-solid fa-images" onclick="location.href='./?gallery';" style="float:right; font-size: 20pt;"></i>
                    <i class="fa-regular fa-message" onclick="showHideContainer('txt2imgDiv');" style="float:right; font-size: 20pt;"></i>
                </div>
                <form action="#">
                    <input class="file-input" type="file" name="file" id="file" hidden>
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Click or drag or paste image to upload</p>
                    <span class="small">Max file size:
                        <?= $max_filesize_msg ?>
                    </span>
                </form>
                <div id="txt2imgDiv" style="display: none;">
                    <textarea rows="10" id="txt2img" name="textblk" placeholder="Enter text here to convert to image"></textarea>
                    <button id="txt2imgBtn" onclick="text2image(this)">Convert Text to Image</button>
                </div>
                <section class="progress-area"></section>
                <section class="uploaded-area"></section>
            </div>

            <script>
                const form = document.querySelector("form");
                const fileInput = document.querySelector(".file-input");
                const progressArea = document.querySelector(".progress-area");
                const uploadedArea = document.querySelector(".uploaded-area");

                // form click event
                form.addEventListener("click", () => {
                    fileInput.click();
                });

                // file input change event
                fileInput.onchange = ({
                    target
                }) => {
                    let file = target.files[0];
                    if (file) {
                        let fileName = file.name;
                        if (fileName.length >= 12) {
                            let lastIndex = fileName.lastIndexOf('.');
                            let name = fileName.slice(0, lastIndex);
                            let ext = fileName.slice(lastIndex + 1);
                            fileName = name.substring(0, 13) + "... ." + ext;
                        }
                        uploadFile(fileName);
                    }
                }

                // form dragover or drop event
                ['dragover', 'dragleave', 'drop'].forEach(eventName => {
                    document.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });

                // handle dropped files
                document.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    if (dt.files && dt.files.length > 0) {
                        console.log('File(s) dropped');
                        console.log(dt.files);
                        const file = dt.files[0];
                        setFileInput(file);
                    }
                });

                // handle pasted images
                document.addEventListener('paste', function(e) {
                    const items = (event.clipboardData || event.originalEvent.clipboardData || window.clipboardData).items;
                    for (let i = 0; i < items.length; i++) {
                        if ((items[i].kind === 'file' && items[i].type.startsWith('image/')) || (items[i].type.indexOf("image") !== -1)) {
                            console.log('Pasted image');
                            console.log(items[i]);
                            const file = items[i].getAsFile();
                            setFileInput(file);
                            e.preventDefault();
                            break; // We only need the first image
                        } else if (items[i].kind === 'string' && items[i].type === 'text/plain') {
                            // Handle pasted text
                            items[i].getAsString(function(text) {
                                document.getElementById("txt2img").value = text;
                            });
                            document.getElementById("txt2imgDiv").style.display = "block";
                            form.style.display = "none";
                            e.preventDefault();
                        }
                    }
                });
            </script>

        <?php } ?>

        <script src="./static/script.js<?= $v ?>"></script>

    </body>

    </html>

<?php

}



// Function used to generate a random string for filename
function rand_str($length = 10)
{
    $characters = '23456789abcdefghjkmnpqrtuvwxyzABCDEFGHJKLMNPQRTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


// Conver byte size to human redable size
function human_readable_size($raw_size, $return_array = true)
{
    $size_arr = array("B", "KB", "MB", "GB", "TB", "PB");
    $max = count($size_arr) - 1;

    for ($i = $max; $i >= 0; $i--) {
        $value = pow(1024, $i);

        if ($raw_size > $value) {
            $size_hr = round(($raw_size / $value), 2);

            return $return_array ? array($size_hr, $size_arr[$i]) : "{$size_hr} {$size_arr[$i]}";
        }
    }
}



// Resize and save image
function resizeAndSaveImage($source, $dest, $maxSize = 200)
{
    // get source image size
    $img_details = getimagesize($source);
    $w = $img_details[0];
    $h = $img_details[1];
    $img_type = $img_details[2];

    // specifying the required image size
    if ($w > $h) {
        $new_width = $maxSize;
        $new_height = ceil($maxSize * $h / $w);
    } else {
        $new_height = $maxSize;
        $new_width = ceil($maxSize * $w / $h);
    }

    if ($img_type == IMAGETYPE_GIF) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    } elseif ($img_type == IMAGETYPE_JPEG) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    } elseif ($img_type == IMAGETYPE_PNG) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }

    if ($imgt) {
        $old_image = $imgcreatefrom($source);
        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $w, $h);
        $save = $imgt($new_image, $dest);
    }
}
