// Get form and file input elements
const form = document.getElementById("upload-form");
const fileInput = document.getElementById("file");


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
document.addEventListener('paste', function (e) {
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





