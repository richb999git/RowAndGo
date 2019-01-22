document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});
  });

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.datepicker');
  var options = {format: "dd-mmm-yyyy", yearRange: 60, setDefaultDate: true};
  var instances = M.Datepicker.init(elems, options);
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, {} );
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.dropdown-trigger');
  var options = {hover: false, coverTrigger: false, inDuration: 300, outDuration: 150}; // hover false because you can't hover with a mobile
  var instances = M.Dropdown.init(elems, options);
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.tooltipped');
  var options = {};
  var instances = M.Tooltip.init(elems, options);
});

