<?php
function get_CURL($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result, true);
}

// -------------------- YOUTUBE SECTION --------------------
$youtubeData = get_CURL('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=UChEPJjic7-LWF1wJTXKnOLg&key=AIzaSyDL5XfafKYQzBWf3yYaWlCj1bfwbK8HTeA');

if (isset($youtubeData['items'][0])) {
    $youtubeProfilepic = $youtubeData['items'][0]['snippet']['thumbnails']['medium']['url'];
    $channelName = $youtubeData['items'][0]['snippet']['title'];
    $subscriber = $youtubeData['items'][0]['statistics']['subscriberCount'];
} else {
    $youtubeProfilepic = 'img/default.png';
    $channelName = 'Channel Not Found';
    $subscriber = '0';
}

// -------------------- LATEST YOUTUBE VIDEO --------------------
$urlLatestVideo = 'https://www.googleapis.com/youtube/v3/search?key=AIzaSyBqFGD13a1ZbU9wmhZSjDZxtoHPgBByTcQ&channelId=UChEPJjic7-LWF1wJTXKnOLg&maxResults=1&order=date&part=snippet';
$latestVideoData = get_CURL($urlLatestVideo);
$latestVideoId = $latestVideoData['items'][0]['id']['videoId'] ?? 'dQw4w9WgXcQ';

// -------------------- INSTAGRAM SECTION --------------------
$accessToken = "IGAAWqWhvkJrFBZAE1ZAVEh4NUNjWjlGNUFmQXZALSkVzQ1hlTld1SkdXVGNxUFREOHVhN2QwdDJTcGRTcUwxZAXFDdGx4SnpTejJFdGlzbnpTWDhMR0s1ZA1ZA6U3lOeE10SmtBWkN4M2c1RGU4bXh2UDBVRFM0cndVTkRBNkRndDNEZAwZDZD";

$instagramData = get_CURL("https://graph.instagram.com/me?fields=id,username,profile_picture_url,followers_count&access_token={$accessToken}");

$usernameIG = $instagramData['username'] ?? 'Unknown';
$profilePictureIG = $instagramData['profile_picture_url'] ?? 'img/default.png';
$followersCountIG = $instagramData['followers_count'] ?? '0';

$mediaData = get_CURL("https://graph.instagram.com/me/media?fields=id,media_type,media_url,thumbnail_url,caption&access_token={$accessToken}");

$photos = [];
if (isset($mediaData['data']) && is_array($mediaData['data'])) {
    foreach ($mediaData['data'] as $media) {
        if (in_array($media['media_type'], ['IMAGE', 'CAROUSEL_ALBUM']) && isset($media['media_url'])) {
            $photos[] = $media['media_url'];
        } elseif ($media['media_type'] === 'VIDEO' && isset($media['thumbnail_url'])) {
            $photos[] = $media['thumbnail_url'];
        }
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title>My Portfolio</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#home">Shintarizki</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#home">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#portfolio">Portfolio</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <div class="jumbotron" id="home">
      <div class="container">
        <div class="text-center">
          <img src="img/profile1.png" class="rounded-circle img-thumbnail">
          <h1 class="display-4">SHINTA RIZKI AYU UTAMI</h1>
          <h3 class="lead">Lecturer | Programmer | Youtuber</h3>
        </div>
      </div>
    </div>


    <!-- About -->
    <section class="about" id="about">
      <div class="container">
        <div class="row mb-4">
          <div class="col text-center">
            <h2>About</h2>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-4">
            <p>"Kita takkan berlama-lama di puncak, jadi tidak perlu bercepat-cepat di jalur. Santai saja. Pelan-pelan tapi terus berjalan, akan lebih baik dibandingkan terburu-buru tapi banyak berhenti".</p>
          </div>
          <div class="col-md-4">
            <p>"Gunung bukan tempat untuk menunjukkan siapa yang paling kuat, tapi tempat untuk belajar saling menguatkan".</p>
          </div>
        </div>
      </div>
    </section>

  <section class="social bg-light" id="social">
  <div class="container">
    <!-- Judul -->
    <div class="row pt-4 mb-4">
      <div class="col text-center">
        <h2>Social Media</h2>
      </div>
    </div>

    <!-- YouTube Saja -->
    <div class="row justify-content-center">
      <div class="col-md-6 mb-4">
        <div class="row mb-3">
          <div class="col-md-4 text-center">
            <img src="<?= $youtubeProfilepic; ?>" width="100" class="rounded-circle img-thumbnail" alt="YouTube Profile Picture">
          </div>
          <div class="col-md-8 d-flex flex-column justify-content-center">
            <h5><?= $channelName; ?></h5>
            <p><?= $subscriber; ?> Subscribers</p>
            <div class="g-ytsubscribe" data-channelid="UChEPJjic7-LWF1wJTXKnOLg" data-layout="default" data-count="default"></div>
          </div>
        </div>
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" 
                  src="https://www.youtube.com/embed/<?= $latestVideoId ?>?rel=0" 
                  allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="social bg-light" id="social">
  <div class="container">
    <div class="row pt-4 mb-4">
      <div class="col text-center">
        <h2>Social Media</h2>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-6 mb-4">
        <div class="row mb-3">
          <div class="col-md-4 text-center">
            <img src="<?= $profilePictureIG; ?>" width="100" class="rounded-circle img-thumbnail" alt="Instagram Profile Picture">
          </div>
          <div class="col-md-8 d-flex flex-column justify-content-center">
            <h5><?= $usernameIG; ?></h5>
            <p><?= $followersCountIG; ?> Followers</p>
          </div>
        </div>
        <div class="row mt-3 pb-3">
          <div class="col d-flex flex-wrap gap-2">
            <?php foreach ($photos as $photo) : ?>
              <div class="ig-thumbnail" style="width: 100px; height: 100px; overflow: hidden; border-radius: 10px;">
                <img src="<?= $photo; ?>" class="img-fluid" alt="Instagram Photo" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

   <!-- Portfolio -->
    <section class="portfolio bg-light" id="portfolio">
      <div class="container">
        <div class="row pt-4 mb-4">
          <div class="col text-center">
            <h2>Portfolio</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md mb-4">
            <div class="card">
              <img class="card-img-top" src="img/thumbs/1.png" alt="Card image cap">
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>

          <div class="col-md mb-4">
            <div class="card">
              <img class="card-img-top" src="img/thumbs/2.png" alt="Card image cap">
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>

          <div class="col-md mb-4">
            <div class="card">
              <img class="card-img-top" src="img/thumbs/3.png" alt="Card image cap">
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>   
        </div>

        <div class="row">
          <div class="col-md mb-4">
            <div class="card">
              <img class="card-img-top" src="img/thumbs/4.png" alt="Card image cap">
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div> 
          <div class="col-md mb-4">
            <div class="card">
              <img class="card-img-top" src="img/thumbs/5.png" alt="Card image cap">
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.
                </p>
              </div>
            </div>
          </div>

          <div class="col-md mb-4">
            <div class="card">
              <img class="card-img-top" src="img/thumbs/6.png" alt="Card image cap">
              <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Contact -->
    <section class="contact bg-light" id="contact">
      <div class="container">
        <div class="row pt-4 mb-4">
          <div class="col text-center">
            <h2>Contact</h2>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-4">
            <div class="card bg-primary text-white mb-4 text-center">
              <div class="card-body">
                <h5 class="card-title">Contact Me</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            
            <ul class="list-group mb-4">
              <li class="list-group-item"><h3>Location</h3></li>
              <li class="list-group-item">My Office</li>
              <li class="list-group-item">Jl. Setiabudhi No. 193, Bandung</li>
              <li class="list-group-item">West Java, Indonesia</li>
            </ul>
          </div>

          <div class="col-lg-6">
            
            <form>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone">
              </div>
              <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" rows="3"></textarea>
              </div>
              <div class="form-group">
                <button type="button" class="btn btn-primary">Send Message</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </section>


    <!-- footer -->
    <footer class="bg-dark text-white mt-5">
      <div class="container">
        <div class="row">
          <div class="col text-center">
            <p>Copyright &copy; 2018.</p>
          </div>
        </div>
      </div>
    </footer>







    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
  </body>
</html>