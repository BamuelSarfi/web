const glow = document.getElementById('glow');
const colours = ["white", "green", "purple"];
max = colours.length;
let click = 0;

function getRandomInt(max) {
    return Math.floor(Math.random() * (max));
}

console.log(getRandomInt(max))





window.addEventListener("mousedown", function() {
    glow.style.color = colours[getRandomInt(max)]
    click++;
    
    if(click >= 10){
    console.log("You've clicked ", click, " times.")

    if(click >= 30){
        this.window.open("test.html");
        click = 0;
    }
}
})

window.addEventListener('mousemove', (e) => {
    const mouseX = e.clientX;
    const mouseY = e.clientY;

    glow.style.left = `${mouseX}px`;
    glow.style.top = `${mouseY}px`;

    document.body.appendChild(glow);
})

