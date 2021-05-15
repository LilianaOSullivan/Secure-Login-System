function password_strength() {
    var password = document.getElementById("password");
    var confirm_password = document.getElementById("confirm_password");
    var password_match = document.getElementById("password_match");
    var hr = document.getElementById("hr");
    var password_div = document.getElementById("password_div");
    var lowercase = document.getElementById("lowercase");
    var uppercase = document.getElementById("uppercase");
    var numbers = document.getElementById("numbers");
    var length = document.getElementById("length");
    var special_char = document.getElementById("special_char");
    var username_empty = document.getElementById("username_empty");
    var username = document.getElementById("username");

    var elements = [lowercase, uppercase, numbers, special_char];
    const test_cases = [/[a-z]/g, /[A-Z]/g, /[0-9]/g, /[^\w\d\s:]/g];

    const zip = (a, b) => a.map((e, i) => [e, b[i]]);
    const swap_class = (element, condition, class1 = 'invalid', class2 = 'valid') => {
        if (condition) {
            element.classList.remove(class1);
            element.classList.add(class2);
        }
        else {
            element.classList.remove(class2);
            element.classList.add(class1);
        }
    }
    password.onkeyup = function () {
        zip(elements, test_cases).forEach(x => {
            swap_class(x[0], password.value.match(x[1]));
        });
        swap_class(length, password.value.trim().length >= 8);
        swap_class(password_match, password.value.trim() === confirm_password.value.trim()
                    && password.value.trim().length !== 0);
        swap_class(username_empty, username.value.trim().length != 0);
        swap_class(password_div, validate_password(), "password_div_invalid", "password_div_valid");
        swap_class(hr, validate_password(), "hr_invalid", "hr_valid");
    }

    username.onkeyup = function () {
        swap_class(username_empty, username.value.trim().length != 0);
    }

    confirm_password.onkeyup = function () {
        swap_class(password_div, validate_password(), "password_div_invalid", "password_div_valid");
        swap_class(hr, validate_password(), "hr_invalid", "hr_valid");
        swap_class(username_empty, username.value.trim().length != 0);
        swap_class(password_match, password.value.trim() === confirm_password.value.trim()
                    && password.value.trim().length !== 0);
    }
}

function validate_password() {
    var lowercase = document.getElementById("lowercase").classList.contains('valid');
    var uppercase = document.getElementById("uppercase").classList.contains('valid');
    var numbers = document.getElementById("numbers").classList.contains('valid');
    var length = document.getElementById("length").classList.contains('valid');
    var username_empty = document.getElementById("username_empty").classList.contains('valid');
    var special_char = document.getElementById("special_char").classList.contains('valid');
    var password_confirmed = (
        document.getElementById("password").value.trim() === document.getElementById("confirm_password").value.trim()
            && document.getElementById("password").value.trim().length !== 0);

    return true;
    // return lowercase && uppercase && numbers && length && special_char && username_empty && password_confirmed;
}