document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});
  });

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.datepicker');
  var options = {format: "dd-mmm-yyyy", yearRange: 30, setDefaultDate: true};
  var instances = M.Datepicker.init(elems, options);
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, {} );
});

// all non filter dropdowns. Close on click FALSE gives a better experience
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.dropdown-trigger');
  // hover false because you can't hover with a mobile. 
  var options = {hover: false, coverTrigger: false, closeOnClick: true}; 
  var instances = M.Dropdown.init(elems, options);
});

// filters need to not close on click because they trigger a server request and it needs to be obvious
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.dropdown-trigger-filters');
  // hover false because you can't hover with a mobile. 
  // closeOnClick false works better on mobiles (more resposive button and more obvious server is doing something)
  var options = {hover: false, coverTrigger: false, closeOnClick: false}; 
  var instances = M.Dropdown.init(elems, options);
});


document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.tooltipped');
  var options = {};
  var instances = M.Tooltip.init(elems, options);
});
