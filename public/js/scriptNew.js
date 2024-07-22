function dropdownChangeButton(event) {
    //console.log("dropdown: ",event.currentTarget.value);
    var questionType = event.currentTarget.value;
    var div = event.currentTarget.parentNode.parentNode;
    console.log("divvvv:  ", div.parentNode.getAttribute('question-box'));
    var questionDiv = div.parentNode;
    //console.log(div);
    switch(questionType) {
        case "short-text":
            shortTextBoxCount++;
            questionDiv.id = "question-box1" + shortTextBoxCount;
            questionDiv.setAttribute('question-box',`1${shortTextBoxCount}`);
            div.setAttribute('class','shortText');
            console.log(div);
            div.innerHTML = `
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text" selected>Short Text</option>
                    <option value="long-text">Long Text</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkboxes">Checkboxes</option>
                </select>
            </div>
            <br>
            <div class="form-group" style="margin-left: 20px">
                <input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="write question here" disabled=true>
            </div>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton1${shortTextBoxCount}" deleteButton="1${shortTextBoxCount}" onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="1${shortTextBoxCount}"></i>
            </button>
            <div class="toggle-container" toggleButton="1${shortTextBoxCount}">
                        <span class="status">Required</span>
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggleButton">
                            <span class="slider"></span>
                        </label>
            </div>
            `;
            break;

        case "long-text":
            longTextBoxCount++;
            questionDiv.id = "question-box2" + longTextBoxCount;
            questionDiv.setAttribute('question-box',`2${longTextBoxCount}`);
            div.setAttribute('class','longText');
            div.innerHTML = `
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text">Short Text</option>
                    <option value="long-text" selected>Long Text</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkboxes">Checkboxes</option>
                </select>
            </div>
            <br>
            <div class="form-group" style="margin-left: 20px">
                <textarea class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Write question here" disabled></textarea>
            </div>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="2${longTextBoxCount}" onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="2${longTextBoxCount}"></i>
            </button>
            <div class="toggle-container" toggleButton="2${longTextBoxCount}">
                        <span class="status">Required</span>
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggleButton">
                            <span class="slider"></span>
                        </label>
            </div>
            `;
            break;

        case "multiple-choice":
            MultipleCoiceBoxCount++;
            questionDiv.id = "question-box3" + MultipleCoiceBoxCount;
            questionDiv.setAttribute('question-box',`3${MultipleCoiceBoxCount}`);
            div.setAttribute('class','multipleChoice');
            div.innerHTML = `
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
                    <label class="form-check-label" for="mcqOption1"><input type="text" class='form-control' value="option" ></label>
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
            `;
            break;

        case "dropdown":
            dropdownBoxCount++;
            questionDiv.id = "question-box4" + dropdownBoxCount;
            questionDiv.setAttribute('question-box',`4${dropdownBoxCount}`);
            div.setAttribute('class','dropDown');
            div.innerHTML = `
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                <select class="dropdown" dropdown="${DropDownOptionsBoxCount}" onchange="dropdownChangeButton(event)">
                    <option value="short-text">Short Text</option>
                    <option value="long-text">Long Text</option>
                    <option value="multiple-choice">Multiple Choice</option>
                    <option value="dropdown" selected>Dropdown</option>
                    <option value="checkboxes">Checkboxes</option>
                </select>
            </div>
            <br>
            <div class="form-check" id="dropdownQuestion${dropdownBoxCount}" >
                <p id="dropdownBox${dropdownBoxCount}1"><input type="text" width="50" class='form-control dropdownOptions' value="option" width="10px"></p>

            </div>
            <button type="button" class="btn btn-secondary mt-2 addButton" id="dropdownOptionsButton${dropdownBoxCount}" dropdownOptionsButton="${dropdownBoxCount}" onclick="addDropdownOptionButton(event)">Add Option</button>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="4${dropdownBoxCount}"  onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="4${dropdownBoxCount}"></i>
            </button>
            <div class="toggle-container" toggleButton="4${dropdownBoxCount}">
                        <span class="status">Required</span>
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggleButton">
                            <span class="slider"></span>
                        </label>
            </div>
            `;
            break;

        case "checkboxes":
            checkboxBoxCount++;
            questionDiv.id = "question-box5" + checkboxBoxCount;
            questionDiv.setAttribute('question-box',`5${checkboxBoxCount}`);
            div.setAttribute('class','CheckBox');
            div.innerHTML = `
            <div class="form-group header">
                <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
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
                <div class="form-check" id="checkboxBox${checkboxBoxCount}1" style="margin-bottom: 12px;">
                    <input class="form-check-input" type="checkbox" id="checkboxOption1" name="checkbox" value="option1" disabled=true>
                    <label class="form-check-label" for="checkboxOption1"><input type="text" class='form-control' value="option"></label>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mt-2 addButton" id="checkboxOptionsButton${checkboxBoxCount}" checkboxOptionsButton="${checkboxBoxCount}" onclick="addCheckBoxOptionButton(event)">Add Option</button>
            <hr>

            <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="5${checkboxBoxCount}" onclick="deleteQuestionBox(event)">
                <i class="fa-solid fa-trash" deleteButton="5${checkboxBoxCount}"></i>
            </button>
            <div class="toggle-container" toggleButton="5${checkboxBoxCount}">
                        <span class="status">Required</span>
                        <label class="toggle-switch">
                            <input type="checkbox" class="toggleButton">
                            <span class="slider"></span>
                        </label>
            </div>
            `;
            break;
    }

    document.querySelectorAll('.question-box').forEach(box => {
        box.addEventListener('click', handleQuestionBoxClick);
    });



}



