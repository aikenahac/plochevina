<?php

class APIClient {
  public $base_url = "http://localhost:1337";

  function get_articles() {
    $endpoint = $this->base_url . "/api/articles?populate=cover";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      throw new Exception("cURL Error: " . curl_error($ch));
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception("JSON Decode Error: " . json_last_error_msg());
    }

    return $data;
  }

  function get_article(string $id) {
    $endpoint = $this->base_url . "/api/articles/" . $id . "?populate[author][fields]=*&populate[cover][fields][0]=formats&populate[blocks][on][shared.media][populate]=*&populate[blocks][on][shared.quote][populate]=*&populate[blocks][on][shared.rich-text][populate]=*&pagination[pageSize]=1000&pagination[page]=1&status=published";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
      throw new Exception("cURL Error: " . curl_error($ch));
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new Exception("JSON Decode Error: " . json_last_error_msg());
    }

    return $data;
  }

}

function formatIsoDate(string $isoDate, string $tz): string {
  $dt = new DateTime($isoDate);
  $dt->setTimezone(new DateTimeZone($tz));

  return $dt->format('j. n. Y @ H:i');
}

?>
