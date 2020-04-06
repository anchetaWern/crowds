(function(d, s, id) {
    var js,
        fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
})(document, "script", "facebook-jssdk");

window.fbAsyncInit = function() {
    FB.init({
        appId: process.env.MIX_FACEBOOK_APP_ID,
        cookie: true,
        xfbml: true,
        version: "v6.0",
    });

    FB.AppEvents.logPageView();
};

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        if (response.status === "connected") {
            $("#_fb_access_token").val(response.authResponse.accessToken);
            $("#facebook-login-form").trigger("submit");
        }
    });
}

window.checkLoginState = checkLoginState;