document.addEventListener("DOMContentLoaded", () => {
    let choiceCount = document.querySelector("#choiceCount");
    let choicesContainer = document.querySelector("#choicesContainer");
    let form = document.querySelector("#quizForm");

    let alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");

    function updateChoices() {
        let choicesHTML = "";
        let numChoices = choiceCount.value;

        // Loop to generate choice fields with alphabet labels
        for (let i = 0; i < numChoices; i++) {
            let letter = alphabet[i];
            choicesHTML += "<label>Choice " + letter + ": <input type='text' class='choice' name='choice" + letter + "' required></label><br>";
        }
        choicesContainer.innerHTML = choicesHTML;
    }

    choiceCount.addEventListener("change", updateChoices);
    updateChoices();

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // Clear previous error message if any
        let errorMessages = document.querySelectorAll(".error-message");
        for (let i = 0; i < errorMessages.length; i++) {
            errorMessages[i].remove();
        }

        let answer = document.querySelector("#answer").value;
        let choiceInputs = choicesContainer.querySelectorAll("input[type='text']");
        let choices = Array.from(choiceInputs).map(input => input.value);

        if (!choices.includes(answer)) {
            let errorMessage = "<span id='answerError' class='error-message'>Answer must match one of the choices.</span>";
            document.querySelector("#answer").insertAdjacentHTML('afterend', errorMessage);
            return;
        }
        let points = document.querySelector("#points").value;
        if (!/^[1-9]\d*$/.test(points)) {
            let errorMessage = "<span id='pointsError' class='error-message'>Points must be a positive integer.</span>";
            document.querySelector("#points").insertAdjacentHTML('afterend', errorMessage);
            return;
        }
        form.submit();
    });
});
