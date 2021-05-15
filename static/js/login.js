function valid_to_send() {
    var username = document.getElementById("username").value.trim().length != 0;
    var password = document.getElementById("password").value.trim().length != 0;

    return username && password;
}