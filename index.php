<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<style>
body { font-family: monospace; font-size: 20px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 28px; } 
</style>
<title>Generate Password</title>
</head>

<body>
<?php
  // LETTERS
  //$separators = array("-", "_", ".", ",", "%", "|", "@", "!", "\\", "/");
  $base = '/var/www/html/yapg/';
  $separators = array("-");
  $len = 32;
  for($groupLen=5; $groupLen>3; $groupLen--){
    $maxGroups = 4;
   
    echo "[" . $maxGroups . "x" . $groupLen . " letters]: ";
    
    $b64 = base64_encode(bin2hex(openssl_random_pseudo_bytes($len)));
    $rand = array_rand($separators, 1);

    for ($groups=1; $groups<=$maxGroups; $groups++){
      echo substr($b64, 10*$groups, $groupLen);
      if ($groups !== $maxGroups) {
        //echo $separators[$rand];
        echo $separators[array_rand($separators, 1)];
      }
    }
    echo PHP_EOL;
    echo "<br/><br/>";
    echo PHP_EOL;
  }

  // WORDS
  for ($groupLen=2; $groupLen<=3; $groupLen++){
  $maxGroups = $groupLen;
  echo "[" . $maxGroups . " words]: ";
  $fh = fopen($base . "words.txt", "r");
  if ($fh){
    $fileSize = filesize($base . "words.txt");

    $hasDigit = 0;
    for($groups=1; $groups<=$maxGroups; $groups++){
      rewind($fh);
      $num = rand(0, $fileSize-1);
      do {
        fseek($fh, $num++);
      }while(fread($fh,1) !== PHP_EOL);    
      $word = trim(fgets($fh));

      if ($hasDigit == 0 && rand(0,1) == 0){
        $digit = rand (0, 9);
        echo $digit;
        echo $separators[array_rand($separators, 1)];
        $hasDigit++;
      }

      if ($word) {
        echo ucwords($word);
        if ($groups !== $maxGroups) {
          echo $separators[array_rand($separators, 1)];
        }
      }
    }
    if ($hasDigit == 0){
      echo $separators[array_rand($separators, 1)];
      $digit = rand (0, 9);
      echo $digit;
    }
    fclose($fh);
  }
  echo PHP_EOL;
  echo "<br/><br/>";
  echo PHP_EOL;
  }

  //UUID
  printf('[UUID]: %s-%s-%04x-%04x-%s',
  bin2hex(openssl_random_pseudo_bytes(4)),
  bin2hex(openssl_random_pseudo_bytes(2)),
  hexdec(bin2hex(openssl_random_pseudo_bytes(2))) & 0x0fff | 0x4000,
  hexdec(bin2hex(openssl_random_pseudo_bytes(2))) & 0x3fff | 0x8000,
  bin2hex(openssl_random_pseudo_bytes(6))
  );
    echo PHP_EOL;
    echo "<br/><br/>";
    echo PHP_EOL;

?>
</body>
</html>


