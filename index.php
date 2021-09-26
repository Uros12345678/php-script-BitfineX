<!-- Bootstrap5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<?php

function bitfinex_query($path, array $req = Array()) {
  global $config;

  // API settings, add your Key and Secret at here
  $key = "OqEbN4XMjtL877rRZvVtiwitxfJRlRUVGp6UsO8J9gN";
  $secret = "kiBKqZJsK70fk9rCuxjHcXraFUr9gLyVgxPAG38e0yE";

  // generate a nonce to avoid problems with 32bits systems
  $mt = explode(' ', microtime());
  $req['request'] = "/v2" . $path;
  $req['nonce'] = $mt[1].substr($mt[0], 2, 6);

  // generate the POST data string
  $post_data = base64_encode(json_encode($req));
  $sign = hash_hmac('sha384', $post_data, $secret);

  // generate the extra headers
  $headers = array(
    'X-BFX-APIKEY: ' . $key,
    'X-BFX-PAYLOAD: ' . $post_data,
    'X-BFX-SIGNATURE: ' . $sign,
  );

  // curl handle (initialize if required)
  static $ch = null;
  if (is_null($ch)) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; Bter PHP bot; '.php_uname('a').'; PHP/'.phpversion().')');
  }

  // book-data
  $fgc = json_decode(file_get_contents("https://api.bitfinex.com/v1/book/BTCUSD"), true);
  $bids = $fgc["bids"];

  $details1 = $bids["0"]["price"];
  $details2 = $bids["3"]["price"];
  $details3 = $bids["1"]["price"];
  $details4 = $bids["2"]["price"];
  $details5 = $bids["4"]["price"];

  $detailsa1 = $bids["0"]["amount"];
  $detailsa2 = $bids["3"]["amount"];
  $detailsa3 = $bids["1"]["amount"];
  $detailsa4 = $bids["2"]["amount"];
  $detailsa5 = $bids["4"]["amount"]; 
        
  $detailst1 = $bids["0"]["timestamp"];
  $detailst2 = $bids["3"]["timestamp"];
  $detailst3 = $bids["1"]["timestamp"];
  $detailst4 = $bids["2"]["timestamp"];
  $detailst5 = $bids["4"]["timestamp"];

  
  // symbols-data
  $fgc = json_decode(file_get_contents("https://api.bitfinex.com/v1/symbols"), true);
  $bids = $fgc["0"];   
  $bidsss = $fgc["3"];
  $bidsss3 = $fgc["1"];
  $bidsss4 = $fgc["2"];
  $bidsss5 = $fgc["4"];


  // symbols_details-data
  $fgc = json_decode(file_get_contents("https://api.bitfinex.com/v1/symbols_details"), true);
  $sy = $fgc["0"]["initial_margin"];
  $sy1 = $fgc["3"]["initial_margin"];
  $sy2 = $fgc["1"]["initial_margin"];
  $sy3 = $fgc["2"]["initial_margin"];
  $sy4 = $fgc["4"]["initial_margin"];

  $max = $fgc["0"]["maximum_order_size"];
  $max1 = $fgc["3"]["maximum_order_size"];
  $max2 = $fgc["1"]["maximum_order_size"];
  $max3 = $fgc["2"]["maximum_order_size"];
  $max4 = $fgc["4"]["maximum_order_size"];

  $min = $fgc["0"]["minimum_order_size"];
  $min1 = $fgc["3"]["minimum_order_size"];
  $min2 = $fgc["1"]["minimum_order_size"];
  $min3 = $fgc["2"]["minimum_order_size"];
  $min4 = $fgc["4"]["minimum_order_size"];


  // printing data in a tabel
  echo '<div class="container mt-5"><h2 class="text-center">BitfineX script</h2><div class="row mt-3"><a href="index.php">Home</a></div><table class="table mt-3"><thead><tr class="table-info"><th scope="col">Name</th><th scope="col">Last</th><th scope="col">Change</th><th scope="col">Change Percent</th><th scope="col">High</th><th scope="col">Low</th><th scope="col">Min Order</th></tr></thead><tbody>';
       
    echo '<tr><th scope="row">' . $bids . '</th>';
    echo '<td>' . $details1 . '</td>';
    echo '<td>' . $detailsa1 . '%</td>';
    echo '<td>' . $detailst1 . '</td>';
    echo '<td>' . $max . '</td>'; 
    echo '<td>' . $sy . '</td>'; 
    echo '<td>' . $min . '</td></tr>';  

    echo '<tr><th scope="row">' . $bidsss . '</th>';
    echo '<td>' . $details2 . '</td>';
    echo '<td>' . $detailsa2 . ' %</td>';
    echo '<td>' . $detailst2 . '</td>';
    echo '<td>' . $max1 . '</td>';
    echo '<td>' . $sy1 . '</td>';
    echo '<td>' . $min1 . '</td></tr>';  

    echo '<tr><th scope="row">' . $bidsss3 . '</th>';
    echo '<td>' . $details3 . '</td>';
    echo '<td>' . $detailsa3 . ' %</td>';
    echo '<td>' . $detailst3 . '</td>'; 
    echo '<td>' . $max2 . '</td>';
    echo '<td>' . $sy2 . '</td>';
    echo '<td>' . $min2 . '</td></tr>';  

    echo '<tr><th scope="row">' . $bidsss4 . '</th>';
    echo '<td>' . $details4 . '</td>';
    echo '<td>' . $detailsa4 . ' %</td>';
    echo '<td>' . $detailst4 . '</td>'; 
    echo '<td>' . $max3 . '</td>';
    echo '<td>' . $sy3 . '</td>';
    echo '<td>' . $min3 . '</td></tr>';  

    echo '<tr><th scope="row">' . $bidsss5 . '</th>';
    echo '<td>' . $details5 . '</td>';
    echo '<td>' . $detailsa5 . ' %</td>';
    echo '<td>' . $detailst5 . '</td>';
    echo '<td>' . $max4 . '</td>';
    echo '<td>' . $sy4 . '</td>';
    echo '<td>' . $min4 . '</td></tr>';  
        
  echo '</td></tr></tbody></table></div>';
}

// call all functions
$api_name = '/book/BTCUSD';
$api_name = '/symbols';
$api_name = '/symbols_details';
$orderbook = bitfinex_query($api_name);
?>