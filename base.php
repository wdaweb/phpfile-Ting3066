<?php
$dsn="mysql:host=localhost;dbname=file;charset=utf8";
$pdo=new PDO($dsn,'root','');

date_default_timezone_set("Asia/Taipei");
session_start();


$awardStr=['頭','二','三','四','五','六'];


function find($table,$id){
  global $pdo;
  if(is_array($id)){

    foreach($id as $key => $value){
      $tmp[]=sprintf("`%s`='%s'",$key,$value);
      // $tmp[]="`".$key."`='".$value."'";
    }

    $sql="select * from $table where ".implode(" && ",$tmp);
  }else{
    $sql="select * from $table where id='$id'";
    
  }

  $row=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
  return $row;

}

//update()函式，更新資料
function update($table,$array){
  global $pdo;
  $sql="update $table set ";
  foreach($array as $key => $value){

    //如果選出的欄位名稱不是id的時候才會產生字串在set的欄位，因為id不用做更改
    if($key!='id'){
      $tmp[]=sprintf("`%s`='%s'",$key,$value);

    }
  }

  $sql=$sql.implode(",",$tmp)."where `id`='{$array['id']}'";
  echo $sql;
  $pdo->exec($sql);



}

//insert()函式，新增資料
function insert($table,$array){
  global $pdo;
  $sql="insert into $table(`".implode("`,`",array_keys($array))."`) values('".implode("','",$array)."') ";



  $pdo->exec($sql);
}

//save()函式，將update()跟insert()合併，判斷使用時機
function save($table,$array){
  
  if(isset($array['id'])){
    //update
    update($table,$array);
  }else{
    //insert
    insert($table,$array);
  }
}

function del($table,$id){
  $sql="delete * from $table where ";
  if(is_array($id)){
      foreach($id as $key => $value){
        $tmp[]=sprintf("`%s`='%s'",$key,$value);
      }

      $sql=$sql.implode(" && ",$tmp);

  }else{

      $sql=$sql." id='$id' ";


  }
  $row=$pdo->exec($sql);
  return $row;
}

function to($url){
  header("location:".$url);
}


function q($sql){
  global $pdo;
  return $pdo->query($sql)->fetchAll();
}


function all($table,...$arg){
    global $pdo;
  
    $sql="select * from $table ";
    if(isset($arg[0])){
      if(is_array($arg[0])){
        //製作會在where 號面的句子字串
        if(!empty($arg[0])){
          foreach($arg[0] as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
            // $tmp[]="`".$key."`='".$value."'";
          }
  
          $sql=$sql." where ".implode(" && ",$tmp);
        }
    
      }else{
    
          $sql=$sql.$arg[0];
    
    
      }
    }
    
    if(isset($arg[1])){
      //製作接在最後面的句子字串
      $sql=$sql.$arg[1];
  
  
    }
    echo $sql."<br>";
  
    return $pdo->query($sql)->fetchALL();
    function del($table,$id){
      $sql="delete * from $table where ";
      if(is_array($id)){
          foreach($id as $key => $value){
            $tmp[]=sprintf("`%s`='%s'",$key,$value);
          }
  
          $sql=$sql.implode(" && ",$tmp);
    
      }else{
    
          $sql=$sql." id='$id' ";
    
    
      }
      $row=$pdo->exec($sql);
      return $row;
    }
    $def=['code'=>'GD'];
    echo del('invoices',$def);
  }
  

?>