import Cookies from 'js-cookie/src/js.cookie'

class PrivacyWire {
  constructor(PrivacyWireSettings) {
    this.cookie = this.sanitizeCookie();
    this.settings = this.sanitizeSettings(PrivacyWireSettings);
    this.consent = {};
    this.consent.necessary = true;
    this.consent.statistics = false;
    this.consent.marketing = false;
    this.consent.external_media = false;

    if (!this.hasValidConsent() && this.hasNoDNT()) {
      this.showBanner();
    }

    console.log(this);
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

  showBanner() {
    this.banner = {};
    this.banner.wrapper = document.querySelector(".privacywire-wrapper");
    this.banner.button_accept_all = this.banner.wrapper.querySelector("button.allow-all");
    this.banner.button_accept_necessary = this.banner.wrapper.querySelector("button.allow-necessary");
    this.banner.button_choose = this.banner.wrapper.querySelector("button.choose");
    this.banner.button_save = this.banner.wrapper.querySelector("button.save");

    this.banner.wrapper.classList.add("show-banner");
    this.handleButtons();

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

  handleButtons() {

    this.banner.button_accept_all.onclick = () => {
      this.consent.necessary = true;
      this.consent.statistics = true;
      this.consent.marketing = true;
      this.consent.external_media = true;
      this.savePreferences();
    };

    this.banner.button_accept_necessary.onclick = () => {
      this.consent.necessary = true;
      this.consent.statistics = false;
      this.consent.marketing = false;
      this.consent.external_media = false;
      this.savePreferences();
    };

    this.banner.button_choose.onclick = () => {
      this.banner.wrapper.classList.remove("show-banner");
      this.banner.wrapper.classList.add("show-options");
    };

    this.banner.button_save.onclick = () => {
      // TODO Check Form Input / Checkboxes
      // ...
      // this.savePreferences();
      console.log("Save Preferences");
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
  }

}

let privacyWire = new PrivacyWire(PrivacyWireSettings);
