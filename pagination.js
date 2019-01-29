
document.getElementById("pagPages").addEventListener("submit", function(e){
    e.preventDefault(); 
    var inputPage = document.getElementById("pageNo");
    var lastPage = document.getElementById("php_lastPage").value;
    var url = window.location.href; // returns full url including query string 
    //var url = [location.protocol, '//', location.host, location.pathname].join(''); // join parts of url together so would need to add qstring
    var page = parseInt(inputPage.value, 10) || 1;
    location.href = url + '&page=' + (page <= lastPage ? page : lastPage); 
    //location.href = url + '?page=' + (page <= lastPage ? page : lastPage) + qstring;  
});



/* php inline version. Slightly easier but not recommended to have inline scripts
document.getElementById("pagPages").addEventListener("submit", function(e){
    e.preventDefault(); 
    var inputPage = document.getElementById("pageNo");
    var lastPage = '.$lastPage.';
    var page = parseInt(inputPage.value, 10) || 1;
    console.log("submit js");
    location.href = "'.$_SERVER["PHP_SELF"].'?page=" + (page <= lastPage ? page : lastPage) + "'.$qstring.'";         
});
*/