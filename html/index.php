<?php

// Read functions file for helper functions
require_once("inc/functions.php");
// Read config file for settings
require_once("inc/config.php");

$rand_v = "?v=" . rand(10000, 99999);

// To print the max file size in human readable format
$max_filesize_msg = human_readable_size($max_file_size, 0);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mini Image Host - <?= $domain ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="static/styles.css<?= $rand_v ?>">
</head>

<body>

    <?php
    // Display the images in gallery
    if (isset($_REQUEST['gallery'])):
        $files = scandir($image_path);

        $files = array_diff($files, array('.', '..'));
        // Sort files by modified time, latest first
        usort($files, function ($a, $b) use ($image_path) {
            return filemtime($image_path . $b) - filemtime($image_path . $a);
        });

        // Pagination setup
        $total_files = count($files);
        $total_pages = ceil($total_files / $files_per_page);
        $current_page = isset($_GET['page']) ? max(1, min($total_pages, (int)$_GET['page'])) : 1;
        $start_index = ($current_page - 1) * $files_per_page;

        if ($total_files > 0)
            $files = array_slice($files, $start_index, $files_per_page);

        $has_next_page = $current_page < $total_pages;
        $has_prev_page = $current_page > 1;
    ?>

        <div class="container container-large p-4 bg-white p-3 rounded shadow-sm">

            <h3 class="text-center fw-bold">
                <a href="." class="header-link">Mini Image Host - Gallery</a>
            </h3>


            <div class="d-flex justify-content-center align-items-center mt-4 flex-wrap popup">

                <?php if (count($files) == 0): ?>
                    <div class="text-center text-muted">
                        No images uploaded yet.
                    </div>
                <?php endif; ?>
                <?php if ($total_pages > 1): ?>
                    <div class="input-group mb-3 w-auto">
                        <button class="btn btn-outline-primary <?= $has_prev_page ? '' : 'disabled' ?>" type="button"
                            onclick="location.href='?gallery&page=<?= max(1, $current_page - 1) ?>';">Prev</button>
                        <select class="form-select" style="width: auto;"
                            onchange="location.href='?gallery&page='+this.value;">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <option value="<?= $i ?>" <?= $i == $current_page ? 'selected' : '' ?>>Page <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <button class="btn btn-outline-primary <?= $has_next_page ? '' : 'disabled' ?>" type="button"
                            onclick="location.href='?gallery&page=<?= min($total_pages, $current_page + 1) ?>';">Next</button>
                    </div>
                    <div class="w-100"></div> <!-- Forces line break -->
                <?php endif; ?>
                <div class="row g-2">
                    <?php foreach ($files as $file): ?>
                        <?php $img_url = $protocol . $domain . $image_url . $file ?>

                        <div class="col-6 col-md text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalPopout"
                                onclick="return expandImage('<?= $img_url ?>', '<?= $file ?>');">
                                <img src="<?= $img_url ?>" alt="<?= $file ?>" class="gallery-img">
                            </a>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>

            <div class="footer text-center small mt-3 footer-div">
                Copyright &copy; <?= date("Y") ?> <a href="https://somik.org/" target="_blank">Somik.org</a> |
                <a href="https://kfels.com/reach-out" target="_blank">Reach out</a>
            </div>
        </div>


        <!-- Expand Message Modal -->
        <div class="modal fade" id="modalPopout" tabindex="-1" aria-labelledby="modalPopoutHeader" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title fs-6">Share <span id="modalPopoutHeader"></span></div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center" id="modalPopoutBody">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" readonly aria-describedby="copyBtn" id="modalImageLink">
                            <button class="btn btn-outline-secondary" type="button" id="copyBtn"
                                onclick="copyTextToClipboardBtn2('modalImageLink',this);">Copy</button>
                        </div>
                        <img id="modalImage" src="" alt="Image" class="img-fluid"
                            style="max-height: 70vh; object-fit: contain;">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="showDeleteConfirm();">
                            Delete
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    <?php else: ?>


        <div class="container p-4 bg-white p-3 rounded shadow-sm">

            <h3 class="text-center fw-bold">
                <a href="." class="header-link">Mini Image Host</a>
            </h3>


            <div class="d-flex justify-content-between align-items-center">
                <!-- Host selector -->
                <div class="d-flex align-items-center">
                    <label for="host" class="me-2 fw-semibold">Host:</label>
                    <select id="mirror" class="form-select form-select-sm select-host">
                        <?php foreach ($mirror_list as $mirror => $host): ?>
                            <option value="<?= $host ?>"><?= $mirror ?></option>
                        <?php endforeach; ?>
                        <?php if ($enable_external_hosts): ?>
                            <option disabled> &dArr; External &dArr; </option>
                            <option value="1">PostImages</option>
                            <option value="2">CatBox.moe</option>
                            <option value="3">Pomf2.lain.la</option>
                            <option value="4">0x0.st</option>
                            <option value="5">UploadImgur</option>
                            <option value="6">MyImgs.org</option>
                            <option value="7">ImgHost.cc</option>
                            <option value="8">UpImg</option>
                            <option disabled>──Chevereto──</option>
                            <option value="101">ImgBB</option>
                            <option value="102">FreeImage.host</option>
                            <option value="103">HostImage.org</option>
                            <option value="104">PasteImg</option>
                            <option value="105">ImgBB.ws</option>
                            <option value="106">img.in.th</option>
                            <option value="107">Dodaj.rs</option>
                            <option value="108">Inspirats</option>
                            <option value="109">FxPics.ru</option>
                            <option value="110">Poop.pictures</option>
                            <option value="111">Site.pictures</option>
                            <option value="112">SnappyPic</option>
                            <option value="113">Eikona.info</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Icon buttons -->
                <div class="d-flex">
                    <button class="btn btn-link p-1" title="Text to Image" onclick="showHideContainer();">
                        <i class="bi bi-textarea-t font-20"></i>
                    </button>
                    <a href="?gallery" class="btn btn-link p-1">
                        <i class="bi bi-images font-20"></i>
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <form class="p-2 upload-form" action="#" id="upload-form">
                    <i class="bi bi-cloud-arrow-up-fill font-45"></i>
                    <div>
                        Click or drag or paste image to upload
                    </div>
                    <div class="text-muted small">
                        JPG, JPEG, PNG, WebP, and GIF up to <?= $max_filesize_msg ?>
                    </div>
                    <input type="file" name="file" id="file" hidden accept="image/*" />
                </form>
            </div>

            <div class="flex justify-content-between align-items-center" id="text2image-div" style="display: none;">
                <textarea class="px-2 py-1 text2image mb-2" id="text2image" onchange="txt2imgPreview();"></textarea>
                <button class="form-control btn btn-sm btn-primary" id="text2imageBtn" onclick="text2image(this)">
                    Convert to Image
                </button>
                <a href="#" id="text2imageLink" target="_blank" style="display: none;">
                    <img id="text2imageView" src="" alt="blank" />
                </a>
            </div>

            <div id="progress-area" style="display: none;">
                <div id="progress-card-template">
                    <div class="card d-flex flex-row align-items-center p-2 mt-3">
                        <!-- File icon -->
                        <div class="me-2 text-primary">
                            <i class="bi bi-image font-20"></i>
                        </div>

                        <!-- File details -->
                        <div class="flex-grow-1">
                            <div class="fw-semibold">
                                <span id="progress-filename">Filename.png</span>
                                <span class="text-muted" id="progress-size">[15 KB]</span>
                            </div>
                            <div class="progress mt-2 progress-div">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 40%;" aria-valuenow="40"
                                    aria-valuemin="0" aria-valuemax="100" id="progress-bar"></div>
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="d-flex ms-2">
                            <div class="ms-2 fw-semibold text-primary" id="progress-txt">40%</div>
                            <i class="bi bi-cpu font-20" id="progress-processing" style="display: none;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div id="uploaded-area"></div>


            <!-- Bootstrap Icons -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

            <div class="footer text-center small mt-3 footer-div">
                Copyright © <a href="https://somik.org/" target="_blank">Somik.org</a> <?= date("Y") ?> |
                <a href="https://kfels.com/reach-out" target="_blank">Reach out</a>
            </div>
        </div>

        <div style="display: none;">
            <div id="complete-card-template">
                <div class="card d-flex flex-row align-items-center p-2 mt-3">
                    <!-- File icon -->
                    <div class="me-2 text-primary">
                        <i class="bi bi-image font-20 text-primary"></i>
                    </div>

                    <!-- File details -->
                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            [[FILENAME]]
                            <span class="text-muted">[[[FILESIZE]]]</span>
                        </div>
                        <a href="[[FILELINK]]" target="_blank" class="small">
                            [[FILELINK]]
                        </a>
                    </div>

                    <!-- Action buttons -->
                    <div class="d-flex ms-2">
                        <button class="btn btn-link p-1 text-primary" title="Copy Link">
                            <i class="bi bi-clipboard font-20" onclick="copyTextToClipboardBtn('[[FILELINK]]',this);"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="error-card-template">
                <div class="card d-flex flex-row align-items-center p-2 mt-3">
                    <!-- File icon -->
                    <div class="me-2 text-primary">
                        <i class="bi bi-image font-20 text-primary"></i>
                    </div>

                    <!-- File details -->
                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            [[FILENAME]]
                            <span class="text-muted">[[[FILESIZE]]]</span>
                        </div>
                        [[ERROR_TXT]]
                    </div>

                    <!-- Action buttons -->
                    <div class="d-flex ms-2">
                        <i class="bi bi-exclamation-triangle font-20"></i>
                    </div>
                </div>
            </div>
        </div>

        <script src="static/scripts_autoload.js<?= $rand_v ?>"></script>

    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script src="static/scripts.js<?= $rand_v ?>"></script>
</body>

</html>