<?php
include 'api.php';

$client = new APIClient();
$articles = $client->get_articles(); 

$locale = $_GET['tz'] ?? "Europe/Ljubljana";
?>

<html>
  <head>
    <title>Plocheveena</title>
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
      <pre>
__________.__                .__                                             
\______   \  |   ____   ____ |  |__   _______  __ ____   ____   ____ _____   
 |     ___/  |  /  _ \_/ ___\|  |  \_/ __ \  \/ // __ \_/ __ \ /    \\__  \  
 |    |   |  |_(  <_> )  \___|   Y  \  ___/\   /\  ___/\  ___/|   |  \/ __ \_
 |____|   |____/\____/ \___  >___|  /\___  >\_/  \___  >\___  >___|  (____  /
                           \/     \/     \/          \/     \/     \/     \/ 

      </pre> 
      <p class="desc">Because apparently nobody has enough work or a life.</p>
      <p class="blog-by">a blog by mišo & kaja</p>
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

    <!--<pre style="width: 50vw; text-wrap: wrap;">
      <?php #print_r($articles); ?>
    </pre>-->
  </body>
</html>

