var $parcel$global =
typeof globalThis !== 'undefined'
  ? globalThis
  : typeof self !== 'undefined'
  ? self
  : typeof window !== 'undefined'
  ? window
  : typeof global !== 'undefined'
  ? global
  : {};
var $parcel$modules = {};
var $parcel$inits = {};

var parcelRequire = $parcel$global["parcelRequire8534"];
if (parcelRequire == null) {
  parcelRequire = function(id) {
    if (id in $parcel$modules) {
      return $parcel$modules[id].exports;
    }
    if (id in $parcel$inits) {
      var init = $parcel$inits[id];
      delete $parcel$inits[id];
      var module = {id: id, exports: {}};
      $parcel$modules[id] = module;
      init.call(module.exports, module, module.exports);
      return module.exports;
    }
    var err = new Error("Cannot find module '" + id + "'");
    err.code = 'MODULE_NOT_FOUND';
    throw err;
  };

  parcelRequire.register = function register(id, init) {
    $parcel$inits[id] = init;
  };

  $parcel$global["parcelRequire8534"] = parcelRequire;
}
"use strict";
parcelRequire.register("5Cx6U", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $417a2f639878b9c2$var$_DateTime = $417a2f639878b9c2$var$_interopRequireDefault((parcelRequire("1RiVQ")));

var $417a2f639878b9c2$var$_JQElement = $417a2f639878b9c2$var$_interopRequireDefault((parcelRequire("c6nhD")));
function $417a2f639878b9c2$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
/**
 * Represents the last cleared text element
 */ class $417a2f639878b9c2$var$LastClearedText extends $417a2f639878b9c2$var$_JQElement.default {
    setLastClearedText(date) {
        if (this.element.length) {
            let lastClearedAt;
            try {
                lastClearedAt = $417a2f639878b9c2$var$_DateTime.default.formatDate(new Date(date));
            } catch  {
                lastClearedAt = $417a2f639878b9c2$var$_DateTime.default.formatDate(new Date(Date.now()));
            }
            this.setText(`Last cleared: ${lastClearedAt}`);
        }
    }
    constructor(element = jQuery('#wpe-last-cleared-text')){
        super(element);
    }
}
var $417a2f639878b9c2$var$_default = $417a2f639878b9c2$var$LastClearedText;
module.exports.default = $417a2f639878b9c2$var$_default;

});
parcelRequire.register("1RiVQ", function(module, exports) {
'use strict';
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $15a96d32ead9e202$var$_Time = $15a96d32ead9e202$var$_interopRequireDefault((parcelRequire("g9Urd")));
function $15a96d32ead9e202$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
class $15a96d32ead9e202$var$DateTime {
    static getDateTimeUTC(date) {
        return date.getTime() + $15a96d32ead9e202$var$_Time.default.minutes(date.getTimezoneOffset());
    }
    static getLocalDateTimeFromUTC(date) {
        const newDate = new Date(date.getTime() + $15a96d32ead9e202$var$_Time.default.minutes(date.getTimezoneOffset()));
        const offset = date.getTimezoneOffset() / 60;
        const hours = date.getHours();
        newDate.setHours(hours - offset);
        return newDate;
    }
    static formatDate(date, locale = window.navigator.language || 'en-US') {
        const localOptions = {
            dateStyle: 'medium',
            timeStyle: 'short'
        };
        return `${new Intl.DateTimeFormat(locale, localOptions).format(date)} UTC`;
    }
    static isLastClearedExpired(lastClearedAt, threshold = $15a96d32ead9e202$var$_Time.default.minutes(5)) {
        const lastClearedAtDate = new Date(Date.parse(lastClearedAt));
        if (!this.isValidDate(lastClearedAtDate)) {
            console.warn(`Invalid date: ${lastClearedAt}`);
            return true;
        }
        const now = $15a96d32ead9e202$var$DateTime.getDateTimeUTC(new Date(Date.now()));
        return now - lastClearedAtDate.getTime() > threshold;
    }
    static isValidDate(d) {
        return d instanceof Date && !Number.isNaN(d.getTime());
    }
}
var $15a96d32ead9e202$var$_default = $15a96d32ead9e202$var$DateTime;
module.exports.default = $15a96d32ead9e202$var$_default;

});
parcelRequire.register("g9Urd", function(module, exports) {
'use strict';
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;
class $bc3944012f8739af$var$Time {
    static hours(h) {
        return h * 3600000;
    }
    static minutes(m) {
        return m * 60000;
    }
    static days(d) {
        return d * 86400000;
    }
}
var $bc3944012f8739af$var$_default = $bc3944012f8739af$var$Time;
module.exports.default = $bc3944012f8739af$var$_default;

});


parcelRequire.register("c6nhD", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;
/**
 * Represents a JQuery Element in the DOM
 */ class $8cf81b3354d48be3$var$JQElement {
    setText(text) {
        var _this$element;
        if (((_this$element = this.element) === null || _this$element === void 0 ? void 0 : _this$element.text()) !== text) this.element.text(text);
    }
    constructor(element){
        this.element = element;
    }
}
var $8cf81b3354d48be3$var$_default = $8cf81b3354d48be3$var$JQElement;
module.exports.default = $8cf81b3354d48be3$var$_default;

});



var $97be0ebf385020b0$var$_LastClearedText = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("5Cx6U")));
parcelRequire.register("ihUmn", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $d5058867f56ccf8c$var$_DateTime = $d5058867f56ccf8c$var$_interopRequireDefault((parcelRequire("1RiVQ")));

var $d5058867f56ccf8c$var$_JQElement = $d5058867f56ccf8c$var$_interopRequireDefault((parcelRequire("c6nhD")));
function $d5058867f56ccf8c$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
class $d5058867f56ccf8c$var$LastErrorText extends $d5058867f56ccf8c$var$_JQElement.default {
    setLastErrorText(date) {
        if (this.element.length) {
            let lastErrorAt;
            try {
                lastErrorAt = $d5058867f56ccf8c$var$_DateTime.default.formatDate(new Date(date));
            } catch  {
                lastErrorAt = $d5058867f56ccf8c$var$_DateTime.default.formatDate(new Date(Date.now()));
            }
            this.setText(`Error clearing all cache: ${lastErrorAt}`);
        }
    }
    constructor(element = jQuery('#wpe-last-cleared-error-text')){
        super(element);
    }
}
var $d5058867f56ccf8c$var$_default = $d5058867f56ccf8c$var$LastErrorText;
module.exports.default = $d5058867f56ccf8c$var$_default;

});


var $97be0ebf385020b0$var$_LastErrorText = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("ihUmn")));
parcelRequire.register("ebXto", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $a55039e2a9ad696d$var$_JQElement = $a55039e2a9ad696d$var$_interopRequireDefault((parcelRequire("c6nhD")));
function $a55039e2a9ad696d$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
class $a55039e2a9ad696d$var$ErrorToast extends $a55039e2a9ad696d$var$_JQElement.default {
    showToast() {
        if (this.element.length) this.element.attr('style', 'display: block');
    }
    constructor(element = jQuery('#wpe-cache-error-toast')){
        super(element);
    }
}
var $a55039e2a9ad696d$var$_default = $a55039e2a9ad696d$var$ErrorToast;
module.exports.default = $a55039e2a9ad696d$var$_default;

});


var $97be0ebf385020b0$var$_ErrorToast = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("ebXto")));
parcelRequire.register("fJ1sm", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $b72c303413ea5496$var$_JQElement = $b72c303413ea5496$var$_interopRequireDefault((parcelRequire("c6nhD")));
function $b72c303413ea5496$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
/**
 * Represents the clear all caches button
 */ class $b72c303413ea5496$var$ClearAllCacheBtn extends $b72c303413ea5496$var$_JQElement.default {
    setDisabled(reason = 'Clear all caches button disabled for 5 minutes') {
        if (this.element.length) {
            this.element.attr('aria-disabled', true);
            this.element.attr('aria-describedby', reason);
            this.element.attr('disabled', true);
        }
    }
    attachSubmit({ onSuccess: onSuccess , onError: onError  }) {
        this.element.one('click', ()=>{
            this.setDisabled();
            this.apiService.clearAllCaches().then(onSuccess).catch(onError);
        });
    }
    constructor(apiService, element = jQuery('#wpe-clear-all-cache-btn')){
        super(element);
        this.apiService = apiService;
    }
}
var $b72c303413ea5496$var$_default = $b72c303413ea5496$var$ClearAllCacheBtn;
module.exports.default = $b72c303413ea5496$var$_default;

});


var $97be0ebf385020b0$var$_ClearAllCacheBtn = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("fJ1sm")));
parcelRequire.register("d52fm", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $985d7c242596459c$var$_JQElement = $985d7c242596459c$var$_interopRequireDefault((parcelRequire("c6nhD")));
function $985d7c242596459c$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
/**
 * Represents the clear all caches icon
 */ class $985d7c242596459c$var$ClearAllCacheIcon extends $985d7c242596459c$var$_JQElement.default {
    setSuccessIcon() {
        if (this.element.length) this.element.attr('style', "content: url(\"data:image/svg+xml,%3Csvg width='50' height='50' viewBox='0 0 32 33' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect y='0.600098' width='32' height='32' rx='16' fill='%230ecad4'/%3E%3Cpath d='M21 12.7993L14.2 19.5993L11.4 16.7993L10 18.1993L14.2 22.3993L22.4 14.1993L21 12.7993Z' fill='white'/%3E%3C/svg%3E \");");
    }
    setErrorIcon() {
        if (this.element.length) this.element.attr('style', "content: url(\"data:image/svg+xml,%3Csvg width='32' height='33' viewBox='0 0 32 33' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M16 0.242615C12.8355 0.242615 9.74207 1.181 7.11088 2.9391C4.4797 4.6972 2.42894 7.19606 1.21793 10.1197C0.0069327 13.0433 -0.309921 16.2604 0.307443 19.3641C0.924806 22.4678 2.44866 25.3187 4.6863 27.5563C6.92394 29.794 9.77486 31.3178 12.8786 31.9352C15.9823 32.5525 19.1993 32.2357 22.1229 31.0247C25.0466 29.8137 27.5454 27.7629 29.3035 25.1317C31.0616 22.5005 32 19.4071 32 16.2426C31.9952 12.0006 30.308 7.93375 27.3084 4.93421C24.3089 1.93466 20.242 0.247414 16 0.242615ZM3.20001 16.2426C3.19796 13.8473 3.86862 11.4996 5.13558 9.46686C6.40255 7.4341 8.21491 5.79798 10.3662 4.74485C12.5176 3.69172 14.9214 3.26391 17.304 3.51013C19.6866 3.75635 21.9522 4.66672 23.8427 6.13755L5.89494 24.0853C4.14652 21.8451 3.19786 19.0843 3.20001 16.2426ZM16 29.0426C13.1592 29.0442 10.3995 28.0955 8.16 26.3477L26.1051 8.40261C27.5751 10.2931 28.4848 12.5584 28.7306 14.9406C28.9764 17.3228 28.5484 19.7261 27.4954 21.877C26.4424 24.0278 24.8066 25.8398 22.7743 27.1067C20.742 28.3735 18.3948 29.0443 16 29.0426Z' fill='%23D21B46'/%3E%3C/svg%3E%0A\");");
    }
    constructor(element = jQuery('#wpe-clear-all-cache-icon')){
        super(element);
    }
}
var $985d7c242596459c$var$_default = $985d7c242596459c$var$ClearAllCacheIcon;
module.exports.default = $985d7c242596459c$var$_default;

});


var $97be0ebf385020b0$var$_ClearAllCacheIcon = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("d52fm")));
parcelRequire.register("50wC2", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $3a564002fa6ae469$var$_DateTime = $3a564002fa6ae469$var$_interopRequireDefault((parcelRequire("1RiVQ")));
function $3a564002fa6ae469$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
class $3a564002fa6ae469$var$CachePluginApiService {
    clearAllCaches() {
        return new Promise((resolve, reject)=>{
            this.ajaxCall(this.paths.clearAllCachesPath, 'POST', (data)=>{
                if (data.success) {
                    const dateTime = new Date(Date.parse(data.time_cleared));
                    resolve(dateTime);
                } else reject(data.last_error_at);
            }, ()=>{
                const now = $3a564002fa6ae469$var$_DateTime.default.formatDate(new Date(Date.now()));
                reject(now);
            });
        });
    }
    ajaxCall(path, method, onSuccess, onError) {
        jQuery.ajax({
            type: method,
            url: path,
            success: (data)=>onSuccess(data)
            ,
            error: (error)=>onError(error)
        });
    }
    constructor(nonce, paths){
        this.nonce = nonce;
        this.paths = paths;
        jQuery.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', nonce);
            }
        });
    }
}
var $3a564002fa6ae469$var$_default = $3a564002fa6ae469$var$CachePluginApiService;
module.exports.default = $3a564002fa6ae469$var$_default;

});


var $97be0ebf385020b0$var$_CachePluginApiService = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("50wC2")));

var $97be0ebf385020b0$var$_DateTime = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("1RiVQ")));
parcelRequire.register("6Z5yf", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;
function $515cbefb2ea5144d$var$_classPrivateMethodGet(receiver, privateSet, fn) {
    if (!privateSet.has(receiver)) throw new TypeError("attempted to get private field on non-instance");
    return fn;
}
var $515cbefb2ea5144d$var$_removeQueryParam = /*#__PURE__*/ new WeakSet();
class $515cbefb2ea5144d$var$CachePluginWindowModifier {
    stripQueryParamFromPathname(queryParam) {
        const urlParams = $515cbefb2ea5144d$var$_classPrivateMethodGet(this, $515cbefb2ea5144d$var$_removeQueryParam, $515cbefb2ea5144d$var$_removeQueryParam2).call(this, queryParam);
        return `${this.window.location.pathname}?${urlParams}`;
    }
    replaceWindowState(url) {
        this.window.history.replaceState(null, '', url);
    }
    constructor(window){
        $515cbefb2ea5144d$var$_removeQueryParam.add(this);
        this.window = window;
    }
}
function $515cbefb2ea5144d$var$_removeQueryParam2(queryParam) {
    const newUrl = new URL(this.window.location.href);
    let params = new URLSearchParams(newUrl.search);
    params.delete(queryParam);
    return params;
}
var $515cbefb2ea5144d$var$_default = $515cbefb2ea5144d$var$CachePluginWindowModifier;
module.exports.default = $515cbefb2ea5144d$var$_default;

});


var $97be0ebf385020b0$var$_CachePluginWindowModifier = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("6Z5yf")));
parcelRequire.register("TF9JL", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;

var $0a750fe749d6db80$var$_JQElement = $0a750fe749d6db80$var$_interopRequireDefault((parcelRequire("c6nhD")));
function $0a750fe749d6db80$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
/**
 * Represents the hidden _wp_http_referer field in the cache times form
 */ class $0a750fe749d6db80$var$CacheTimesFormReferField extends $0a750fe749d6db80$var$_JQElement.default {
    replaceRefer(url) {
        this.element.val(url);
    }
    constructor(element = jQuery('input[name="_wp_http_referer"]')){
        super(element);
    }
}
var $0a750fe749d6db80$var$_default = $0a750fe749d6db80$var$CacheTimesFormReferField;
module.exports.default = $0a750fe749d6db80$var$_default;

});


var $97be0ebf385020b0$var$_CacheTimesFormReferField = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("TF9JL")));
parcelRequire.register("9uW76", function(module, exports) {
"use strict";
Object.defineProperty(module.exports, "__esModule", {
    value: true
});
module.exports.default = void 0;
var $6ea3fe8c90c813c0$var$_default = {
    notification: 'notification'
};
module.exports.default = $6ea3fe8c90c813c0$var$_default;

});


var $97be0ebf385020b0$var$_CachePluginQueryParams = $97be0ebf385020b0$var$_interopRequireDefault((parcelRequire("9uW76")));
function $97be0ebf385020b0$var$_interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
        default: obj
    };
}
(function($) {
    $(document).ready(function() {
        var _WPECachePlugin, _WPECachePlugin2;
        const removeNotificationParamFromPathname = ()=>{
            const windowModifier = new $97be0ebf385020b0$var$_CachePluginWindowModifier.default(window);
            const updatedWindowPath = windowModifier.stripQueryParamFromPathname($97be0ebf385020b0$var$_CachePluginQueryParams.default.notification);
            windowModifier.replaceWindowState(updatedWindowPath);
            const cacheTimesFormReferField = new $97be0ebf385020b0$var$_CacheTimesFormReferField.default();
            cacheTimesFormReferField.replaceRefer(updatedWindowPath);
        };
        const rootPath = wpApiSettings.root; // this root path contains the base api path for the REST Routes
        const nonce = wpApiSettings.nonce; // this is the nonce field
        const clearAllCachesPath = `${rootPath}${WPECachePlugin.clear_all_caches_path}`;
        const lastClearedAt = (_WPECachePlugin = WPECachePlugin) === null || _WPECachePlugin === void 0 ? void 0 : _WPECachePlugin.clear_all_cache_last_cleared;
        const lastErroredAt = (_WPECachePlugin2 = WPECachePlugin) === null || _WPECachePlugin2 === void 0 ? void 0 : _WPECachePlugin2.clear_all_cache_last_cleared_error;
        const cachePluginApiService = new $97be0ebf385020b0$var$_CachePluginApiService.default(nonce, {
            clearAllCachesPath: clearAllCachesPath
        });
        const activeError = lastErroredAt && !$97be0ebf385020b0$var$_DateTime.default.isLastClearedExpired(lastErroredAt);
        const activeLastCleared = lastClearedAt && !$97be0ebf385020b0$var$_DateTime.default.isLastClearedExpired(lastClearedAt);
        const lastErrorText = new $97be0ebf385020b0$var$_LastErrorText.default();
        const errorToast = new $97be0ebf385020b0$var$_ErrorToast.default();
        const lastClearedText = new $97be0ebf385020b0$var$_LastClearedText.default();
        const clearAllCacheBtn = new $97be0ebf385020b0$var$_ClearAllCacheBtn.default(cachePluginApiService);
        const clearCacheIcon = new $97be0ebf385020b0$var$_ClearAllCacheIcon.default();
        removeNotificationParamFromPathname();
        if (activeError) {
            lastErrorText.setLastErrorText(lastErroredAt);
            clearAllCacheBtn.setDisabled();
            clearCacheIcon.setErrorIcon();
        } else if (activeLastCleared) {
            lastClearedText.setLastClearedText(lastClearedAt);
            clearAllCacheBtn.setDisabled();
            clearCacheIcon.setSuccessIcon();
        }
        clearAllCacheBtn.attachSubmit({
            onSuccess: (dateTime)=>{
                lastClearedText.setLastClearedText(dateTime);
                clearCacheIcon.setSuccessIcon();
            },
            onError: (errorTime)=>{
                lastErrorText.setLastErrorText(errorTime);
                clearCacheIcon.setErrorIcon();
                errorToast.showToast();
            }
        });
    });
})(jQuery);


//# sourceMappingURL=wpe-cache-plugin-admin.js.map
