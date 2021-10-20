//IE detection until 10
export const IE = (function () {

    var ret, isTheBrowser,
        actualVersion,
        jscriptMap, jscriptVersion;

    isTheBrowser = false;
    jscriptMap = {
        "5.5": "5.5",
        "5.6": "6",
        "5.7": "7",
        "5.8": "8",
        "9": "9",
        "10": "10"
    };
    jscriptVersion = new Function("/*@cc_on return @_jscript_version; @*/")();

    if (jscriptVersion !== undefined) {
        isTheBrowser = true;
        actualVersion = jscriptMap[jscriptVersion];
    }

    ret = {
        isTheBrowser: isTheBrowser,
        actualVersion: actualVersion
    };

    return ret;
}());

//Returns true if IE 11
export const isIE11 = !!window.MSInputMethodContext && !!document.documentMode;