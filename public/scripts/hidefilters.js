var filtersAreHidden = true;
$("#filter").click(function () {
    if (filtersAreHidden == false) {
        $("#allfilters").addClass("hidden")
        filtersAreHidden = true;
        console.debug("filters are hidden")
    }
    else {
        $("#allfilters").removeClass("hidden")
        filtersAreHidden = false;
    }
})

var loginIsHidden = true;
$("#hideloginbutton").click(function () {
    if (loginIsHidden == false) {
        $("#hiddenlogin").addClass("hidden")
        loginIsHidden = true;
        console.debug("filters are hidden")
    }
    else {
        $("#hiddenlogin").removeClass("hidden")
        loginIsHidden = false;
    }
})
