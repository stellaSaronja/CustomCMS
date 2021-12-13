const nav__ul = document.querySelector(".nav__ul");
const nav__item = document.querySelectorAll(".nav__item");
const nav__link = document.querySelectorAll(".nav__link");
const nav__menu = document.querySelector(".nav__menu");

function toggleMenu() {
    if (nav__ul.classList.contains("showMenu")) {
        nav__ul.classList.remove("showMenu");
        nav__menu.style.display = "block";
    } else {
        nav__ul.classList.add("showMenu");
        nav__menu.style.display = "none";
    }
}
  
nav__ul.addEventListener("click", toggleMenu);

nav__item.forEach( 
    function(nav__item) { 
        nav__item.addEventListener("click", toggleMenu);
    }
)