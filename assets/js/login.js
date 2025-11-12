document.addEventListener("DOMContentLoaded", () => {
    const inputPassword = document.getElementById("password");
    const checkPassword = document.getElementById("customCheckbox1");


    checkPassword.addEventListener("change", () => {
        if (checkPassword.checked) {
            inputPassword.type = "text";
        } else {
            inputPassword.type = "password";
        }
    });
});