document.getElementById("wordle-form").addEventListener("submit", function(e) {
    e.preventDefault();  // Prevent form submission

    const inputs = document.querySelectorAll('.wordle-input');
    const guess = Array.from(inputs).map(input => input.value.toLowerCase()).join('');
    console.log(guess.length);
    console.log(championNameLength);
    // Check if the guess is valid (all inputs are filled)
    if (guess.length === championNameLength) {
        let resultMessage = 'Incorrect guess!';
        let resultColors = [];

        for (let i = 0; i < championNameLength; i++) {
            if (guess[i] === correctWord[i]) {
                resultColors.push('green');
                inputs[i].style.backgroundColor = 'green'; // Correct letter
            } else if (correctWord.includes(guess[i])) {
                resultColors.push('yellow');
                inputs[i].style.backgroundColor = 'yellow'; // Letter is in the word, but wrong position
            } else {
                resultColors.push('gray');
                inputs[i].style.backgroundColor = 'gray'; // Incorrect letter
            }
        }

        resultMessage = 'Guess Result: ' + resultColors.join(' ');
        document.getElementById('response').innerText = resultMessage;

        // Check if the guess is correct
        if (guess === correctWord) {
            document.getElementById('response').innerText = 'Correct! Well done!';
            setTimeout(() => {
                window.location.href = window.location.pathname + '?reset=1';
            }, 1000);
        }
    } else {
        document.getElementById('response').innerText = 'Please enter a ' + championNameLength + '-letter word.';
    }
});
