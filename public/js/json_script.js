

if(document.getElementById("form-submit")){

        document
            .getElementById("form-submit")
            .addEventListener("click", sendFormDataToLaravel);
    }

    if(document.getElementById("form-edit")){

        document
        .getElementById("form-edit")
        .addEventListener("click", editFormDataToLaravel);
    }


function sendFormDataToLaravel() {

    let formData = createJsonForm();
    let csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/create-form", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify(formData),
    })
    .then((response) => {
        // Check if the response status is not ok
        console.log(response);
        if (!response.ok) {
            // Return the response as JSON, so it can be processed in the next `then`
            return response.json().then((errorData) => {
                // Throw an error with the message from the response
                var err = "";
                for (const key in errorData.errors) {
                    if (errorData.errors.hasOwnProperty(key)) {
                        const messages = errorData.errors[key];
                        messages.forEach(message => {
                            err += message;
                            err += '\n';
                        });
                    }
                }
                throw new Error(
                    err
                );
            });
        }
        return response.json(); // Process the response data
    })
    .then((data) => {
        // If the request was successful, show a success alert
        Swal.fire({
            title: 'Success!',
            text: 'Form saved successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/home";
            }
        });
    })
    .catch((error) => {
        // Handle errors including validation errors
        Swal.fire({
            title: 'Error!',
            text: error.message, // Display error message
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error("Error:", error);
    });
}
function editFormDataToLaravel() {
    let formData = editJsonForm();
    // let data = formData.json;
    // let idObject = formData.find(item => item.hasOwnProperty('id'));
    let id = formData[0].id;
    // console.log("fdsfdgsfgfsd",formData[0].id);
    delete formData[0];
    let csrf = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/form/${id}/update`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify(formData),
    })
    .then((response) => {
        // Check if the response status is not ok
        console.log(response);
        if (!response.ok) {
            // Return the response as JSON, so it can be processed in the next `then`
            return response.json().then((errorData) => {
                // Throw an error with the message from the response
                var err = "";
                for (const key in errorData.errors) {
                    if (errorData.errors.hasOwnProperty(key)) {
                        const messages = errorData.errors[key];
                        messages.forEach(message => {
                            err += message;
                            err += '\n';
                        });
                    }
                }
                throw new Error(
                    err
                );
            });
        }
        return response.json(); // Process the response data
    })
    .then((data) => {
        // If the request was successful, show a success alert
        Swal.fire({
            title: 'Success!',
            text: 'Form saved successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/home";
            }
        });
    })
    .catch((error) => {
        // Handle errors including validation errors
        Swal.fire({
            title: 'Error!',
            text: error.message, // Display error message
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error("Error:", error);
    });
}


function createJsonForm() {
    let formData = [];
    let formContainerTitle = document.getElementById("form-container-title");
    let formContainer = document.getElementById("form-container");


    let children = formContainerTitle.children;

    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        if (child.tagName.toLowerCase() === "div") {
            if (child.querySelector(".formTitleAndDesc")) {
                //title and description
                let formTitle = child.querySelector("#formTitle").value;
                let formDesc = child.querySelector("#formDesc").value;
                formData.push({
                    title: formTitle,
                    description: formDesc,
                });
            }
        }
    }

    children = formContainer.children;
    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        console.log(child);
        if (child.tagName.toLowerCase() === "div") {
            // Create a new div for each question in the preview
            let questionType = child.className;
            // console.log("child is here: ",child);
            // Handle each question type
            let toggleButton = child.querySelector(".toggleButton");
            let require = false;

            if (toggleButton.checked) {
                require = true;
            }

            if (child.querySelector(".shortText")) {
                // Short Text Question
                let questionText = child.querySelector(
                    ".shortText .form-group input"
                ).value;
                formData.push({
                    type: 1,
                    name: questionText,
                    options: [],
                    required: require,
                });
            } else if (child.querySelector(".longText")) {
                // Long Text Question
                let questionText = child.querySelector(
                    ".longText .form-group input"
                ).value;
                formData.push({
                    type: 2,
                    name: questionText,
                    options: [],
                    required: require,
                });
            } else if (child.querySelector(".multipleChoice")) {
                // Multiple Choice Question
                let questionText = child.querySelector(
                    ".multipleChoice .form-group input"
                ).value;

                //let optionsContainer = document.createElement('div');
                let options = child.querySelectorAll(
                    ".multipleChoice .form-check"
                );
                let option_labels = [];
                options.forEach((option) => {
                    let optionText = option.querySelector("label input").value;
                    option_labels.push(optionText);
                });
                formData.push({
                    type: 3,
                    name: questionText,
                    options: option_labels,
                    required: require,
                });
            } else if (child.querySelector(".dropDown")) {
                // Dropdown Question
                let questionText = child.querySelector(
                    ".dropDown .form-group input"
                ).value;

                let options = child.querySelectorAll(
                    ".dropdownOptions"
                );
                let option_labels = [];
                options.forEach((option) => {
                    let optionText = option.value;
                    option_labels.push(optionText);
                });
                formData.push({
                    type: 4,
                    name: questionText,
                    options: option_labels,
                    required: require,
                });
            } else if (child.querySelector(".CheckBox")) {
                // Checkbox Question
                let questionText = child.querySelector(
                    ".CheckBox .form-group input"
                ).value;

                let options = child.querySelectorAll(".CheckBox .form-check");
                let option_labels = [];
                options.forEach((option) => {
                    let optionText = option.querySelector("label input").value;
                    option_labels.push(optionText);
                });
                formData.push({
                    type: 5,
                    name: questionText,
                    options: option_labels,
                    required: require,
                });
            }
        }
    }
    // console.log(formData);
    return formData;
}

function editJsonForm() {
    let formData = [];
    let formContainerTitle = document.getElementById("form-container-title");
    let formContainer = document.getElementById("form-container");
    if(document.getElementById('form-edit')){
        let form_id = document.getElementById('form-edit').getAttribute('form');
    formData.push(
        {
            id: form_id,
        }
    )
    }

    let children = formContainerTitle.children;

    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        if (child.tagName.toLowerCase() === "div") {
            if (child.querySelector(".formTitleAndDesc")) {
                //title and description
                let formTitle = child.querySelector("#formTitle").value;
                let formDesc = child.querySelector("#formDesc").value;
                formData.push({
                    title: formTitle,
                    description: formDesc,
                });
            }
        }
    }

    children = formContainer.children;
    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        console.log(child);
        if (child.tagName.toLowerCase() === "div") {
            // Create a new div for each question in the preview
            let questionType = child.className;
            // console.log("child is here: ",child);
            // Handle each question type
            let toggleButton = child.querySelector(".toggleButton");
            let require = false;

            if (toggleButton.checked) {
                require = true;
            }

            let question_id = child.querySelector("input[type='hidden']")?.value;
                if(!question_id){
                    question_id=0;
                }

            if (child.querySelector(".shortText")) {
                // Short Text Question
                let questionText = child.querySelector(
                    ".shortText .form-group input"
                ).value;
                formData.push({
                    id: question_id,
                    type: 1,
                    name: questionText,
                    options: [],
                    required: require,
                });
            } else if (child.querySelector(".longText")) {
                // Long Text Question
                let questionText = child.querySelector(
                    ".longText .form-group input"
                ).value;
                formData.push({
                    id: question_id,
                    type: 2,
                    name: questionText,
                    options: [],
                    required: require,
                });
            } else if (child.querySelector(".multipleChoice")) {
                // Multiple Choice Question
                let questionText = child.querySelector(
                    ".multipleChoice .form-group input"
                ).value;

                //let optionsContainer = document.createElement('div');
                let options = child.querySelectorAll(
                    ".multipleChoice .form-check"
                );
                let option_labels = [];
                options.forEach((option) => {
                    let optionText = option.querySelector("label input").value;
                    option_labels.push(optionText);
                });
                formData.push({
                    id: question_id,
                    type: 3,
                    name: questionText,
                    options: option_labels,
                    required: require,
                });
            } else if (child.querySelector(".dropDown")) {
                // Dropdown Question
                let questionText = child.querySelector(
                    ".dropDown .form-group input"
                ).value;

                let options = child.querySelectorAll(
                    ".dropdownOptions"
                );
                let option_labels = [];
                options.forEach((option) => {
                    let optionText = option.value;
                    option_labels.push(optionText);
                });
                formData.push({
                    id: question_id,
                    type: 4,
                    name: questionText,
                    options: option_labels,
                    required: require,
                });
            } else if (child.querySelector(".CheckBox")) {
                // Checkbox Question
                let questionText = child.querySelector(
                    ".CheckBox .form-group input"
                ).value;

                let options = child.querySelectorAll(".CheckBox .form-check");
                let option_labels = [];
                options.forEach((option) => {
                    let optionText = option.querySelector("label input").value;
                    option_labels.push(optionText);
                });
                formData.push({
                    id: question_id,
                    type: 5,
                    name: questionText,
                    options: option_labels,
                    required: require,
                });
            }
        }
    }
    // console.log(formData);
    return formData;
}
