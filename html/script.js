
// file upload function
function uploadFile(name, mirror) {
    let fileSize;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", mirror + "index.php");

    xhr.upload.addEventListener("progress", ({
        loaded,
        total
    }) => {
        let fileLoaded = Math.floor((loaded / total) * 100);
        let fileTotal = Math.floor(total / 1000);

        (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB";
        let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} <i class="fa fa-upload" aria-hidden="true"></i></span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
        // uploadedArea.innerHTML = ""; //uncomment this line if you don't want to show upload history
        uploadedArea.classList.add("onprogress");
        progressArea.innerHTML = progressHTML;
    });
    let data = new FormData(form);
    xhr.send(data);


    xhr.onload = function () {

        var api_reply = JSON.parse(xhr.responseText);
        if (api_reply['status'] == "OK") {

            let url = api_reply['url'];
            //name = url.substring(url.lastIndexOf('/')+1);

            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row">
                            <div class="content upload">
                            <i class="fas fa-file-alt"></i>
                            <div class="details">
                                <span class="name">${name} [${fileSize}] <i class="fas fa-check"></i></span>
                                <span class="small"><a href="${url}">${url}</a></span>
                            </div>
                            </div>
                            <i onclick="copyTextToClipboard('${url}',this)" class="fas fa-clipboard"></i>
                        </li>`;
            uploadedArea.classList.remove("onprogress");
            // uploadedArea.innerHTML = uploadedHTML; //uncomment this line if you don't want to show upload history
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML); //remove this line if you don't want to show upload history

        } else if (api_reply['status'] == "FAIL") {

            let error = api_reply['msg'];

            progressArea.innerHTML = "";
            let uploadedHTML = `<li class="row">
                            <div class="content upload">
                            <i class="fas fa-file-alt"></i>
                            <div class="details">
                                <span class="name">${name} [${fileSize}]</span>
                                <span class="small">${error}</a></span>
                            </div>
                            </div>
                            <i class="fas fa-exclamation-triangle"></i>
                        </li>`;
            uploadedArea.classList.remove("onprogress");
            // uploadedArea.innerHTML = uploadedHTML; //uncomment this line if you don't want to show upload history
            uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML); //remove this line if you don't want to show upload history

        }
    }
}





// Fallback function to copy text to clipboard
function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Fallback: Copying text command was ' + msg);
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}



// Main function to copy text to clipboard
function copyTextToClipboard(text, el) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
    }
    else {
        navigator.clipboard.writeText(text).then(
            function () {
                console.log('Async: Copying to clipboard was successful!');
            }, function (err) {
                console.error('Async: Could not copy text: ', err);
            }
        );
    }
    el.className = "fas fa-check";
    setTimeout(() => {
        el.className = "fas fa-clipboard";
    }, 3000);
}

// Main function to copy text to clipboard
function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
    }
    else {
        navigator.clipboard.writeText(text).then(
            function () {
                console.log('Async: Copying to clipboard was successful!');
            }, function (err) {
                console.error('Async: Could not copy text: ', err);
            }
        );
    }
}


// When the user clicks on <div>, open the popup
function showPopup(popupId, text) {
    var popup = document.getElementById(popupId);
    copyTextToClipboard(text)
    popup.classList.toggle("show");
    setTimeout(() => {
        popup.classList.toggle("show");
    }, 3000);
}


// Show delete confirmation prompt
function showDeleteConfirm(file) {
    var ret = prompt("Provide ADMIN_KEY to delete this image (case-sensitive):", "");
    if (ret != null) {
        var url = "index.php?delete=" + file + "&key=" + ret;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onload = function () {
            alert(xhr.responseText);
            location.reload();
        }
        xhr.send();
    }
    return false;
}


