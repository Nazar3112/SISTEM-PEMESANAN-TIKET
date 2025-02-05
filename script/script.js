function startCountdown() {
    const countdownDate = new Date("February 08, 2025 08:00:00").getTime();

    setInterval(() => {
        const now = new Date().getTime();
        let timeLeft = countdownDate - now;

        if (timeLeft < 0) timeLeft = 0;

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        document.getElementById("days").innerText = days;
        document.getElementById("hours").innerText = hours;
        document.getElementById("minutes").innerText = minutes;
        document.getElementById("seconds").innerText = seconds;
    }, 1000);
}

function validateSubscription() {
    const email = document.getElementById("email").value;
    if (email === "" || !email.includes("@")) {
        alert("Please enter a valid email.");
        return false;
    }
    alert("Subscription successful!");
    return true;
}

document.addEventListener("DOMContentLoaded", startCountdown);
