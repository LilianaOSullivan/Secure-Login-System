import requests as r
from config import login_url, change_password_url

s = r.Session()

# * Log a user in. Used as a setup to access the change password page.
response = s.post(
    login_url,
    data={"username": "admin", "password": "Password1!"},
)
assert "Welcome admin " in response.text, "Failed to login."

# * Sending an empty token.
response = s.get(
    change_password_url,
    params={
        "current_password": "Password1!",
        "password": "Password2!",
        "confirm_password": "Password2!",
        "token": "",
    },
)
assert (
    "CSRF Failed to verify" in response.text
), "CSRF Protection did not invalidate the request with an empty token"

# * Sending no token.
response = s.get(
    change_password_url,
    params={
        "current_password": "Password1!",
        "password": "Password2!",
        "confirm_password": "Password2!",
    },
)
assert (
    "Change Password" in response.text
), "CSRF Protection did not invalidate the request with no token"

# * Sending an invalid token.
response = s.get(
    change_password_url,
    params={
        "current_password": "Password1!",
        "password": "Password2!",
        "confirm_password": "Password2!",
        "token": "abcd123456789",
    },
)
assert (
    "CSRF Failed to verify" in response.text
), "CSRF Protection did not invalidate the request with an invalid token"

print("All CSRF scenarios passed! ✨✨")
print("Please do not forget to clear the lockout entries 💁")
