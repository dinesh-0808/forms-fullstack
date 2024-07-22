

document.addEventListener('DOMContentLoaded', function () {
    var formContainer = document.getElementById('form-container');

    Sortable.create(formContainer, {
        handle: '.drag-box',
        animation: 150,
        filter: '.title-box, .preview-button', // Exclude elements with these classes from dragging
        onStart: function (evt) {
            if (evt.item.classList.contains('title-box') || evt.item.classList.contains('preview-button')) {
                evt.preventDefault(); // Prevent dragging these items
            }
        },
        onEnd: function (evt) {
            console.log('Item moved');
            // Additional logic after item is moved
            if (evt.item.classList.contains('title-box') || evt.item.classList.contains('preview-button')) {
                // Revert the item to its original position if it's a title-box or preview-button
                evt.from.insertBefore(evt.item, evt.from.childNodes[evt.oldIndex]);
            }
        },
        onMove: function (evt) {
            if (evt.dragged.classList.contains('title-box') || evt.dragged.classList.contains('preview-button')) {
                return false; // Disable sorting of title-box or preview-button elements
            }
        }
    });
});

document.querySelectorAll('.floating-button').forEach(box => {
    box.addEventListener('click', addQuestion);
});

var shortTextBoxCount = 0;
var longTextBoxCount = 0;
var DropDownOptionsBoxCount = 1;


function addQuestion(event){
    var questionDiv = document.createElement('div');
    questionDiv.className = "bg-white rounded shadow-sm p-4 question-box drag-box";
    var questionType = null;
    console.log(event);
    questionType = event.target.tagName === 'I' ? event.target.parentElement.value : event.target.value;
    //console.log(questionType);

    var htmlcode = "";
    switch(questionType){
        case "short-text":
            shortTextBoxCount++;
            questionDiv.id = "question-box1" + shortTextBoxCount;
            questionDiv.setAttribute('question-box',`1${shortTextBoxCount}`);
            DropDownOptionsBoxCount++;
            htmlcode = `
        <div class="shortText">
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text" selected>Short Text</option>
                    <option value="long-text">Long Text</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkboxes">Checkboxes</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="write question here" disabled=true>
            </div>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton1${shortTextBoxCount}" deleteButton="1${shortTextBoxCount}" onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="1${shortTextBoxCount}"></i>
            </button>
            <div class="toggle-container">
                        <span class="status">Required</span>
                        <label class="toggle-switch">
                            <input type="checkbox" id="toggleButton">
                            <span class="slider"></span>
                        </label>
            </div>
        </div>`;
            break;

        case "long-text":
            longTextBoxCount++;
            DropDownOptionsBoxCount++;
            // questionDiv.id = "question-box2" + longTextBoxCount;
            questionDiv.setAttribute('question-box',`2${longTextBoxCount}`);
                htmlcode = `
            <div class="longText">
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text">Short Text</option>
                    <option value="long-text" selected>Long Text</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkboxes">Checkboxes</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <textarea class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Write question here" disabled></textarea>
            </div>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="2${longTextBoxCount}" onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="2${longTextBoxCount}"></i>
            </button>
        </div>`
            break;

        case "multiple-choice":
            MultipleCoiceBoxCount++;
            DropDownOptionsBoxCount++;
            questionDiv.id = "question-box3" + MultipleCoiceBoxCount;
            questionDiv.setAttribute('question-box',`3${MultipleCoiceBoxCount}`);
            htmlcode = `
            <div class="multipleChoice">
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text">Short Text</option>
                    <option value="long-text">Long Text</option>
                    <option value="multiple-choice" selected>Multiple Choice</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkboxes">Checkboxes</option>
                </select>
            </div>
            <br>
            <div id="mcq-options${MultipleCoiceBoxCount}">
                <div class="form-check" id="MultipleChoiceBox${MultipleCoiceBoxCount}1" style="margin-bottom: 12px">
                    <input type="radio" class="form-check-input" name="mcq" id="mcqOption${MultipleCoiceBoxCount}1" value="option" disabled=true>
                    <label class="form-check-label" for="mcqOption1"><input type="text" class='form-control' value="option"></label>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2 addButton" id="mcqOptionsButton${MultipleCoiceBoxCount}" mcqOptionsButton="${MultipleCoiceBoxCount}" onclick="addMultipleChoiceOptionButton(event)">Add Option</button>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="3${MultipleCoiceBoxCount}" onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="3${MultipleCoiceBoxCount}"></i>
            </button>
            <div class="toggle-container" toggleButton="3${MultipleCoiceBoxCount}">
                        <span class="status">Required</span>
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggleButton">
                            <span class="slider"></span>
                        </label>
            </div>
        </div>`
            break;

        case "dropdown":
            dropdownBoxCount++;
            DropDownOptionsBoxCount++;
            questionDiv.id = "question-box4" + dropdownBoxCount;
            questionDiv.setAttribute('question-box',`4${dropdownBoxCount}`);
            htmlcode = `
            <div class="dropDown">
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text">Short Text</option>
                    <option value="long-text">Long Text</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="dropdown" selected>Dropdown</option>
                    <option value="checkboxes">Checkboxes</option>
                </select>
            </div>
            <br>
            <div class="form-control" id="dropdownQuestion${dropdownBoxCount}">
                <p id="dropdownBox${dropdownBoxCount}1"><input type="text" width="50" class='form-control dropdownOptions' value="option" width="10px"></p>

            </div>
            <button type="button" class="btn btn-secondary mt-2 addButton" id="dropdownOptionsButton${dropdownBoxCount}" dropdownOptionsButton="${dropdownBoxCount}" onclick="addDropdownOptionButton(event)"><i class="fa-solid fa-plus" dropdownOptionsButton="${dropdownBoxCount}"></i></button>
            <hr>
            <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="4${dropdownBoxCount}"  onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="4${dropdownBoxCount}"></i>
            </button>
        </div>`
            break;

        case "checkboxes":
            checkboxBoxCount++;
            DropDownOptionsBoxCount++;
            questionDiv.id = "question-box5" + checkboxBoxCount;
            questionDiv.setAttribute('question-box',`5${checkboxBoxCount}`);
            htmlcode = `
            <div class="CheckBox">
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text">Short Text</option>
                    <option value="long-text">Long Text</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkboxes" selected>Checkboxes</option>
                </select>
            </div>
            <br>
            <div id="checkbox-options${checkboxBoxCount}">
                <div class="form-check" id="checkboxBox${checkboxBoxCount}1">
                    <input class="form-check-input" type="checkbox" id="checkboxOption1" name="checkbox" value="option1" disabled=true>
                    <label class="form-check-label" for="checkboxOption1"><input type="text" class='form-control' value="option"></label>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2 addButton" id="checkboxOptionsButton${checkboxBoxCount}" checkboxOptionsButton="${checkboxBoxCount}" onclick="addCheckBoxOptionButton(event)"><i class="fa-solid fa-plus" checkboxOptionsButton="${checkboxBoxCount}"></i></button>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="5${checkboxBoxCount}" onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="5${checkboxBoxCount}"></i>
            </button>

        </div>`
            break;



    }


    questionDiv.innerHTML = htmlcode;
    console.log(questionDiv);
    document.querySelector("#form-container").appendChild(questionDiv);


    // adding click event listeners to all
    document.querySelectorAll('.question-box').forEach(box => {
        box.addEventListener('click', handleQuestionBoxClick);
    });
}


var MultipleChoiceOptionCount = 1;
var MultipleCoiceBoxCount = 1;
function addMultipleChoiceOptionButton(e) {
    var boxNo = e.target.getAttribute('mcqOptionsButton');
    console.log(boxNo);
    // var boxNo = string.substr(16);
    //console.log("fdgsssfgd",boxNo);

    MultipleChoiceOptionCount++;

    var newOptionDiv = document.createElement('div');
    newOptionDiv.className = 'form-check';
    newOptionDiv.setAttribute('id','MultipleChoiceBox'+MultipleCoiceBoxCount+MultipleChoiceOptionCount);

    var newRadio = document.createElement('input');
    newRadio.type = 'radio';
    newRadio.className = 'form-check-input';
    newRadio.name = 'mcq';
    newRadio.id = 'mcqOption' + boxNo + MultipleChoiceOptionCount;
    newRadio.value = 'option';
    newRadio.disabled = true;

    var newLabel = document.createElement('label');
    newLabel.className = 'form-check-label';
    newLabel.htmlFor = 'mcqOption' + MultipleChoiceOptionCount;

    var newTextInput = document.createElement('input');
    newTextInput.type = 'text';
    newTextInput.className = 'form-control';
    newTextInput.value = 'option';

    newLabel.appendChild(newTextInput);

    // creating option delete button
    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.setAttribute("id","mcqOptionDeleteButton"+MultipleCoiceBoxCount+MultipleChoiceOptionCount);
    button.classList.add('btn', 'btn-secondary', 'mt-2', 'mcqOptionDeleteButton', 'optionsDeleteButton');

    // Create the <i> element for Font Awesome icon
    var icon = document.createElement('i');
    icon.classList.add('fa-solid', 'fa-xmark');

    // Append the <i> element to the button
    button.appendChild(icon);

    newOptionDiv.appendChild(newRadio);
    newOptionDiv.appendChild(newLabel);
    newOptionDiv.appendChild(button);
    document.querySelector("#mcq-options"+boxNo).appendChild(newOptionDiv);

    document.querySelectorAll('.mcqOptionDeleteButton').forEach(box => {
        box.addEventListener('click', deleteMcqOption);
    });
}

function deleteMcqOption(e) {
    var string = e.target.tagName === 'I' ? e.target.parentElement.id : e.target.id;
    var boxNo = string.substr(21);
    console.log(e);
    var div = document.getElementById('mcqOptionDeleteButton'+boxNo);
    var parent = div.parentNode;
    div = document.getElementById('MultipleChoiceBox'+boxNo);
    parent.parentNode.removeChild(div);

}

var dropdownOptionCount = 1;
var dropdownBoxCount = 0;
function addDropdownOptionButton(e) {
    // console.log(e);
    var boxNo = e.target.getAttribute('dropdownOptionsButton');
    // var boxNo = string.substr(21);
    // console.log("fdgsssfgd",boxNo);

    dropdownOptionCount++;
    var newOptionP = document.createElement('p');
    newOptionP.setAttribute('id',"dropdownBox"+dropdownBoxCount+dropdownOptionCount);
    newOptionP.setAttribute('style',"margin-bottom: 0px;");

    var newTextInput = document.createElement('input');
    newTextInput.type = 'text';
    newTextInput.classList.add('form-control', 'dropdownOptions');
    newTextInput.value = 'option';

    // creating option delete button
    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.setAttribute("id","dropdownOptionDeleteButton"+dropdownBoxCount+dropdownOptionCount);
    button.classList.add('btn', 'btn-secondary', 'mt-2', 'dropdownOptionDeleteButton','optionsDeleteButton');

    // Create the <i> element for Font Awesome icon
    var icon = document.createElement('i');
    icon.classList.add('fa-solid', 'fa-xmark', 'fa-drop');

    // Append the <i> element to the button
    button.appendChild(icon);

    newOptionP.appendChild(newTextInput);
    newOptionP.appendChild(button);

    document.querySelector("#dropdownQuestion"+boxNo).appendChild(newOptionP);

    document.querySelectorAll('.dropdownOptionDeleteButton').forEach(box => {
        box.addEventListener('click', deleteDropdownOption);
    });

}

function deleteDropdownOption(e) {
    var string = e.target.tagName === 'I' ? e.target.parentElement.id : e.target.id;

    var boxNo = string.substr(26);
    console.log(e);
    var div = document.getElementById('dropdownOptionDeleteButton'+boxNo);
    var parent = div.parentNode;
    div = document.getElementById('dropdownBox'+boxNo);
    parent.parentNode.removeChild(div);
}


var CheckboxOptionCount = 1;
var checkboxBoxCount = 0;
function addCheckBoxOptionButton(e) {

    // console.log(e);
    var boxNo = e.target.getAttribute('checkboxOptionsButton');
    // var boxNo = string.substr(21);
    // console.log("fdgsssfgd",boxNo);

    CheckboxOptionCount++;
    var newCheckboxDiv = document.createElement('div');
    newCheckboxDiv.className = 'form-check';
    newCheckboxDiv.setAttribute('id',"checkboxBox"+checkboxBoxCount+CheckboxOptionCount);

    var newCheckbox = document.createElement('input');
    newCheckbox.type = 'checkbox';
    newCheckbox.className = 'form-check-input';
    newCheckbox.name = 'checkbox';
    newCheckbox.id = 'checkboxOption' + boxNo + CheckboxOptionCount;
    newCheckbox.value = 'option';
    newCheckbox.disabled = true;

    var newLabel = document.createElement('label');
    newLabel.className = 'form-check-label';
    newLabel.htmlFor = 'checkboxOption' + CheckboxOptionCount;

    var newTextInput = document.createElement('input');
    newTextInput.type = 'text';
    newTextInput.className = 'form-control';
    newTextInput.value = 'option';

    newLabel.appendChild(newTextInput);

    // creating option delete button
    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.setAttribute("id","checkboxOptionDeleteButton"+checkboxBoxCount+CheckboxOptionCount);
    button.classList.add('btn', 'btn-secondary', 'mt-2', 'checkboxOptionDeleteButton','optionsDeleteButton');

    // Create the <i> element for Font Awesome icon
    var icon = document.createElement('i');
    icon.classList.add('fa-solid', 'fa-xmark');

    // Append the <i> element to the button
    button.appendChild(icon);

    newCheckboxDiv.appendChild(newCheckbox);
    newCheckboxDiv.appendChild(newLabel);
    newCheckboxDiv.appendChild(button);

    document.querySelector("#checkbox-options"+boxNo).appendChild(newCheckboxDiv);

    document.querySelectorAll('.checkboxOptionDeleteButton').forEach(box => {
        box.addEventListener('click', deleteCheckboxOption);
    });

}


function deleteCheckboxOption(e) {
    var string = e.target.tagName === 'I' ? e.target.parentElement.id : e.target.id;
    var boxNo = string.substr(26);
    console.log(e);
    var div = document.getElementById('checkboxOptionDeleteButton'+boxNo);
    var parent = div.parentNode;
    div = document.getElementById('checkboxBox'+boxNo);
    parent.parentNode.removeChild(div);
}


// give css class left border blue
function handleQuestionBoxClick(event) {
    // Remove the active-border class from all .question-box elements
    document.querySelectorAll('.question-box').forEach(box => {
        box.classList.remove('active-border');
    });
    // console.log(event);
    // Add the active-border class to the clicked .question-box element
    event.currentTarget.classList.add('active-border');

    // // remove the default button
    // var child = document.getElementById('question-type');
    // var parent = document.getElementById('question-type').parentNode;
    // parent.removeChild(child);


    // // <div class="floating-bar" id="question-type">
    // //             <button value="multiple-choice" class="floating-button"><i class="fa-solid fa-plus"></i></button>
    // //         </div>
    // var div = document.createElement('div');
    // div.classList.add('floating-bar');
    // div.setAttribute('id','question-type');
    // var button = document.createElemen   t('button');
    // button.setAttribute('value','multiple-choice');
    // button.classList.add('floating-button');
    // var i = document.createElement('i');
    // i.classList.add('fa-solid','fa-plus');
    // button.appendChild(i);
    // div.appendChild(button);

    // event.currentTarget.appendChild(div);



}

// Attach the click event listener to all .question-box elements
document.querySelectorAll('.question-box').forEach(box => {
    box.addEventListener('click', handleQuestionBoxClick);
});


// delete the question box
function deleteQuestionBox(e) {
    var boxNo = e.target.getAttribute('deleteButton');
    console.log(e);
    // var boxNo = string.substr(12);
    console.log(boxNo);
    var div = document.getElementById('question-box'+boxNo);
    div.parentNode.removeChild(div);


}


// function updateAddButtonPosition() {
//     const questionsSection = document.getElementById('form-container');
//     const lastQuestion = questionsSection.lastElementChild;
//     if (lastQuestion) {
//         const selectQuestionType = lastQuestion.querySelector('.question-box');
//         const sidebar = document.getElementById('question-type');
//         const offset = selectQuestionType.offsetTop - sidebar.offsetHeight;
//         sidebar.style.transform = `translateY(${offset}px)`;
//         console.log(`Moving sidebar to: ${offset}px`);  // Debugging line
//     } else {
//         const sidebar = document.getElementById('question-type');
//         sidebar.style.transform = `translateY(0px)`;
//         console.log(`Moving sidebar to: 0px`);  // Debugging line
//     }
//   }


