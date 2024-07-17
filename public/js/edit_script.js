document.addEventListener('DOMContentLoaded',function(){
    const deleteButtons = document.querySelectorAll('button[deleteButton]');

        // Attach event listeners to each button
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                deleteQuestionBoxEdit(event);
            });
        });
})


function deleteQuestionBoxEdit(e){
    var boxNo = e.target.getAttribute('deleteButton');
    console.log(e.target);
    console.log(boxNo);
    var div = document.getElementById('question-box'+boxNo);
    console.log(div.parentNode);
    div.remove();
}
