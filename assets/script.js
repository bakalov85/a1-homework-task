"use strict";

window.onload = function() {
    const defaultMessage = 'Please select range, number and click "Check number color."';
    statusMessage(defaultMessage);

    let checkButton = document.getElementById("check-number");
    checkButton.addEventListener("click", checkNumberColor);

    function checkNumberColor()
    {
        let selectedRange = document.getElementById("ranges").value;
        let number = document.getElementById("number").value;

        if(!number) {
            statusMessage(defaultMessage);
            return;
        }

        let colorsAndNumbers = selectedRange.split(",");

        // each range starts with a color and ends with a color. Example "green,-12,blue,-3,yellow,5,red"
        // set initially to the last color
        let numberColor = colorsAndNumbers[colorsAndNumbers.length - 1];

        // check only the numbers, not the colors
        for(let i = 1; i < colorsAndNumbers.length; i+=2) {
            let item = parseInt(colorsAndNumbers[i]);

            if(number < item) {
                numberColor = colorsAndNumbers[i - 1];
                break;
            }
        }

        statusMessage("The number's color is: " + numberColor);
    }

    function statusMessage(message)
    {
        let statusElement = document.getElementById("result");
        statusElement.innerText = message;
    }
}