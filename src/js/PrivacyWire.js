import Cookies from 'js-cookie/src/js.cookie'

// NodeList.forEach Polyfill for old browsers
if (window.NodeList && !NodeList.prototype.forEach) {
  NodeList.prototype.forEach = Array.prototype.forEach;
}

class PrivacyWire {
  constructor(PrivacyWireSettings) {
    this.cookie = this.sanitizeCookie();
    this.settings = this.sanitizeSettings(PrivacyWireSettings);
    this.consent = {};
    this.consent.necessary = true;
    this.consent.statistics = false;
    this.consent.marketing = false;
    this.consent.external_media = false;

    this.updateConsentFromCookie();
    this.initBanner();
    this.updateElements();
    this.handleExternalTriggers();

    if (!this.hasValidConsent() && this.hasNoDNT()) {
      this.showBanner();
    }
  }

  sanitizeCookie() {
    if (!Cookies.get('privacywire')) {
      return null;
    }
    const cookieInput = JSON.parse(decodeURIComponent(Cookies.get('privacywire')));

    let cookie = {};
    cookie.version = parseInt(cookieInput.version) ?? null;
    cookie.consent = {};
    cookie.consent.necessary = Boolean(cookieInput.consent.necessary) ?? null;
    cookie.consent.statistics = Boolean(cookieInput.consent.statistics) ?? null;
    cookie.consent.marketing = Boolean(cookieInput.consent.marketing) ?? null;
    cookie.consent.external_media = Boolean(cookieInput.consent.external_media) ?? null;

    return cookie;
  }

  sanitizeSettings(PrivacyWireSettings) {
    let settings = {};
    settings.dnt = Boolean(parseInt(PrivacyWireSettings.dnt));
    settings.version = parseInt(PrivacyWireSettings.version);
    settings.options = Boolean(parseInt(PrivacyWireSettings.options));
    return settings;
  }

  hasValidConsent() {
    if (this.cookie == null) {
      return false;
    }

    return this.cookie.version === this.settings.version;
  }

  hasNoDNT() {
    if (this.settings.dnt === true && navigator.doNotTrack === "1") {
      this.consent.necessary = true;
      this.consent.statistics = false;
      this.consent.marketing = false;
      this.consent.external_media = false;
      this.savePreferences(true);
      return false;
    }

    return true;
  }

  initBanner() {
    this.banner = {};
    this.banner.wrapper = document.querySelector(".privacywire-wrapper");
    this.banner.button_accept_all = this.banner.wrapper.querySelector("button.allow-all");
    this.banner.button_accept_necessary = this.banner.wrapper.querySelector("button.allow-necessary");
    this.banner.button_choose = this.banner.wrapper.querySelector("button.choose");
    this.banner.button_save = this.banner.wrapper.querySelector("button.save");
    this.banner.button_toggle = this.banner.wrapper.querySelector("button.toggle");
    this.banner.options = this.banner.wrapper.querySelectorAll(".privacywire-options input.optional");
    this.banner.options_statistics = this.banner.wrapper.querySelector(".privacywire-options input#statistics");
    this.banner.options_external_media = this.banner.wrapper.querySelector(".privacywire-options input#external_media");
    this.banner.options_marketing = this.banner.wrapper.querySelector(".privacywire-options input#marketing");
    this.banner.toggleToStatus = true;

    this.prefillOptionValues();
    this.handleButtons();
  }

  showBanner() {
    this.banner.wrapper.classList.add("show-banner");
  }

  showOptions() {
    this.banner.wrapper.classList.remove('show-banner');
    this.banner.wrapper.classList.add("show-options");
  }

  hideBanner() {
    this.banner.wrapper.classList.remove('show-banner');
    this.banner.wrapper.classList.remove('show-options');
  }

  showMessage() {
    this.banner.wrapper.classList.add('show-message');
    setTimeout(() => {
      this.banner.wrapper.classList.remove('show-message');
    }, 1500);
  }

  prefillOptionValues() {
    this.banner.options_statistics.checked = this.consent.statistics;
    this.banner.options_external_media.checked = this.consent.external_media;
    this.banner.options_marketing.checked = this.consent.marketing;
  }

  handleButtons() {
    this.banner.button_accept_all.onclick = () => {
      this.consent.necessary = true;
      this.consent.statistics = true;
      this.consent.external_media = true;
      this.consent.marketing = true;
      this.savePreferences();
    };

    this.banner.button_accept_necessary.onclick = () => {
      this.consent.necessary = true;
      this.consent.statistics = false;
      this.consent.external_media = false;
      this.consent.marketing = false;
      this.savePreferences();
    };

    this.banner.button_choose.onclick = () => {
      this.showOptions();
    };

    this.banner.button_toggle.onclick = () => {
      this.banner.options.forEach((el) => {
        el.checked = this.banner.toggleToStatus;
      });
      this.banner.toggleToStatus = !this.banner.toggleToStatus;
    };

    this.banner.button_save.onclick = () => {
      this.consent.statistics = this.banner.options_statistics.checked;
      this.consent.external_media = this.banner.options_external_media.checked;
      this.consent.marketing = this.banner.options_marketing.checked;
      this.savePreferences();
    };
  }

  savePreferences(silent = false) {
    let cookieContent = {};
    cookieContent.version = this.settings.version;
    cookieContent.consent = this.consent;
    Cookies.set("privacywire", cookieContent, {expires: 365});
    this.hideBanner();
    if (!silent) {
      this.showMessage();
    }
    this.updateElements();
  }

  updateConsentFromCookie() {
    if (this.cookie === null) {
      return;
    }
    this.consent.statistics = this.cookie.consent.statistics;
    this.consent.external_media = this.cookie.consent.external_media;
    this.consent.marketing = this.cookie.consent.marketing;
  }

  updateElements() {
    const elements = document.querySelectorAll("[type=optin]");
    if (elements.length === 0) {
      return;
    }
    elements.forEach((el) => {
      const {dataset} = el;
      const category = dataset.category;
      let allowed = false;
      if (category) {
        for (const consentCategory in this.consent) {
          if (consentCategory === category && this.consent[consentCategory] === true) {
            allowed = true;
            break;
          }
        }
      }
      if (!allowed) {
        return;
      }

      const parent = el.parentElement;
      if (el.tagName === 'SCRIPT') {
        const newEl = document.createElement('script');
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
      } else {
        // TODO: Output method for not-script tags
      }

    });
  }

  handleExternalTriggers() {
    // TODO: for testing; later: make it clean
    const showButton = document.querySelector(".privacywire-show-options");
    if (!showButton) {
      return;
    }
    showButton.onclick = () => {
      this.showOptions();
    };
  }

}

let privacyWire = new PrivacyWire(PrivacyWireSettings);
