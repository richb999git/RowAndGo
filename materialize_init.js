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
  var options = {enterDelay: 600};
  var instances = M.Tooltip.init(elems, options);
});


document.addEventListener('DOMContentLoaded', function() {
  // resest the spinner variable here
  document.getElementById("spinnerSet").value = "Y"; // default is Y(es)

  // use "onbeforeunload" to trigger spinner rather than set the spinner on all the filters/sorts/pagination options
  window.onbeforeunload = function(){
    //test for variable - if not set run this. If this runs immediately then it won't work
    if (document.getElementById("spinnerSet").value === "Y") {
      console.log("in onbeforeunload");
      document.getElementById("sqlSpinner").style.display = "block";
    } else {
      // if not Y then don't display spinner but set spinnerSet back to yes for next reload
      document.getElementById("spinnerSet").value = "Y";
    }
      
  };

  // runs BEFORE the "onbeforeunload" so set "spinnerSet" to N 
  document.getElementById("dload").addEventListener("click", function(e){
    // set a spinner variable to N(o) when downloading csv (because it doesn't reload page) and therefore spinner will just show otherwise
    // page reload resets the spinner so that it hides
    document.getElementById("spinnerSet").value = "N";
    document.getElementById("sqlSpinner").style.display = "none";
    console.log("download");
  });

});