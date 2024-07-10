document.getElementById('form-submit').addEventListener('click',sendFormDataToLaravel)

function sendFormDataToLaravel() {
    let formData = createJsonForm();
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/forms', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData,
    }).then(response => {
        // if (response.ok) {
        //     console.log('Form data saved successfully!');
        // } else {
        //     console.error('Failed to save form data.');
        // }
        window.location.href = "http://127.0.0.1:8001/";
    }).catch(error => {
        console.error('Error:', error);
    });
}


function createJsonForm(){

    let formData = [];
    let formContainerTitle = document.getElementById('form-container-title');


    let formContainer = document.getElementById('form-container');

    let children = formContainerTitle.children;


    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        if (child.tagName.toLowerCase() === 'div') {
            if(child.querySelector('.formTitleAndDesc')){
                //title and description
                let formTitle = child.querySelector("#formTitle").value;
                let formDesc = child.querySelector("#formDesc").value;
                formData.push({
                    title: formTitle,
                    description: formDesc
                })
            }

        }

    }

    children = formContainer.children;

    for (let i = 0; i < children.length; i++) {
        let child = children[i];
        if (child.tagName.toLowerCase() === 'div') {
            // Create a new div for each question in the preview
            let questionType = child.className;
            // console.log("child is here: ",child);
            // Handle each question type
            let toggleButton = child.querySelector('.toggleButton');
            let require = false;

            if(toggleButton.checked) {
                require = true;
            }

            if (child.querySelector('.shortText')) {
                // Short Text Question
                let questionText = child.querySelector('.shortText .form-group input').value;
                formData.push({
                    question_id: i+1,
                    question_type: "short_text",
                    question_text: questionText,
                    required: require
                })
            } else if (child.querySelector('.longText')) {
                // Long Text Question
                let questionText = child.querySelector('.longText .form-group input').value;
                formData.push({
                    question_id: i+1,
                    question_type: "long_text",
                    question_text: questionText,
                    required: require
                })

            } else if (child.querySelector('.multipleChoice')) {
                // Multiple Choice Question
                let questionText = child.querySelector('.multipleChoice .form-group input').value;


                //let optionsContainer = document.createElement('div');
                let options = child.querySelectorAll('.multipleChoice .form-check');
                let option_labels = [];
                options.forEach(option => {
                    let optionText = option.querySelector('label input').value;
                    option_labels.push(optionText);
                });
                formData.push({
                    question_id: i+1,
                    question_type: "multiple-choice",
                    question_text: questionText,
                    options: option_labels,
                    required: require
                })

            } else if (child.querySelector('.dropDown')) {
                // Dropdown Question
                let questionText = child.querySelector('.dropDown .form-group input').value;

                let options = child.querySelectorAll('.dropDown .form-control input');
                let option_labels = [];
                options.forEach(option => {
                    let optionText = option.value;
                    option_labels.push(optionText);
                });
                formData.push({
                    question_id: i+1,
                    question_type: "drop-down",
                    question_text: questionText,
                    options: option_labels,
                    required: require
                })
            } else if (child.querySelector('.CheckBox')) {
                // Checkbox Question
                let questionText = child.querySelector('.CheckBox .form-group input').value;


                let options = child.querySelectorAll('.CheckBox .form-check');
                let option_labels = [];
                options.forEach(option => {
                    let optionText = option.querySelector('label input').value;
                    option_labels.push(optionText);
                });
                formData.push({
                    question_id: i+1,
                    question_type: "checkbox",
                    question_text: questionText,
                    options: option_labels,
                    required: require
                })
            }



        }

    }
    // console.log(formData);
    return JSON.stringify(formData);

}
