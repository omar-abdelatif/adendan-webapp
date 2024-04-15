//! Current Year
const currentYear = new Date().getFullYear();
document.getElementById("year").innerHTML = currentYear;
//! Fixed Navbar
window.addEventListener("scroll", () => {
    if (window.scrollY > 150) {
        document.querySelector(".navbar").classList.add("fixed");
    } else {
        document.querySelector(".navbar").classList.remove("fixed");
    }
});
window.onload = function (event) {
    event.preventDefault;
    document.getElementById("audio-player").play();
};
$(document).ready(function () {
    $("#newsTicker2").breakingNews({
        direction: "rtl",
    });
});
