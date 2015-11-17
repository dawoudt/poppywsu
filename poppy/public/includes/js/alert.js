// this script finds the timer id in redirect.php
// then decrements the value of timer from 5 till 0
// then redirects to home page


window.onload = function () {
      var element = document.getElementById("timer");
      var callBackFunction = function () {
        window.location.href = 'homepage.php';
      }
      countDown(element, callBackFunction);
    }



    function countDown(element, baseFunction, seconds) {
    //default values
    baseFunction = baseFunction || function () { };
    seconds = seconds || null;
    
    if (seconds === null) {
        seconds = parseInt(element.innerHTML);
        if (isNaN(seconds))
            seconds = 5;
    }
    decrementElementText(element, baseFunction, seconds + 1);
}

//Convert an element to a count down timer
//Does not do error checking to check whether element has number text, nor set default values.
function decrementElementText(element, baseFunction, seconds) {
    //Decrements an element with a number
    if (seconds === 1) {
        window.setTimeout(baseFunction, 1000);
    }
    else {
        window.setTimeout(function () {
            seconds = seconds - 1;
            decrementElementText(element, baseFunction, seconds);
        }, 1000);
    }
    element.innerHTML = seconds - 1;
}