document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let message = document.getElementById("message").value.trim();

    // Kliensoldali ellenőrzés
    if (name.length < 3 || message.length < 5 || !email.includes("@")) {
        document.getElementById("contactMessage").innerText = "Hibás adatok!";
        return;
    }

    let formData = new FormData();
    formData.append("action", "contact_send");   // <-- EZ A LÉNYEG!!!
    formData.append("name", name);
    formData.append("email", email);
    formData.append("message", message);

    fetch("api.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            document.getElementById("contactMessage").innerText = data.status;
        }
    });
});
