<?php 
  header('Access-Control-Allow-Origin: *'); 
  header('Access-Control-Allow-Credentials: true'); 
  header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); 
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization'); 
  header('Content-Type: application/json; charset=UTF-8'); 

  include "db_config.php"; 
  $postjson = json_decode(file_get_contents('php://input'), true); 
  $aksi=strip_tags($postjson['aksi']); 
  $data    = array(); 

  switch($aksi) {
    case "add_register": 
      $pilih = filter_var($postjson['pilih'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW); 
      $id_game = filter_var($postjson['id_game'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW); 
      $nama = filter_var($postjson['nama'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW); 
      $email = filter_var($postjson['email'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW); 
      $nohp = filter_var($postjson['nohp'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
      $nominal = filter_var($postjson['nominal'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
      $metode = filter_var($postjson['metode'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
      
      try { 
        $sql = "INSERT INTO `game` (pilih,id_game,nama,email,nohp,nominal,metode) VALUES (:pilih, :id_game, :nama, :email, :nohp, :nominal, :metode)"; 
        $stmt    = $pdo->prepare($sql); 
        $stmt->bindParam(':pilih', $pilih, PDO::PARAM_STR); 
        $stmt->bindParam(':id_game', $id_game, PDO::PARAM_STR); 
        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR); 
        $stmt->bindParam(':email', $email, PDO::PARAM_STR); 
        $stmt->bindParam(':nohp', $nohp, PDO::PARAM_STR);
        $stmt->bindParam(':nominal', $nominal, PDO::PARAM_STR); 
        $stmt->bindParam(':metode', $metode, PDO::PARAM_STR);
        $stmt->execute(); 
        if($sql) $result = json_encode(array('success' =>true)); 
        else $result = json_encode(array('success' => false, 'msg'=>'error , please try again')); 
        echo $result; 
      } 
      catch(PDOException $e) { 
        echo $e->getMessage(); 
      }     
      break; 

    case "getdata": 
      $limit = filter_var($postjson['limit'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW); 
      $start = filter_var($postjson['start'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);       
      
      try { 
        $sql = "SELECT * FROM `game` ORDER BY `id_trans` DESC LIMIT :start,:limit"; 
        $stmt = $pdo->prepare($sql); 
        $stmt->bindParam(':start', $start, PDO::PARAM_STR); 
        $stmt->bindParam(':limit', $limit, PDO::PARAM_STR);           
        $stmt->execute(); 
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);           
        foreach($rows as $row){             
          $data[] = array( 
            'id_trans' => $row['id_trans'], 
            'pilih' => $row['pilih'], 
            'id_game' => $row['id_game'], 
            'nama' => $row['nama'], 
            'email' => $row['email'], 
            'nohp' => $row['nohp'],
            'nominal' => $row['nominal'],
            'metode' => $row['metode'] 
          );            
        } 
        if($stmt) $result = json_encode(array('success'=>true, 'result'=>$data)); 
        else $result = json_encode(array('success'=>false)); 
        echo $result; 
      }  
      catch(PDOException $e) { 
        echo $e->getMessage(); 
      }          
      break; 
  }
?>