function greetUser(){
    alert("Welcome to FCB Staff Portal");
}

window.onload = greetUser; // EVENT

// SIMPLE SLIDER
let index = 0;

function changeBackground(){
    const colors = ["#a50044","#004d98","#111"];
    document.body.style.background = colors[index];
    index = (index + 1) % colors.length;
}

setInterval(changeBackground,3000); // EVENT