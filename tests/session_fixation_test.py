import requests as r
from config import login_url,welcome_url

malicious_user = r.Session()
victim = r.Session()

# Malicious user visits the site
malicious_user.get(login_url)

# Fixates the victim's session ID to theirs
victim.cookies.update(malicious_user.cookies)

# The victim logs in
victim.post(
    login_url,
    data={"username": "Admin", "password": "Password1!"},
)

victim_response = victim.get(welcome_url)
malicious_user_response = malicious_user.get(welcome_url)

assert malicious_user_response.url != welcome_url, "🚨 Malicious User logged in 🚨"
assert victim_response.url == welcome_url, "🚨 The Victim was unable to login 🚨"
assert (
    victim.cookies["PHPSESSID"] != malicious_user.cookies["PHPSESSID"]
), "🚨 Session ID's were not rotated 🚨"

print("Session Fixation scenario passed! ✨ ✨")