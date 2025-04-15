document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("textForm");
    const input = document.getElementById("tekstInput");
    const responseDiv = document.getElementById("response");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const xhr = new XMLHttpRequest();
        const formData = new FormData();
        formData.append("tekstInput", input.value);

        xhr.open("POST", "", true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const responseText = xhr.responseText.trim();
                responseDiv.innerHTML = "Ingevoerde tekst: " + responseText;
                input.value = "";

                if (responseText === "correct") {
                    window.location.reload();
                } else {
                    console.log("Incorrect answer");
                }
            }
        };

        xhr.send(formData);
    });
});
