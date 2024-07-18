document.addEventListener('DOMContentLoaded',function(){
    const deleteButtons = document.querySelectorAll('button[deleteButton]');

        // Attach event listeners to each button
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                deleteQuestionBoxEdit(event);
            });
        });

    const mcqOptDelButtons = document.querySelectorAll('div[MultipleChoiceBox]');

    mcqOptDelButtons.forEach(div => {
        div.addEventListener('click',function(event){
            deleteMcqOption(event);
        })
    })

    const dropdownOptDelButtons = document.querySelectorAll('p[dropdownBox]');

    dropdownOptDelButtons.forEach(p => {
        p.addEventListener('click',function(event){
            deleteDropdownOption(event);
        })

    })

    const checkboxOptDelButtons = document.querySelectorAll('div[checkboxBox]');

    checkboxOptDelButtons.forEach(div => {
        div.addEventListener('click',function(event){
            deleteCheckboxOption(event);
        })
    })

})


function deleteQuestionBoxEdit(e){
    var boxNo = e.target.getAttribute('deleteButton');
    console.log(e.target);
    console.log(boxNo);
    var div = document.getElementById('question-box'+boxNo);
    console.log(div.parentNode);
    div.remove();
}

// function mcqOptDeleteButton(e){
//     var string = e.target.tagName === 'I' ? e.target.parentElement.id : e.target.id;
//     var boxNo = e.target.getAttribute('mcqOptionDeleteButton');

// }
