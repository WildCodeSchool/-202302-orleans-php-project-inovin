let time = 10;
let counter;

function countDownTimer() {
    let display = document.getElementById("timer");
    display.innerHTML = time;

    time--;

    if (time < 0) {
        clearInterval(counter);
        window.location.href = window.redirectUrl;
    }
}

document.getElementById("btn-timer").addEventListener("click", function () {
    startTimer();
});

function startTimer() {
    counter = setInterval(countDownTimer, 1000);
}
