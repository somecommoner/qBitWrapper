<?php

namespace qBitWrapper;

class qBittorrent {

  function Add($id, $dir) {

    $ch = curl_init();

    $file = "/app/tmp/$id.torrent";

    $fields = [
      'name' => new \CurlFile($file, 'application/x-bittorrent', "$id.torrent"),
      'root_folder' => 'false',
      'savepath' => $dir.$id."/"

  ];

    curl_setopt($ch, CURLOPT_URL,"http://qbit:8080/api/v2/torrents/add");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_INFILESIZE, strlen(file_get_contents($file)));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: multipart/form-data;'
    ));

    $server_output = curl_exec($ch);

    curl_close ($ch);
    unlink($file) or die("couldn't delete file $id.torrent");
  }


  function Check($hash) {
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://qbit:8080/api/v2/torrents/info?hashes=$hash");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);



    return json_decode($server_output,true)['0'];

  }

  function Torrents() {
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://qbit:8080/api/v2/torrents/info");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);



    return json_decode($server_output,true);

  }

  function TorrentProperties($hash) {
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://qbit:8080/api/v2/torrents/properties?hash=".$hash);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);



    return json_decode($server_output,true);

  }

  function Delete($hash) {
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"http://qbit:8080/api/v2/torrents/delete?deleteFiles=true&hashes=".$hash);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close ($ch);

  }

}

?>