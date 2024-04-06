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
function playAudio() {
    const audio = document.getElementById("audio-player");
    window.onload = function () {
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    };
}
$(document).ready(function () {
    $("#newsTicker2").breakingNews({
        direction: "rtl",
    });
});
