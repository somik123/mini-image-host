// Get form and file input elements
const form = document.getElementById("upload-form");
const fileInput = document.getElementById("file");


// form click event
form.addEventListener("click", () => {
    fileInput.click();
});



// file input change event
fileInput.addEventListener("change", () => {
    // Call uploadFile function when a file is selected
    if (fileInput.files.length > 0) {
        let file = fileInput.files[0];
        uploadFile(file.name);
    }
});


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
        // Process all dropped files as long as they are images
        for (let i = 0; i < dt.files.length; i++) {
            const file = dt.files[i];
            if (file.type.startsWith('image/')) {
                setFileInput(file);
            }
        }
    }
});



// handle pasted images
document.addEventListener('paste', function (e) {
    const items = (event.clipboardData || event.originalEvent.clipboardData || window.clipboardData).items;
    for (let i = 0; i < items.length; i++) {
        if (items[i].kind === 'file' && items[i].type.startsWith('image/')) {
            console.log('Pasted image');
            console.log(items[i]);
            const file = items[i].getAsFile();
            setFileInput(file);
            e.preventDefault();
            break; // We only need the first image
        } else if (items[i].kind === 'string' && items[i].type === 'text/plain') {
            // Handle pasted text
            items[i].getAsString(function (text) {
                document.getElementById("text2image").value = text;
            });
            document.getElementById("text2image-div").style.display = "block";
            form.style.display = "none";

            // delay to allow text area to update
            setTimeout(function () {
                txt2imgPreview();
            }, 100);
            e.preventDefault();
            break; // We only need the first text
        }
    }
});





