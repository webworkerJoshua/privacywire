import '../scss/PrivacyWire.scss';

// NodeList.forEach Polyfill for old browsers
if (window.NodeList && !NodeList.prototype.forEach) {
  NodeList.prototype.forEach = Array.prototype.forEach;
}

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

  priw_btn_allowAll.onclick = function () {
    priw_consent.necessary = true;
    priw_consent.functional = true;
    priw_consent.statistics = true;
    priw_consent.marketing = true;
    priw_consent.external_media = true;
    priw_savePreferences();
  }

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
    priw_consent.functional = priw_btn_options_functional.checked;
    priw_consent.statistics = priw_btn_options_statistics.checked;
    priw_consent.marketing = priw_btn_options_marketing.checked;
    priw_consent.external_media = priw_btn_options_external_media.checked;
    priw_savePreferences();
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
  }, 1500);
}

const priw_savePreferences = function (silent = false) {
  if (priw_consent.version === 0) {
    priw_consent.version = priw_settings.version;
  }
  window.localStorage.setItem(priw, JSON.stringify(priw_consent));
  priw_hideBanner();
  if (!silent) {
    priw_showMessage();
  }

  priw_updateElements();
  priw_trigger_custom_function();
};

const priw_trigger_custom_function = function () {
  if (typeof window[priw_settings.cstFn] === 'function') {
    window[priw_settings.cstFn]();
  }
};

const priw_updateElements = function () {
  const elements = document.querySelectorAll("[data-category]");
  if (elements.length === 0) {
    return;
  }
  elements.forEach((el) => {
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
      return;
    }

    const parent = el.parentElement;
    const newEl = document.createElement(el.tagName);
    for (const key of Object.keys(dataset)) {
      newEl.dataset[key] = el.dataset[key];
    }
    newEl.type = dataset.type;
    newEl.innerText = el.innerText;
    newEl.text = el.text;
    newEl.class = el.class;
    newEl.style.cssText = el.style.cssText;
    newEl.id = el.id;
    newEl.name = el.name;
    newEl.defer = el.defer;
    newEl.async = el.async;
    if (dataset.src) {
      newEl.src = dataset.src;
    }

    parent.insertBefore(newEl, el);
    parent.removeChild(el);
  });
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

/* ######### initiate variables  ######### */

let priw_settings = {};
priw_settings.dnt = Boolean(parseInt(PrivacyWireSettings.dnt));
priw_settings.version = parseInt(PrivacyWireSettings.version);
priw_settings.cstFn = PrivacyWireSettings.customFunction;

let priw = "privacywire";
let priw_wrapper = document.querySelector(".privacywire-wrapper");
let priw_btn_allowAll = priw_wrapper.querySelector(".allow-all");
let priw_btn_allowNecessary = priw_wrapper.querySelector(".allow-necessary");
let priw_btn_choose = priw_wrapper.querySelector(".choose");
let priw_btn_save = priw_wrapper.querySelector(".save");
let priw_btn_toggle = priw_wrapper.querySelector(".toggle");
let priw_btn_options = priw_wrapper.querySelectorAll(".optional");
let priw_btn_options_functional = priw_wrapper.querySelector("#functional");
let priw_btn_options_statistics = priw_wrapper.querySelector("#statistics");
let priw_btn_options_marketing = priw_wrapper.querySelector("#marketing");
let priw_btn_options_external_media = priw_wrapper.querySelector("#external_media");
let priw_toggle_to_status = true;

let priw_consent = {};
let priw_storage = (window.localStorage.getItem(priw)) ? JSON.parse(window.localStorage.getItem(priw)) : "";

if (priw_storage) {
  priw_consent.version = parseInt(priw_storage.version) ?? 0;
  priw_consent.necessary = Boolean(priw_storage.statistics) ?? true;
  priw_consent.functional = Boolean(priw_storage.functional) ?? false;
  priw_consent.statistics = Boolean(priw_storage.statistics) ?? false;
  priw_consent.marketing = Boolean(priw_storage.marketing) ?? false;
  priw_consent.external_media = Boolean(priw_storage.marketing) ?? false;

  // prefill the option checkboxes
  priw_btn_options_functional.checked = priw_consent.functional;
  priw_btn_options_statistics.checked = priw_consent.statistics;
  priw_btn_options_marketing.checked = priw_consent.marketing;
  priw_btn_options_external_media.checked = priw_consent.external_media;
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
priw_updateElements();
priw_handleButtons();
priw_handleExternalTriggers();
