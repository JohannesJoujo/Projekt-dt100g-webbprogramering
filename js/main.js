//Här genereras båda talen som ska multipliceras med varandra
const num1 = Math.ceil(Math.random() * 10);
const num2 = Math.ceil(Math.random() * 10);

const questionEl = document.getElementById("question");

const inputEl = document.getElementById("input");

const formEl = document.getElementById("form");

const scoreEl = document.getElementById("score");

const scorebtn = document.querySelector(".scorebtn");

questionEl.innerText = `What is ${num1} multiply by ${num2}?`;

const correctAns = num1 * num2;

formEl.addEventListener("submit", (event) => {
    event.preventDefault(); // prevent the form from submitting
    const userAns = +inputEl.value;
    if (userAns === correctAns) {
        scoreEl.innerText = `The answer was Correct 🎉!`;
        setTimeout(() => {
            window.location.href = 'addpoint.php';
        }, 1000); // delay the redirection by 1 second
    } else {
        scoreEl.innerText = `The answer was Wrong 😕!!`;
        setTimeout(() => {
            window.location.href = 'takepoint.php';
        }, 1000); // delay the redirection by 1 second
    }
});


scorebtn.addEventListener("click", () => {
    window.location.href = 'showscore.php';
});