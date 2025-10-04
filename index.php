<?php
include 'api.php';

$client = new APIClient();
$articles = $client->get_articles(); 

$locale = $_GET['tz'] ?? "UTC";
?>

<html>
  <head>
    <title>Plochevina</title>
    <link rel="stylesheet" href="styles.css" />
    <script>
      (function() {
        const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
        if (!window.location.search.includes("tz=")) {
          const newUrl = window.location.pathname + "?tz=" + encodeURIComponent(tz);
          window.location.replace(newUrl);
        }
      })();
    </script>
  </head>

  <body>
    <div class="box header">
      <!--<h1 class="title">Plochevina</h1>-->
      <pre>
__________.__                .__                .__               
\______   \  |   ____   ____ |  |__   _______  _|__| ____ _____   
 |     ___/  |  /  _ \_/ ___\|  |  \_/ __ \  \/ /  |/    \\__  \  
 |    |   |  |_(  <_> )  \___|   Y  \  ___/\   /|  |   |  \/ __ \_
 |____|   |____/\____/ \___  >___|  /\___  >\_/ |__|___|  (____  /
                           \/     \/     \/             \/     \/ 
      </pre> 
      <p class="desc">Because apparently nobody has enough work or a life.</p>
      <p class="blog-by">a blog by mišo pišo</p>
    </div>

    <br />

    <div class="box">
      <h2 class="section-title">Articles</h2>
    </div>

    <br />

    <?php foreach ($articles["data"] as $article): ?>
      <a href="<?= "article.php?id=" . $article["documentId"] ?>" class="box article-container">
        <div class="article-info">
          <img src="<?= $client->base_url . $article["cover"]["formats"]["thumbnail"]["url"] ?>" />

          <div class="article-preview">
            <h3 class="article-title">
              <?= $article["title"] ?>
            </h3>
            <p>
              <?= $article["description"] ?>
            </p>
          </div>
        </div>

        <p>
          <?= formatIsoDate($article["publishedAt"], $locale); ?>
        </p>
      </a>

      <br />
    <?php endforeach; ?>

    <pre>
      <?php print_r($articles["data"]); ?>
    </pre>
  </body>
</html>

