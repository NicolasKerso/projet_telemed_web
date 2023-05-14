document.addEventListener("DOMContentLoaded", function() {
    var hamburger = document.querySelector(".hamburger");
    var menu = document.querySelector(".menu");
    
    hamburger.addEventListener("click", function() {
        this.classList.toggle("active");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    });
    });