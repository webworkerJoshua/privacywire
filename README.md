# PrivacyWire
🍪 ProcessWire module for Privacy- &amp; Cookie-Management (GDPR)

This module adds management options for GDPR-relevant elements (loading maps, videos etc. only after accepting external media) and cookies. 

**WARNING**: This is a draft! Not a fully working module! Not tested a lot! Highly experimental!

**... Work in progress ...**

## The aim & working mechanism of this module

This modules outputs a cookie management banner (nearly unstyled, that's up to you) with the possibility for the user to:
1. Accept all cookies
2. Accept only necessary cookies
3. Choose, which cookie categories the user wants to allow
    1. statistics
    2. external media (G Maps, YouTube, Vimeo ...)
    3. marketing

After the user made his decision, script tags of these categories can be loaded subsequently.  
```<script type="optin" data-type="text/javascript" data-category="statistics" data-src="/path/to/your/script.js"></script>```  
or inline:  
```<script type="optin" data-type="text/javascript" data-category="statistics">console.log("Statistic Cookies are allowed!");</script>```  

## Inspiration & Thank you
This module is heavily inspired by the following repos (big thanks!):
- https://github.com/webmanufaktur/CookieManagementBanner
- https://github.com/johannesdachsel/cookiemonster
- https://github.com/KIProtect/klaro
