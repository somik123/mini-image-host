const form = document.querySelector("form");
const fileInput = document.querySelector(".file-input");
const progressArea = document.querySelector(".progress-area");
const uploadedArea = document.querySelector(".uploaded-area");

// form click event
form.addEventListener("click", () => {
    fileInput.click();
});

fileInput.onchange = ({
    target
}) => {
    let file = target.files[0];
    if (file) {
        let fileName = file.name;
        if (fileName.length >= 12) {
            let splitName = fileName.split('.');
            fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
        }
        uploadFile(fileName);
    }
}

// file upload function
function uploadFile(name) {
    let fileSize;

    let xhr = new XMLHttpRequest(); 
    xhr.open("POST", "index.php"); 

    xhr.upload.addEventListener("progress", ({
        loaded,
        total
    }) => { 
        let fileLoaded = Math.floor((loaded / total) * 100); 
        let fileTotal = Math.floor(total / 1000); 

        (fileTotal < 1024) ? fileSize = fileTotal + " KB": fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB";
        let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Uploading</span>
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


    xhr.onload = function() {
            
        var api_reply = JSON.parse(xhr.responseText);
        if (api_reply['status'] == "OK") {

            let url = window.location.href + api_reply['path'];

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
function copyTextToClipboard(text,el) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
    }
    else{
        navigator.clipboard.writeText(text).then(
            function() {
                console.log('Async: Copying to clipboard was successful!');
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            }
        );
    }
    el.className = "fas fa-check";
    setTimeout(()=> {
        el.className = "fas fa-clipboard";
    },3000);
}