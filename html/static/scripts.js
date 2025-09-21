
// Main function to copy text to clipboard
function copyTextToClipboardBtn(text, elBtn) {
    copyToClipboard(text);
    elBtn.className = "bi bi-check2 text-success font-20";
    setTimeout(() => {
        elBtn.className = "bi bi-clipboard font-20";
    }, 3000);
}


// Copy text from a specified element (by ID) to clipboard
function copyTextToClipboardBtn2(textId, elBtn) {
    var text = document.getElementById(textId).value || document.getElementById(textId).innerText;
    copyToClipboard(text);
    elBtn.innerText = "Copied!";
    elBtn.disabled = true;
    setTimeout(() => {
        elBtn.innerText = "Copy";
        elBtn.disabled = false;
    }, 3000);
}


function copyTextToClipboardBtn3(text, elBtn) {
    copyToClipboard(text);
    elBtn.className = "bi bi-check2 text-success";
    setTimeout(() => {
        elBtn.className = "bi bi-clipboard";
    }, 3000);
}


// Enhanced function to handle both modern and fallback methods
function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        // Modern API (requires HTTPS or localhost)
        return navigator.clipboard.writeText(text).then(() => {
            console.log("Copied using navigator.clipboard:", text);
        }).catch(err => {
            console.error("Clipboard API failed, falling back:", err);
            fallbackCopy(text);
        });
    } else {
        // Fallback for older browsers / insecure contexts
        fallbackCopy(text);
    }
}


// Fallback method using a temporary textarea
function fallbackCopy(text) {
    const textarea = document.createElement("textarea");
    textarea.value = text;
    textarea.style.position = "fixed";  // avoid scrolling
    textarea.style.top = "0";
    textarea.style.left = "0";
    textarea.style.opacity = "0";

    document.body.appendChild(textarea);
    textarea.focus();
    textarea.select();

    try {
        document.execCommand("copy");
        console.log("Copied using execCommand:", text);
    } catch (err) {
        console.error("Fallback copy failed:", err);
    }

    document.body.removeChild(textarea);
}



// Expand image in modal
function expandImage(src, filename) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalPopoutHeader').innerText = filename;
    document.getElementById('modalImageLink').value = src;
    return false;
}


// Show delete confirmation prompt for gallery image deletion
function showDeleteConfirm() {
    var file = document.getElementById("modalPopoutHeader").innerText;
    var ret = prompt("Provide ADMIN_KEY to delete this image " + file + ":", "");
    if (ret != null) {
        var url = "api.php?delete&file=" + file + "&key=" + ret;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onload = function () {
            console.log("Response: " + xhr.responseText);
            if (xhr.responseText == "" || xhr.status != 200) {
                alert("Delete failed. Check console for details.");
            } else {
                alert(xhr.responseText);
                location.reload();
            }
        }
        xhr.send();
    }
    return false;
}



// Show delete confirmation prompt for external host short link deletion
function showDeleteConfirmExt(short_code) {
    var ret = prompt("Provide ADMIN_KEY to delete this short_code " + short_code + ":", "");
    if (ret != null) {
        var url = "api.php?delete&short_code=" + short_code + "&key=" + ret;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onload = function () {
            console.log("Response: " + xhr.responseText);
            if (xhr.responseText == "" || xhr.status != 200) {
                alert("Delete failed. Check console for details.");
            } else {
                alert(xhr.responseText);
                location.reload();
            }
        }
        xhr.send();
    }
    return false;
}



// file upload function
function uploadFile(name) {
    let fileSize;
    let mirror = "";
    let url;
    let data;

    name = shortenFilename(name, 20); // Shorten filename for display

    let progressArea = document.getElementById("progress-area");
    let progressFilename = document.getElementById("progress-filename");
    let progressBar = document.getElementById("progress-bar");
    let progressTxt = document.getElementById("progress-txt");
    let progressProcessing = document.getElementById("progress-processing");
    let progressSize = document.getElementById("progress-size");

    let uploadedArea = document.getElementById("uploaded-area");
    let completeCardHtml = document.getElementById("complete-card-template").innerHTML;
    let errorCardHtml = document.getElementById("error-card-template").innerHTML;

    let mirrorEl = document.getElementById("mirror");
    // This is only for external mirrors, internal uploads will ignore this
    if (mirrorEl.value.length > 0 && parseInt(mirrorEl.value, 10) == 0) {
        mirror = "https://" + mirrorEl.value + "/";
    }

    url = mirror + "api.php";

    data = new FormData();
    data.append('file', document.getElementById("file").files[0]);
    data.append('file_host', mirrorEl.value);


    let xhr = new XMLHttpRequest();
    xhr.open("POST", url);

    xhr.upload.addEventListener("progress", ({ loaded, total }) => {
        // Get the file size in KB/MB
        let fileTotal = Math.floor(total / 1000);
        fileSize = (fileTotal < 1024) ? fileTotal + " KB" : (loaded / (1024 * 1024)).toFixed(2) + " MB";

        // Get the progress percentage
        let fileLoaded = Math.floor((loaded / total) * 100);

        // Update the progress bar and text
        progressFilename.innerText = name;
        progressBar.style.width = fileLoaded + "%";
        progressBar.setAttribute("aria-valuenow", fileLoaded);
        progressTxt.innerText = fileLoaded + "%";
        progressSize.innerText = "[" + fileSize + "]";

        // Show processing icon if upload is complete but server is still processing
        if (fileLoaded >= 100) {
            progressProcessing.style.display = "";
            progressTxt.style.display = "none";
        }
        else {
            progressProcessing.style.display = "none";
            progressTxt.style.display = "";
        }

        // Show the progress area
        progressArea.style.display = "";

    });
    xhr.onload = function () {

        progressArea.style.display = "none";
        progressProcessing.style.display = "none";
        progressTxt.style.display = "";

        // Upload failed with HTTP error
        if (xhr.status != 200) {
            alert("Upload failed. Check console for details.");
            console.error("Upload error:", xhr.statusText);
            progressArea.style.display = "none";
            return;
        }

        // Parse JSON response
        var api_reply = JSON.parse(xhr.responseText);
        if (api_reply['status'] == "OK") { // Upload successful

            let url = api_reply['url'];

            let uploadedHTML = completeCardHtml;
            uploadedHTML = uploadedHTML
                .replace('[[FILENAME]]', name)
                .replace('[[FILESIZE]]', fileSize)
                .replaceAll('[[FILELINK]]', url);

            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);

        } else if (api_reply['status'] == "FAIL") { // Upload failed with error

            let error = api_reply['msg'];

            progressArea.innerHTML = "";
            let uploadedHTML = errorCardHtml;
            uploadedHTML = uploadedHTML
                .replace('[[FILENAME]]', name)
                .replace('[[FILESIZE]]', fileSize)
                .replace('[[ERROR_TXT]]', error);
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
    }

    xhr.send(data);
}



// Convert text to image and set file input
function text2image(button) {
    button.disabled = true;
    button.innerHTML = "Converting...";

    var text = document.getElementById("text2image").value;
    if (text.trim() === "") {
        alert("Please enter some text to convert.");
        button.disabled = false;
        button.innerHTML = "Convert to Image";
        return false;
    }
    var formData = new FormData();
    formData.append("textblk", text);

    fetch('api.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.blob())
        .then(imageBlob => {
            // Get as file
            const file = new File([imageBlob], "image.png", {
                type: 'image/png'
            });
            setFileInput(file);
            button.disabled = false;
            button.innerHTML = "Convert to Image";
        })
        .catch(error => {
            console.error("Conversion failed:", error);
        });
    return false;
}



// Generate preview image from text
function txt2imgPreview() {
    var text = document.getElementById("text2image").value.trim();
    var imgEl = document.getElementById("text2imageView");
    var txt2imgBtn = document.getElementById("text2imageBtn");
    var txt2imgLink = document.getElementById("text2imageLink");

    if (text === "") {
        imgEl.src = "";
        console.log("Empty text, no preview");
        imgEl.style.display = "none";
        return;
    }

    txt2imgBtn.disabled = true;
    txt2imgBtn.innerHTML = "Generating Preview...";

    var formData = new FormData();
    formData.append("textblk", text);
    fetch('api.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.blob())
        .then(imageBlob => {
            var imageUrl = URL.createObjectURL(imageBlob);
            imgEl.src = imageUrl;
            imgEl.style.display = "";
            txt2imgBtn.disabled = false;
            txt2imgBtn.innerHTML = "Convert Text to Image";

            // Set link href and show link
            txt2imgLink.href = imageUrl;
            txt2imgLink.style.display = "";
        })
        .catch(error => {
            console.error("Preview failed:", error);
        });
}



// Set file input and upload file
function setFileInput(file) {
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    fileInput.files = dataTransfer.files;
    uploadFile(file.name);
}



// Show/hide text to image container
function showHideContainer() {
    var container = document.getElementById("text2image-div");
    if (container.style.display === "none") {
        container.style.display = "";
        form.style.display = "none";
    } else {
        container.style.display = "none";
        form.style.display = "";
    }
    return false;
}


// Shorten filename for display
function shortenFilename(filename, maxLength = 20) {
    // Split into name and extension
    const lastDot = filename.lastIndexOf(".");
    if (lastDot === -1) return filename; // no extension case

    const name = filename.substring(0, lastDot);
    const ext = filename.substring(lastDot);

    if (name.length <= maxLength) {
        return filename; // nothing to shorten
    }

    const keep = Math.floor((maxLength - 4) / 2); // 4 chars for "...."
    const start = name.substring(0, keep);
    const end = name.substring(name.length - keep);

    return `${start}....${end}${ext}`;
}
