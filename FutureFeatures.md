# Future Features within PrivacyWire

## Detection of consent-required elements via css-class `require-consent` instead of `data-category="..."`
To allow a more flexible way to detect elements which require consent, the css class `require-consent` is necessary. With this enabled, PrivacyWire also detects dynamically added elements without re-initiating.  
A little background: To receive a list of elements via data-attributes it is required to use `document.querySelectorAll('[data-category]')` which returns a static NodeList. When we use `document.getElementsByClassName("require-consent")` instead we have access to a **live** HTMLCollection.