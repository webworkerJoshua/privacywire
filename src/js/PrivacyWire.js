import '../scss/PrivacyWire.scss';

// NodeList.forEach Polyfill for old browsers
if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
}

// String formatter to output opt-in message of disabled elements
// source: https://stackoverflow.com/a/18234317
String.prototype.formatUnicorn = String.prototype.formatUnicorn ||
    function () {
        "use strict";
        var str = this.toString();
        if (arguments.length) {
            var t = typeof arguments[0];
            var key;
            var args = ("string" === t || "number" === t) ?
                Array.prototype.slice.call(arguments)
                : arguments[0];

            for (key in args) {
                str = str.replace(new RegExp("\\{" + key + "\\}", "gi"), args[key]);
            }
        }

        return str;
    };


/* ######### initiate functions  ######### */

const priw_showBanner = function () {
    priw_wrapper.classList.add("show-banner");
}

const priw_hideBanner = function () {
    priw_wrapper.classList.remove('show-banner');
    priw_wrapper.classList.remove('show-options');
}

const priw_setOnlyNecessaryConsent = function () {
    priw_consent.necessary = true;
    priw_consent.functional = false;
    priw_consent.statistics = false;
    priw_consent.marketing = false;
    priw_consent.external_media = false;
}

const priw_handleButtons = function () {

    priw_btn_allowAll.forEach(function (button) {
        button.onclick = function () {
            priw_consent.necessary = true;

            priw_consent.functional = true;
            priw_btns_options.functional.checked = true;

            priw_consent.statistics = true;
            priw_btns_options.statistics.checked = true;

            priw_consent.marketing = true;
            priw_btns_options.marketing.checked = true;

            priw_consent.external_media = true;
            priw_btns_options.external_media.checked = true;

            priw_savePreferences();
        }
    });

    priw_btn_allowNecessary.onclick = function () {
        priw_setOnlyNecessaryConsent();
        priw_savePreferences();
    }

    priw_btn_choose.onclick = function () {
        priw_showOptions();
    };

    priw_btn_toggle.onclick = function () {
        priw_btn_options.forEach(function (el) {
            el.checked = priw_toggle_to_status;
        });
        priw_toggle_to_status = !priw_toggle_to_status;
    };

    priw_btn_save.onclick = function () {
        priw_consent.necessary = true;
        priw_consent.functional = priw_btns_options.functional.checked;
        priw_consent.statistics = priw_btns_options.statistics.checked;
        priw_consent.marketing = priw_btns_options.marketing.checked;
        priw_consent.external_media = priw_btns_options.external_media.checked;
        priw_savePreferences();
    };

    if (priw_btn_consent_btns) {
        priw_btn_consent_btns.forEach(function (button) {
            const {dataset} = button;
            button.onclick = function () {
                priw_btns_options[dataset.consentCategory].checked = 1;
                priw_consent[dataset.consentCategory] = true;
                priw_savePreferences();
                button.parentElement.remove();
            };
        })
    }

}

const priw_showOptions = function () {
    priw_wrapper.classList.remove('show-banner');
    priw_wrapper.classList.add("show-options");
}

const priw_showMessage = function () {
    priw_wrapper.classList.add('show-message');
    setTimeout(function () {
        priw_wrapper.classList.remove('show-message');
    }, priw_settings.msgTimeout);
}

const priw_savePreferences = function (silent = false) {
    priw_consent.version = priw_settings.version;
    window.localStorage.setItem(priw, JSON.stringify(priw_consent));
    priw_hideBanner();
    if (!silent) {
        priw_showMessage();
    }

    priw_updateAllElements();
    priw_trigger_custom_function();
};

const priw_trigger_custom_function = function () {
    if (typeof window[priw_settings.cstFn] === 'function') {
        window[priw_settings.cstFn]();
    }
};

const priw_updateAllElements = function (force = false) {
    const elements = document.querySelectorAll("[data-category]");
    const consentWindows = document.querySelectorAll(".privacywire-ask-consent");

    if (consentWindows.length > 0) {
        priw_removeOldConsentWindows(consentWindows);
    }

    if (elements.length === 0) {
        return;
    }
    elements.forEach(function (el) {
        const {dataset} = el;
        const category = dataset.category;
        let allowed = false;
        if (category) {
            for (const consentCategory in priw_consent) {
                if (consentCategory === category && priw_consent[consentCategory] === true) {
                    allowed = true;
                    break;
                }
            }
        }
        if (!allowed) {
            priw_updateDisallowedElement(el);
            return;
        }

        priw_updateAllowedElement(el);
    });
}

const priw_removeOldConsentWindows = function (consentWindows) {
    consentWindows.forEach(function (el) {
        const {dataset} = el;
        const category = dataset.disallowedConsentCategory;
        let allowed = false;
        if (category) {
            for (const consentCategory in priw_consent) {
                if (consentCategory === category && priw_consent[consentCategory] === true) {
                    allowed = true;
                    break;
                }
            }
        }
        if (allowed) {
            el.remove();
        }
    });
}

const priw_updateDisallowedElement = function (el) {
    const {dataset} = el;
    if (!dataset.askConsent || dataset.askConsentRendered === "1") {
        return;
    }

    const parent = el.parentElement;
    const category = dataset.category;
    const categoryLabel = priw_settings.cookieGroups[category];

    let newEl = document.createElement("div");
    newEl.classList.add("privacywire-ask-consent");
    newEl.classList.add("consent-category-" + category);
    newEl.dataset.disallowedConsentCategory = category;
    newEl.innerHTML = priw_ask_consent_blueprint.innerHTML.formatUnicorn({
        category: categoryLabel,
        categoryname: category
    });
    parent.insertBefore(newEl, el);

    el.dataset.askConsentRendered = 1;
    // update the list of buttons
    priw_btn_consent_btns = document.querySelectorAll(".privacywire-consent-button");

}

const priw_updateAllowedElement = function (el) {
    if (el.tagName.toLowerCase() === "script") {
        priw_updateAllowedScripts(el);
    } else {
        priw_updateAllowedOtherElements(el);
    }
}

const priw_updateAllowedOtherElements = function (el) {
    const {dataset} = el;
    el.type = dataset.type;
    el.src = dataset.src;
    el.srcset = dataset.srcset;
    el = priw_removeUnusedAttributes(el);
}

const priw_updateAllowedScripts = function (el) {
    const {dataset} = el;
    const parent = el.parentElement;

    let newEl = document.createElement(el.tagName);
    for (const key of Object.keys(dataset)) {
        newEl.dataset[key] = el.dataset[key];
    }
    newEl.type = dataset.type;
    if (dataset.src) {
        newEl.src = dataset.src;
    }
    newEl.innerText = el.innerText;
    newEl.id = el.id;
    newEl.defer = el.defer;
    newEl.async = el.async;
    newEl = priw_removeUnusedAttributes(newEl);

    parent.insertBefore(newEl, el);
    parent.removeChild(el);
}

const priw_removeUnusedAttributes = function (el) {
    el.removeAttribute("data-ask-consent");
    el.removeAttribute("data-ask-consent-rendered");
    el.removeAttribute("data-category");
    el.removeAttribute("data-src");
    el.removeAttribute("data-srcset");
    el.removeAttribute("data-type");
    return el;
}

const priw_handleExternalTriggers = function () {
    const showButtons = document.querySelectorAll(".privacywire-show-options");
    if (!showButtons.length) {
        return;
    }
    showButtons.forEach(function (showButton) {
        showButton.onclick = function (e) {
            e.preventDefault();
            priw_showOptions();
            priw_handleButtons();
        };
    });
}

const priw_removeDeprecatedConsent = function () {
    window.localStorage.removeItem(priw);
    priw_setOnlyNecessaryConsent();
}

/* ######### initiate variables  ######### */

let priw_settings = {};
priw_settings.dnt = Boolean(parseInt(PrivacyWireSettings.dnt));
priw_settings.version = parseInt(PrivacyWireSettings.version);
priw_settings.cstFn = PrivacyWireSettings.customFunction;
priw_settings.msgTimeout = parseInt(PrivacyWireSettings.messageTimeout) ?? 1500;
priw_settings.cookieGroups = PrivacyWireSettings.cookieGroups ?? {};

let priw = "privacywire";
let priw_wrapper = document.querySelector(".privacywire-wrapper");
let priw_btn_allowAll = priw_wrapper.querySelectorAll(".allow-all");
let priw_btn_allowNecessary = priw_wrapper.querySelector(".allow-necessary");
let priw_btn_choose = priw_wrapper.querySelector(".choose");
let priw_btn_save = priw_wrapper.querySelector(".save");
let priw_btn_toggle = priw_wrapper.querySelector(".toggle");
let priw_btn_options = priw_wrapper.querySelectorAll(".optional");
let priw_btns_options = {};
priw_btns_options.functional = priw_wrapper.querySelector("#functional");
priw_btns_options.statistics = priw_wrapper.querySelector("#statistics");
priw_btns_options.marketing = priw_wrapper.querySelector("#marketing");
priw_btns_options.external_media = priw_wrapper.querySelector("#external_media");
let priw_toggle_to_status = true;
let priw_ask_consent_blueprint = document.querySelector(".privacywire-ask-consent-blueprint");
let priw_btn_consent_btns = document.querySelectorAll(".privacywire-consent-button");

let priw_consent = {};
let priw_storage = (window.localStorage.getItem(priw)) ? JSON.parse(window.localStorage.getItem(priw)) : "";

if (priw_storage) {
    if (parseInt(priw_storage.version) !== priw_settings.version) {
        priw_removeDeprecatedConsent();
    } else {
        priw_consent.version = parseInt(priw_storage.version) ?? 0;
        priw_consent.necessary = Boolean(priw_storage.necessary) ?? true;
        priw_consent.functional = Boolean(priw_storage.functional) ?? false;
        priw_consent.statistics = Boolean(priw_storage.statistics) ?? false;
        priw_consent.marketing = Boolean(priw_storage.marketing) ?? false;
        priw_consent.external_media = Boolean(priw_storage.external_media) ?? false;

        // prefill the option checkboxes
        priw_btns_options.functional.checked = priw_consent.functional;
        priw_btns_options.statistics.checked = priw_consent.statistics;
        priw_btns_options.marketing.checked = priw_consent.marketing;
        priw_btns_options.external_media.checked = priw_consent.external_media;
    }

} else {
    priw_consent.version = 0;
    priw_setOnlyNecessaryConsent();

    if (priw_settings.dnt === true && navigator.doNotTrack === "1") {
        priw_consent.version = 1;
        priw_savePreferences(true);
    }
}

let priw_valid_consent = priw_consent.version > 0 && priw_consent.version === priw_settings.version;

/* ######### initiate the whole thing  ######### */
if (!priw_valid_consent) {
    priw_showBanner();
}

priw_updateAllElements();
priw_handleButtons();
priw_handleExternalTriggers();
