export default function IntersectionObserver() {

  var defaults = {
    identifier: '',
    options: {
      root: null,
      rootMargin: '0px',
      threshold: 0.3
    },
    classes: []
  }

  var intersectionObserverAPI = {};

  intersectionObserverAPI.run = function(identifier, options, classes){
    if(identifier){
      defaults.identifier = identifier
    }
    if(options){
      defaults.options = options
    }
    new IntersectionObserver(add);
  }

  var getElements = function(elements){
    document.body.querySelectorAll(elements);
  }

  var addClass = function(classList){

  }

  var setObserver = function(entries, observer){
    Array.prototype.forEach.call(entries, function (entry) {
      if (entry.isIntersecting) {
        addClass();
        return;
      }
    });
  }

  return intersectionObserverAPI;
}

function showSection(entries, observer) {
  Array.prototype.forEach.call(entries, function (entry) {
    if (entry.isIntersecting) {
      entry.target.classList.add('animate__fadeIn');
      return;
    }
  });
}

var options = {
  root: null,
  rootMargin: '0px',
  threshold: 0.3
};

var observer = new IntersectionObserver(showSection, options);

var sections = document.querySelectorAll('.animate__animated');
Array.prototype.forEach.call(sections, function (section) {
  observer.observe(section);
});
