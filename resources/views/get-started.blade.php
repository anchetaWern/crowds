@extends('layouts.app')

@section('content')
<div class="container">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=767433760052841&autoLogAppEvents=1"></script>

    <div class="row justify-content-center">
        <div class="col-md-8">
          <h5>Getting Started</h5>
          <div class="alert alert-info">
              Watch the following videos to learn how to setup your Crowds account and start creating requests.
              Turn on video captions for more details. Once you're done, click the button below to create your own account.
              <div class="mt-1">
                  <a href="/register" class="btn btn-sm btn-primary">Create account</a>
              </div>
          </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4 text-center">
            <div class="fb-post" data-href="https://www.facebook.com/109008434076156/videos/573208489965647" data-width="300" data-show-text="false">
                <blockquote cite="https://developers.facebook.com/109008434076156/videos/573208489965647/" class="fb-xfbml-parse-ignore"><p>This video will show you how you can create your own Crowds account.
                1. Enter your name, email, and password or you can...</p>Posted by <a href="https://www.facebook.com/Crowds-Bayanihan-App-109008434076156/">Crowds Bayanihan App</a> on&nbsp;<a href="https://developers.facebook.com/109008434076156/videos/573208489965647/">Friday, April 10, 2020</a>
                </blockquote>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=123635852613414&amp;id=109008434076156" data-width="300" data-show-text="false"><blockquote cite="https://developers.facebook.com/permalink.php?story_fbid=123635852613414&amp;id=109008434076156" class="fb-xfbml-parse-ignore"><p>This video will show you how you can make a request and submit bids using the Crowds app.

            Step 1:  Requester logs...</p>Posted by <a href="https://www.facebook.com/Crowds-Bayanihan-App-109008434076156/">Crowds Bayanihan App</a> on&nbsp;<a href="https://developers.facebook.com/permalink.php?story_fbid=123635852613414&amp;id=109008434076156">Friday, April 10, 2020</a></blockquote>
            </div>
        </div>
    </div>
</div>
@endsection
