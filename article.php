<?php
include 'Parsedown.php';
include 'api.php';

$parsedown = new Parsedown();

$client = new APIClient();
$article_id = $_GET['id'];

if (empty($article_id)) {
  header("Location: /");
  exit;
}

$article_raw = $client->get_article($article_id);
$article = $article_raw["data"];

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
          const newUrl = window.location.pathname + "?tz=" + encodeURIComponent(tz) + "&" + window.location.search.substr(1);
          window.location.replace(newUrl);
        }
      })();
    </script>
  </head>

  <body>
    <div class="box header">
      <a href="/" style="text-decoration: none;"><pre>
__________.__                .__                .__               
\______   \  |   ____   ____ |  |__   _______  _|__| ____ _____   
 |     ___/  |  /  _ \_/ ___\|  |  \_/ __ \  \/ /  |/    \\__  \  
 |    |   |  |_(  <_> )  \___|   Y  \  ___/\   /|  |   |  \/ __ \_
 |____|   |____/\____/ \___  >___|  /\___  >\_/ |__|___|  (____  /
                           \/     \/     \/             \/     \/ 
      </pre> </a>
      <p class="desc">Because apparently nobody has enough work or a life.</p>
      <p class="blog-by">a blog by mišo pišo</p>
    </div>

    <br />

    <div class="box" style="margin-bottom: 4px;">
      <img src="<?= $client->base_url . $article["cover"]["formats"]["small"]["url"] ?>" />
    </div>

    <div class="box">
      <h2 class="section-title"> 
        <?= $article["title"] ?>
      </h2>
      <p style="font-style: italic;">
        Author: <?= $article["author"]["name"] ?> - <?= formatIsoDate($article["publishedAt"], $locale); ?>
      </p>
    </div>

    <div class="box" style="margin-top: 4px;">
      <p>
        <?= $article["description"] ?>
      </p>
    </div>
    
    <br />

    <?php foreach($article["blocks"] as $block): ?>
      <div class="box article-block">
        <?php
        if ($block["__component"] === "shared.rich-text") {
          echo $parsedown->text($block["body"]);
        } else if ($block["__component"] === "shared.media") {
          echo "<img class='block-image' src='" . $client->base_url . $block["file"]["formats"]["medium"]["url"] . "' />";
        } else if ($block["__component"] === "shared.quote") {
          echo "<h3 class='block-title'>";
          echo $block["title"];
          echo "</h3>";
          echo "<q>" . $block["body"] . "</q>";
        }
        ?>
      </div>
      <br />
    <?php endforeach; ?>


    <br />

    <pre style="width: 50vw; text-wrap: wrap;">
      <?php print_r($article); ?>
    </pre>
  </body>
</html>


