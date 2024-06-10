const subtitle = document.getElementById("subtitle");
const one = document.getElementById("imgOne");



function getRandomInt(subtitleWordLength) {
    return Math.floor(Math.random() * subtitleWordLength);
}
let subtitleWord = ["'The quick brown bread jumps the sale hurdles'", "'isn't this just yummy'", "'Who here likes bread'", "'Chat is this real?'", "'FEE FI FO FUM, I LOVE BREAD'", "**Eating Noises**"];
let subtitleWordLength = subtitleWord.length;
console.log(getRandomInt());

subtitle.innerHTML = subtitleWord[getRandomInt(subtitleWordLength)];


