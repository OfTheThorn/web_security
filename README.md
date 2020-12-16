#Web security app by Matthias Van Den Dooren

Technology used to develop this website is Laravel Jetstream 8. 

#### Providers used
- Combell is used for hosting (<a href="https://ofthethorn.be">ofthethorn.be</a>)
- Cloudflare for HTTPS and security.

### HTTPS
- <a href="https://www.ssllabs.com/ssltest/analyze.html?d=ofthethorn.be">SSL Labs</a>
- <a href="https://hstspreload.org/?domain=ofthethorn.be">HSTS Preload list</a>

### Registration
- Username, email, password required
- Login using username
- Password:
    - Min. 7 characters
    - HIBP Pwned using <a href="https://github.com/ubient/laravel-pwned-passwords">ubient-laravel-pwned-passwords</a>
- Email verification
- Password manager support
- Password encrpytion via Bcrypt

### Login
- Time-out upon 5 failures
- Can paste password
- Email verification
- Shows username when logged in in top-right corner
- Profile section to view + modify user details

### Privacy declaration
- Visible on all pages
- <a href="https://www.ofthethorn.be/privacy">https://www.ofthethorn.be/privacy</a>

### Permissions
- Clear cookie policy at <a href="https://www.ofthethorn.com/cookies"> https://www.ofthethorn.com/cookies</a>
- Request permission on every page. Stored as session cookie.
- Using <a href="https://github.com/spatie/laravel-cookie-consent">spatie-laravel-cookie-consent</a>

### Rights
- Print all rights using <a href="https://ofthethorn.be/user/profile/detailsJSON">link</a> (JSON)
- Privacy declaration contains others

### Verwerkingsregister (Records of processing activities)
- Can be found in our <a href="https://github.com/OfTheThorn/web_security/blob/master/Verwerkingsregister.txt">GitHub</a>

### Measures against attacks
- Third-party components are up-to-date and have no known security threats
- Only using widely popular, commonly used and frequently updated packages
- Secrets are protected
    - Data is encrypted
    - Correctly setup server
    - Usage of .env file which is inaccessible for attackers
- XSS, CSRF, code injection protection:
    - XSS flaw was fixed in Laravel 7 (This website was made using Laravel 8)
    - CSRF protection on all forms
        - Further info at <a href="https://laravel.com/docs/8.x/csrf#csrf-x-xsrf-token"> link</a>
    - Code injection
        - Vulnerability fixed in 5.8
        - Using Laravel's Eloquent for queries prevents injection
- Using <a href="https://snyk.io/vuln/composer:laravel%2Fframework">Synk</a> to keep up to date with security issues regarding Laravel.
- Setup GitHub Action to run NPM audit daily/on each push & pull to check vulnerabilities in packages

### Secrets
- Usage of .env files to keep secrets (only accessible from backend)
- No secrets in plaintext in Github
- X-XSRF-COOKIES are used in frontend
    - Cookies are encrypted

### Measures against web vulnerabilities
- CSRF, XSS and code injection have been discussed before
- Clickjacking protection using FrameGuard middleware (set X-Frame-Options to SAMEORIGIN)
- SQL injection protection using Eloquent
- HTML & CSS injection prevention using Laravel's built in escape

### Rest API
- API can be found at <a href="https://ofthethorn.be/api/gins">/api/gins</a>
- OPTIONS headers for available for all requests
- OPTIONS response returns all required parameters.
- Allowed origins are https://ofthethorn.be and https://www.ofthethorn.be
    - All operations are allowed from these origins. Requests from other origins will be blocked.
- Public API keys:
    - Regular user: ky8l0PYTCTZJCyDdqkv39FQAOxOTq8i9lhkwAwup
    - Admin user: sEFDzPbTZ9mAfjAIWpp80woVKLeUmW4R4auzJ4RZ
- Token based system
- Protected against MIME sniffing
- Protected against clickjacking (X-Frame-Options)
- Rules:
    - Everything except get list / get individual gin requires token
    - Users can create new gins, cannot delete gins created by other users
    - Admins can't create new gins, can delete gins of everyone
    - Users can generate their own key and set own options on the API section after logging in
    - Everyone can edit all gins
    - Bearer token required for all actions except get list and get id (returns 401 if not)
- Possible requests:
    - https://ofthethorn.be/api/gins
        - GET request
            - No token required
            - Returns full list of all gins
            - 200 OK when successful
    - https://ofthethorn.be/api/gins/{id}
        - GET 
            - No token required
            - Returns 200 if found
            - Returns 404 if not found
        - POST 
            - Returns 405 error (not allowed)
        - PUT 
            - Returns 204 if empty
        - DELETE
    
