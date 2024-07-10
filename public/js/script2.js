var mcqBox = 0;
function generatePreviewHTML(){

    let formContainerTitle = document.getElementById('form-container-title');


    let formContainer = document.getElementById('form-container');

    let children = formContainerTitle.children;

    let previewHTML = `
    <!DOCTYPE html>
    <html lang="en">
    <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" sizes="16x16" href="https://ssl.gstatic.com/docs/spreadsheets/forms/favicon_qp2.png">
    <title>Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/styles.css">
    <style>
        body {
            background-color: #FFE9FF;
        }

        .custom-container {
            width: 750px; /* Set width to 50% */
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .question-box {
            margin-bottom: 20px;
        }
        .title-box {
            border-top: 5px solid rgb(103, 58, 183);
        }
    </style>
    </head>
    <body>
        <div class="container mt-5 custom-container">
            <div id="form-container">`;

    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        if (child.tagName.toLowerCase() === 'div') {
            // let questionType = child.className;
            let questionHTML = '';
            if(child.querySelector('.formTitleAndDesc')){
                //title and description
                let formTitle = child.querySelector("#formTitle").value;
                let formDesc = child.querySelector("#formDesc").value;
                questionHTML = `
                <div class="bg-white rounded shadow-sm p-4 question-box title-box">
                    <div class="form-group">
                        <h2>${formTitle}</h2>
                    </div>
                    <br>
                    <div class="form-group">
                        <p>${formDesc}</p>
                    </div>
                </div>`
                //console.log(child.querySelector("#formTitle").value, "   ", child.querySelector("#formDesc").value);
            }
            previewHTML += questionHTML;
        }

    }

    children = formContainer.children;

    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        if (child.tagName.toLowerCase() === 'div') {
            // Create a new div for each question in the preview
            let questionType = child.className;
            let questionHTML = '';
            console.log("child is here: ",child);
            // Handle each question type
            let toggleButton = child.querySelector('.toggleButton');
            console.log("toggle button:",toggleButton);
            let star = "";
            if(toggleButton.checked) {
                star = `<span style="color: red;">*</span>`;
            }

            if (child.querySelector('.shortText')) {
                // Short Text Question
                let questionText = child.querySelector('.shortText .form-group input').value;
                questionHTML = `
                    <div class="bg-white rounded shadow-sm p-4 question-box">
                        <div class="form-group">
                            <h4><strong>${questionText}${star}</strong></h4>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="write question here">
                        </div>
                    </div>
                `;
            } else if (child.querySelector('.longText')) {
                // Long Text Question
                let questionText = child.querySelector('.longText .form-group input').value;
                questionHTML = `
                    <div class="bg-white rounded shadow-sm p-4 question-box">
                        <div class="form-group">
                            <h4><strong>${questionText}${star}</strong></h4>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Write question here"></textarea>
                        </div>
                    </div>
                `;
            } else if (child.querySelector('.multipleChoice')) {
                // Multiple Choice Question
                mcqBox++;
                let questionText = child.querySelector('.multipleChoice .form-group input').value;
                questionHTML = `<div class="bg-white rounded shadow-sm p-4 question-box">
                <div class="multipleChoice" >
                <div class="form-group">
                            <h4><strong>${questionText}${star}</strong></h4>
                        </div>
                        <br>
                        <div class="mcq-options" id="multipleChoice${mcqBox}>
                        `;

                //let optionsContainer = document.createElement('div');
                let options = child.querySelectorAll('.multipleChoice .form-check');
                options.forEach(option => {
                    let optionText = option.querySelector('label input').value;
                    questionHTML += `
                    <div class="form-check" id="multipleChoice${mcqBox}${i+1}">
                        <input type="radio" class="form-check-input" name="mcq${mcqBox}${i+1}" id="mcqOption${mcqBox}${i+1}" value="option${mcqBox}${i+1}">
                        <label class="form-check-label" for="mcqOption${mcqBox}${i+1}">${optionText}</label>
                    </div>

                    `;
                });
                questionHTML += `</div>
                    </div>
                    `;
            } else if (child.querySelector('.dropDown')) {
                // Dropdown Question
                let questionText = child.querySelector('.dropDown .form-group input').value;
                questionHTML = `<div class="bg-white rounded shadow-sm p-4 question-box">
                <div class="dropDown">
                <div class="form-group">
                            <h4><strong>${questionText}${star}</strong></h4>
                        </div>
                        <br>
                        <select class="form-control">
                        `;

                // let selectElement = document.createElement('select');
                // selectElement.className = 'form-control';
                let options = child.querySelectorAll('.dropDown .form-control input');
                options.forEach(option => {
                    let optionText = option.value;
                    questionHTML += `<option>${optionText}</option>`;
                });
                questionHTML += `</select></div></div>`;
            } else if (child.querySelector('.CheckBox')) {
                // Checkbox Question
                let questionText = child.querySelector('.CheckBox .form-group input').value;
                questionHTML = `<div class="bg-white rounded shadow-sm p-4 question-box">
                    <div class="CheckBox">
                    <div class="form-group">
                            <h4><strong>${questionText}${star}</strong></h4>
                    </div>
                        <br>
                        <div id="checkbox-options">
                        `;

                let optionsContainer = document.createElement('div');
                let options = child.querySelectorAll('.CheckBox .form-check');
                options.forEach(option => {
                    let optionText = option.querySelector('label input').value;
                    questionHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkboxOption${i+1}" name="checkbox" value="option${i+1}">
                            <label class="form-check-label" for="checkboxOption${i+1}">${optionText}</label>
                        </div>
                    `;
                });
                questionHTML += `</div></div></div>`;
            }

            // Append the question HTML to the preview content
            previewHTML += questionHTML;

        }

    }
    previewHTML += `
                <button type="button" class="btn btn-primary">SUBMIT</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>

    </script>
</body>
</html>
    `
    //console.log(previewHTML);
    return previewHTML;
}



function openPreview() {
    // Generate the HTML content for the preview
    let previewContent = generatePreviewHTML();
    //console.log(previewContent);
    // Open a new window with the preview content
    let previewWindow = window.open();
    previewWindow.document.open();
    previewWindow.document.write(previewContent);
    previewWindow.document.close();
}
