import requests as r
from config import register_url

s = r.Session()

# Expected message
expectation: str = "Username is taken and/or password is incorrect"

# New user-agent used to ensure the testing client is not locked out
headers = {
    "User-Agent": "Mozilla/5.0 (Macintosh; U; PPC; en-US; rv:0.9.2) Gecko/20010726 Netscape6/6.1"
}

# Ensure Password length
response = s.post(
    register_url,
    data={
        "username": "cookielover57",
        "password": "Passw1!",
        "confirm_password": "Passw1!",
    },
)

assert expectation in response.text, "Password length was not enforced"

# Ensure uppercase letter is used
response = s.post(
    register_url,
    data={
        "username": "cookielover57",
        "password": "password1!",
        "confirm_password": "password1!",
    },
)

assert expectation in response.text, "Use of an uppercase letter was not enforced"

# Ensure lowercase letter is used
response = s.post(
    register_url,
    data={
        "username": "cookielover57",
        "password": "PASSWORD1!",
        "confirm_password": "PASSWORD1!",
    },
)

assert expectation in response.text, "Use of a lowercase letter was not enforced"

# Ensure special character is used
response = s.post(
    register_url,
    data={
        "username": "cookielover57",
        "password": "Password1",
        "confirm_password": "Password1",
    },
    headers=headers,
)

assert expectation in response.text, "Use of a special character was not enforced"

# Ensure contains a number
response = s.post(
    register_url,
    data={
        "username": "cookielover57",
        "password": "Password!",
        "confirm_password": "Password!",
    },
    headers=headers,
)

assert expectation in response.text, "Password number requirement was not enforced"

# Ensure password's match
response = s.post(
    register_url,
    data={
        "username": "cookielover57",
        "password": "Password1!",
        "confirm_password": "Password57!1",
    },
    headers=headers,
)

assert expectation in response.text, "Password confirmation was not enforced"


print("All verification scenarios passed! ✨✨")
print("Please do not forget to clear the lockout entries 💁")
print("ℹ️ This test created two lockout entries ℹ️")
