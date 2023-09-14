<?php
if(file_exists('config.php')){
    require 'config.php';
}else{
    require_once '../config.php';
}
class News
{
    // property
    private $id;
    private $title;
    private $content;
    private $id_editor;
    private $id_category;
    private $image_tmp;
    private $image_name;
    // methods
    public function __construct($title, $content, $id_editor, $id_category, $image_tmp, $image_name,  $id="")
    {
        $this->title = $title;
        $this->content = $content;
        $this->id_editor = $id_editor;
        $this->id_category = $id_category;
        $this->image_tmp = $image_tmp;
        $this->image_name = $image_name;
        $this->id = $id;
    }
    public function addNews()
    {
        if(is_uploaded_file($this->image_tmp)){
            //rename image name 
            $this->image_name = time() . $this->image_name;
            if(move_uploaded_file($this->image_tmp, "../upload/". $this->image_name)){
                // get connection 
                global $dbh;
                // prepare query before execute 
                $sql = $dbh->prepare("INSERT INTO news(title, content, id_editor, id_category, image_name) VALUES('$this->title', '$this->content', '$this->id_editor', '$this->id_category', '$this->image_name')");
                //execute sql query 
                if($sql->execute()){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function updateNews()
    {
        if(is_uploaded_file($this->image_tmp)){
            //rename image name 
            $this->image_name = time() . $this->image_name;
            if(move_uploaded_file($this->image_tmp, "../upload/". $this->image_name)){
                // get connection 
                global $dbh;
                // prepare query before execute 
                $sql = $dbh->prepare("UPDATE news SET title='$this->title', content = '$this->content', id_editor = '$this->id_editor', id_category = '$this->id_category', image_name = '$this->image_name' WHERE  id = '$this->id'");
                // execute sql query
                if($sql->execute()){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public static function deleteNews($id)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("DELETE FROM news WHERE id = '$id' ");
        // execute sql query
        if($sql->execute()){
            return true;
        }else{
            return false;
        }
    }
    public static function retreiveNewsById($id)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT * FROM news WHERE id = '$id' ");
        // execute sql query
        $sql->execute();
        // fetch data to associative array
        $news = $sql->fetch(PDO::FETCH_ASSOC);
        return $news;
    }
    public static function retreiveNoOfNewsByEditorId($id_editor)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT id FROM news WHERE id_editor = '$id_editor' ");
        // execute sql query
        $sql->execute();
        return $sql->rowCount();
    }
    
    public static function retreiveNoOfNewsByCategoryId($id_category)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT id FROM news WHERE id_category = '$id_category' ");
        // execute sql query
        $sql->execute();
        return $sql->rowCount();
    }
    public static function retreiveAllNews()
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT * FROM news");
        // execute sql query
        $sql->execute();
        // fetch data to associative array
        $allNews = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $allNews;
    }
    
    public static function retreiveAllNewsOrderByIdDesc()
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT * FROM news ORDER BY id DESC");
        // execute sql query
        $sql->execute();
        // fetch data to associative array
        $allNews = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $allNews;
    }
    public static function retreiveAllNewsOrderByIdDescByIdCategory($id_category)
    {
        // get connection 
        global $dbh;
        // prepare query before execute
        $sql = $dbh->prepare("SELECT * FROM news WHERE id_category='$id_category' ORDER BY id DESC ");
        // execute sql query
        $sql->execute();
        // fetch data to associative array
        $allNews = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $allNews;
    }
}