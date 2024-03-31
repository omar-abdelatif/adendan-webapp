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
//! Audio Play
$(document).ready(function () {
    var audio = document.getElementById("audio-player");
    console.log(audio)
    var hasAudioPlayed = sessionStorage.getItem("audioPlayed");

    if (!hasAudioPlayed) {
        audio.play();
        sessionStorage.setItem("audioPlayed", true);
    }
});
