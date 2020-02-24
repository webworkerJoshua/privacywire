# PrivacyWire
🍪 ProcessWire module for Privacy- &amp; Cookie-Management (GDPR)

This module adds management options for cookie groups and corresponding script tags.

[Support Forum](https://processwire.com/talk/topic/23118-privacywire-cookie-management-async-external-asset-loading/)  
[Git Repo](https://github.com/blaueQuelle/privacywire/)  
[Download Module](https://github.com/blaueQuelle/privacywire/archive/master.zip)

## The aim & working mechanism of this module

This modules outputs a cookie management banner (nearly unstyled, that's up to you) with the possibility for the user to:
1. Accept all cookies
2. Accept only necessary cookies
3. Choose, which cookie categories the user wants to allow
    1. necessary 
    2. statistics
    3. external media
    4. marketing

After the user made his decision, script tags of these categories can be loaded subsequently.  
```<script type="optin" data-type="text/javascript" data-category="statistics" data-src="/path/to/your/script.js"></script>```  
or inline:  
```<script type="optin" data-type="text/javascript" data-category="statistics">console.log("Statistic Cookies are allowed!");</script>```  
Also other tags can be loaded that way, but this feature is not thoroughly tested yet:  
``<img type="optin" data-category="marketing" data-src="https://via.placeholder.com/300x300">``

## Textformatter
If you want the user to allow to change the cookie consent, use the following Textformatter:
```[[privacywire-choose-cookies]]```

## Inspiration & Thank you
This module is heavily inspired by the following repos (big thanks!):
- https://github.com/webmanufaktur/CookieManagementBanner
- https://github.com/johannesdachsel/cookiemonster
- https://github.com/KIProtect/klaro

## Changelog
- 0.0.5 Multi-language support included completely (also in TextFormatter). Added possibility to async load other assets (e.g. ``<img type="optin" data-category="marketing" data-src="https://via.placeholder.com/300x300">``)
- 0.0.4 Added possibility to add an imprint link to the banner
- 0.0.3 Multi-language support for module config (still in development)
- 0.0.2 First release
- 0.0.1 Early development
