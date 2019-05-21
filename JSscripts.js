/*used lat.value instead of lat.innerHTML
as .value is what works with
input type forms*/

function getLocation() {
  var lat = document.getElementById("Lat");
  var long = document.getElementById("Long");

  /*if browser doesn't support Geolocation,
I am notifying the user in the form 
input value itself */
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    lat.value = "Geolocation is not supported by this browser.";
    long.value = "Geolocation is not supported by this browser.";
  }
  function showPosition(position) {
    lat.value = position.coords.latitude;
    long.value = position.coords.longitude;
  }
}

/* form validation function for register.html */
function validateRegisterForm() {
  /* the username variable is only equal to whatever is inside the username input element from register.html */
  var username = document.getElementById("name").value;
  var password = document.getElementById("password").value;
  var email = document.getElementById("email").value;
  var DateofBirth = document.getElementById("DateofBirth").value;
  var bio = document.getElementById("userbio").value;
  var refer = document.getElementById("referral").value;
  /* if nothing is typed in input element, it's an empty string
when username, password, etc. are empty, then throw window popup 
and return false */
  if (
    username == "" ||
    password == "" ||
    email == "" ||
    DateofBirth == "" ||
    bio == "" ||
    refer == ""
  ) {
    alert("Please fill in all fields!");
    return false;
  }

  /* Password Regex check: at least 1 uppercase and at least 1 number. note: ? means 0 or 1 */
  var regexPass = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/.test(password);
  if (regexPass === false) {
    alert(
      "Your password must contain at least 8 characters: at least one of 1) uppercase 2) lowercase and 3) number"
    );
    return false;
  }
  /* Email Regex check 
note: adopted from https://www.w3resource.com/javascript/form/email-validation.php
\w+ = matches one or more characters including underscore '_'
[\.-] = matches literal '.' '-' -- ? makes sure its matched 0 or 1 times
([.-]?\w+)* = matches 0 or more occurences of those in brackets
\w+([.-]?\w+)* = domain name check 
\.\w{2,3} = matches a dot followed by 2-3 word characters (.org, .com, etc.)
*/
  var regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email);
  if (regexEmail === false) {
    alert("Invalid email! Must be in the form text@text.3letters");
    return false;
  }

  /*check if 1 is checked for Driver or Owner sign-up*/
  if (
    document.getElementById("driver").checked === false &&
    document.getElementById("owner").checked === false
  ) {
    alert("You must sign up as either a Driver or an Owner!");
    return false;
  }

  /* JS DateofBirth regex check to get yyyy-mm-dd format 
match 1 or 2, then any 3 digits for the year, then - literal, then mandatory
0 following by a digit 1-9, or mandatory 1 followed by 0 to 2, 
then - literal
then mandatoy 0 followed by 1 to 9 or 1 or 2 followed by 0 to 9
or 3 o or 1
to get a reasonable yyyy-mm-dd, accepting (1991-03-12) and not (1802-94-45)
*/

  var regexDate = /^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/.test(DateofBirth);
  if (regexDate === false) {
    alert("Please enter a valid date of birth in the form yyyy-mm-dd");
    return false;
  } else {
    return true;
  }
}

/* form validation function for submission.html */
function validateSubmissionForm() {
  /* the username variable is only equal to whatever is inside the username input element from register.html */
  var name = document.getElementById("name").value;
  var desc = document.getElementById("submitdesc").value;
  var Lat = document.getElementById("Lat").value;
  var Long = document.getElementById("Long").value;
  /* if nothing is typed in input element, it's an empty string
when name, desc, Lat, Long, etc. are empty, then throw window popup 
and return false */
  if (name == "" || desc == "" || Lat == "" || Long == "") {
    alert("Please fill in all fields!");
    return false;
  }

  /* Lat/Long Regex test */
  /* 
\+|- matches an optional (?) + or - in latitude input
?:90(?:(?:\.0{1,6})? = matches 90 then a "." and 1 to 15 0's
(?:[0-9]|[1-8][0-9]) = matches 0-9 or 1-8 then 0-9
(?:(?:\.[0-9]{1,6})?) = matches a literal '.' then 1 to 15 digits
between 0 to 9
1 to 15 digits because that is the Google "Get Location" precision
 */
  var regexLat = /^(\+|-)?(?:90(?:(?:\.0{1,15})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,15})?))$/.test(Lat);
  if (regexLat === false) {
    alert("Invalid Latitude input!");
    return false;
  }
  /*
\+|- matches an optional (?) + or - in latitude input
?:180(?:(?:\.0{1,6})? = matches 180 then a "." and 1 to 15 0's
(?:[0-9]|[1-9][0-9]|1[0-7][0-9]) = matches 0-9 or 1-9 then 0-9
or 1 followed by [0-9] then [0-9]
(?:(?:\.[0-9]{1,6})?) = matches a literal '.' then 1 to 15 digits
between 0 to 9

NOTE: Firefox automatically truncates to 15 decimals in var, so the {1,15} is unnecessary in Firefox and will always pass provided
the number before the decimal is valid
 */
  var regexLong = /^(\+|-)?(?:180(?:(?:\.0{1,15})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,15})?))$/.test(Long);
  if (regexLong === false) {
    alert("Invalid Longitude input!");
    return false;
  } else {
    return true;
  }
}

/* form validation function for search.html */
function validateSearchForm() {
  var Lat = document.getElementById("Lat").value;
  var Long = document.getElementById("Long").value;
  /* if nothing is typed in input element, it's an empty string
when Lat, Long empty, then throw window popup 
and return false */
  if (Lat == "" || Long == "") {
    alert("Please fill in all fields!");
    return false;
  }

  /* Lat/Long Regex test */
  /* 
\+|- matches an optional (?) + or - in latitude input
?:90(?:(?:\.0{1,6})? = matches 90 then a "." and 1 to 15 0's
(?:[0-9]|[1-8][0-9]) = matches 0-9 or 1-8 then 0-9
(?:(?:\.[0-9]{1,6})?) = matches a literal '.' then 1 to 15 digits
between 0 to 9
1 to 15 digits because that is the Google "Get Location" precision

NOTE: Firefox automatically truncates to 15 decimals in var, so the {1,15} is unnecessary in Firefox and will always pass provided
the number before the decimal is valid
 */
  var regexLat = /^(\+|-)?(?:90(?:(?:\.0{1,15})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,15})?))$/.test(Lat);
  if (regexLat === false) {
    alert("Invalid Latitude input!");
    return false;
  }
  /*
\+|- matches an optional (?) + or - in latitude input
?:180(?:(?:\.0{1,6})? = matches 180 then a "." and 1 to 15 0's
(?:[0-9]|[1-9][0-9]|1[0-7][0-9]) = matches 0-9 or 1-9 then 0-9
or 1 followed by [0-9] then [0-9]
(?:(?:\.[0-9]{1,6})?) = matches a literal '.' then 1 to 15 digits
between 0 to 9

NOTE: Firefox automatically truncates to 15 decimals in var, so the {1,15} is unnecessary in Firefox and will always pass provided
the number before the decimal is valid
 */
  var regexLong = /^(\+|-)?(?:180(?:(?:\.0{1,15})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,15})?))$/.test(Long);
  if (regexLong === false) {
    alert("Invalid Longitude input!");
    return false;
  }

  /*check if 1 is checked for Distance (5, 10, 20, 50)*/
      if(document.getElementById("loc5").checked === true)
      {
        return true;
      }
  else if(
    document.getElementById("loc1").checked === false &&
    document.getElementById("loc2").checked === false &&
    document.getElementById("loc3").checked === false &&
    document.getElementById("loc4").checked === false
  ) {
    alert("You must select a distance!");
    return false;
  } else {
    return true;
  }
}

/*global object array of parking objects
* access like parkingObjArray[index].(name/price/rating/lat/long)
* */
var parkingObjArray = [];

function pushArray(a,b,c,d,e,f){
    var parkingObj = {id:a, name:b, price:c, rating:d, lat:e, long:f};
  parkingObjArray.push(parkingObj);
}

//helper function
function printArray(){
 window.alert(parkingObjArray[0].name);
}

//helper function, uses PHP from results to append to these globals to make use in initMapSearch() location
var userLat;
var userLong;
function getUserLoc(lat,long){
    userLat = lat;
    userLong = long;
}
//global for dynamic marker allocation
var infoWindow;

function bindInfoWindow(marker, map, infowindow, content) {
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(content);
        infowindow.open(map, marker);
    });
}

function initMapSearch() {
  //instantiated within the function because you cannot do so globally "google not found" error
    infoWindow = new google.maps.InfoWindow();


  //type casting the string inputs from PHP to a number variable to pass into Maps function

  var a = Number(userLat);
  var b = Number(userLong);
    var location = { lat: a, lng: b };
    /* Map is a function, passing in getElementById map as parameter. i am also specifying a zoom for readability and usability
    * the zoom of 11 gives a decent view of the Hamilton area - my test location was from West Mountain and in order to see
    * the downtown parking spot markers, 11 seemed to be the best - please see README for further comments on design choice
    * */
    var map = new google.maps.Map(document.getElementById("map"), {
        /* zoom to get the downtown Hamilton area */
        zoom: 11,
        center: location
    });
    //populate map markers and content
    /*instantiating the variables for the label information when you click marker.  also including info and link to page for more info*/
    for(i=0; i<parkingObjArray.length; i++){
        var hrefstring = "parking.php?id="+parkingObjArray[i].id;
        var url = "<a href="+hrefstring+">more information</a>";
    var contentIndex = '<h1>'+ parkingObjArray[i].name+ '</h1><p>Price: $' + parkingObjArray[i].price + '/hr <br /> Rating: '+parkingObjArray[i].rating+'% <br>' + url + '<br /> </p>';
        var label = new google.maps.InfoWindow({
            content: contentIndex
        });
        var templat = Number(parkingObjArray[i].lat);
        var templong = Number(parkingObjArray[i].long);
        /* hardcoding market lat/long coords as vars to be passed */
        var loc = { lat: templat, lng:templong };
        /* instantiating markers */
        var marker = new google.maps.Marker({
            position: loc,
            map: map,
            title: parkingObjArray[i].name
        });
        /* label functionality when you click marker, will call open function */
        bindInfoWindow(marker,map,infoWindow,contentIndex);

    }
}


function initMapSingle() {
    //type casting the string inputs from PHP to a number variable to pass into Maps function
    var a = Number(userLat);
    var b = Number(userLong);
    var location = { lat: a, lng: b };
  /* Map is a function, passing in getElementById map as parameter. i am also specifying a zoom for readability and usability */
  var map = new google.maps.Map(document.getElementById("map"), {
    /* zoom to get the close to City Wide */
    zoom: 18,
    center: location
  });

    var contentIndex = '<h1>'+ parkingObjArray[0].name+ '</h1><p>Price: $' + parkingObjArray[0].price + '/hr <br /> Rating: '+parkingObjArray[0].rating+'% <br /></p>';
    var label = new google.maps.InfoWindow({
        content: contentIndex
    });
    var templat = Number(parkingObjArray[0].lat);
    var templong = Number(parkingObjArray[0].long);
    /* hardcoding market lat/long coords as vars to be passed */
    var loc = { lat: templat, lng:templong };
    /* instantiating markers */
    var marker = new google.maps.Marker({
        position: loc,
        map: map,
        title: parkingObjArray[0].name
    });

  /*label functionality when you click marker, will call open function */
  marker.addListener("click", function() {
    label.open(map, marker);
  });
}
