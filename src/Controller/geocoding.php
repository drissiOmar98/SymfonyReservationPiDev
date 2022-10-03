<?php
namespace App\Controller;
//Reference: https://www.codeofaninja.com/2014/06/google-maps-geocoding-example-php.html
// function to geocode address, it will return false if unable to geocode address
class geocoding {
  public function geocode($address){

      // url encode the address
      $address = urlencode($address);

      // google map geocode api url
      $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyDHWtcGs715gxpECvPWPT69FZUSajsM-6w";

      // get the json response
      $resp_json = file_get_contents($url);

      // decode the json
      $resp = json_decode($resp_json, true);

      // response status will be 'OK', if able to geocode given address
      if($resp['status']=='OK'){

          // get the important data
          $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
          $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
          $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";

          // verify if data is complete
          if($lati && $longi && $formatted_address){

              // put the data in the array
              $data_arr = array();

              array_push(
                  $data_arr,
                      $lati,
                      $longi,
                      $formatted_address
                  );
              return $data_arr;
          }else{
              return false;
          }
      }
      else{
          echo "<strong>ERROR: {$resp['status']}</strong>";
          return false;
      }
  }

  //function for changing marker
  public function changeMarker($selectIcon, $selectColor){
    switch ($selectIcon) {
      case '1':
        switch ($selectColor) {
          case '1':
            $icon = 'https://i.imgur.com/U4URqbu.png';
            break;
          case '2':
            $icon = 'https://i.imgur.com/wb0lHyI.png';
            break;
          case '3':
            $icon = 'https://i.imgur.com/zOiSVPG.png';
            break;
          default:
            break;}
        break;

      case '2':
          switch ($selectColor) {
            case '1':
              $icon = 'https://i.imgur.com/ZZnS5ea.png';
              break;
            case '2':
              $icon = 'https://i.imgur.com/8KcZh0r.png';
              break;
            case '3':
              $icon = 'https://i.imgur.com/RReaikm.png';
              break;
            default:
              break;}
          break;

      case '3':
          switch ($selectColor) {
            case '1':
              $icon = 'https://i.imgur.com/9e5hg6X.png';
              break;
            case '2':
              $icon = 'https://i.imgur.com/1pfNYx2.png';
              break;
            case '3':
              $icon = 'https://i.imgur.com/VaLD4a5.png';
              break;
            default:
              break;}
          break;
      default:
        # code...
        break;
    }

    return $icon;
  }

  //function for changing travel mode
  public function travelMode($selectTravel){
    switch ($selectTravel) {
      case '1':
        $mode = 'DRIVING';
        break;
      case '2':
        $mode = 'WALKING';
        break;
      case '3':
        $mode = 'BICYCLING';
        break;
      case '4':
        $mode = 'TRANSIT';
        break;
      default:
        break;
    }

    return $mode;
  }
}
?>
