let defConfig = {
  attributes: true,
  childList: true,
  subtree: true
};

const callback = function (mutationsList, observer) {
  for (let mutation of mutationsList) {
    switch (mutation.type) {
      case 'childList':
        var childEvent = document.createEvent('childChanged');
        childEvent.initEvent('childChanged', true, true);
        e.target.dispatchEvent('childChanged');
        break;
      case 'attributes':
        var attrEvent = document.createEvent('attrChanged');
        attrEvent.initEvent('attrChanged', true, true);
        e.target.dispatchEvent('attrChanged');
        break;
    }
  }
};

export const Observer = function (target, config) {

  if (typeof (config) === 'object') {
    defConfig = config;
  }

  const observer = new MutationObserver(callback);

  observer.observe(target, defConfig);

};