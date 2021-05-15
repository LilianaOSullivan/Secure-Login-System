import requests as r
from config import login_url

s = r.Session()

lockout_text = "You are locked out for"

for i in range(1, 10):
    response = s.post(
        login_url,
        data={"username": "admin", "password": "not the correct password"},
    )
    if "could not be authenticated" not in response.text:
        print(f"Locked out at {i} attempt(s)")
        break
else:
    print("🚨 No Lockout occurred 🚨")

# Try login while locked out
response = s.post(
    login_url,
    data={"username": "admin", "password": "not the correct password"},
)
assert lockout_text in response.text, "🚨 Lockout not enforced 🚨"

# Clear cookies, and try login
s.cookies.clear()
response = s.post(
    login_url,
    data={"username": "admin", "password": "not the correct password"},
)
assert lockout_text in response.text, "🚨 Lockout lifted with clearing cookies 🚨"

print("All lockout scenarios passed! ✨✨")
print("Please do not forget to clear the lockout entries 💁")