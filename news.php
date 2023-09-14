<?php
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <?php
        if(isset($_GET['id_news'])){
            // collect data 
            $id_news = $_GET['id_news'];
            // get news by id 
            $news = News::retreiveNewsById($id_news);
            if(is_array($news)){
                echo    '<h2>'.$news['title'].'</h2>
                        <img src="upload/'.$news['image_name'].'" class="img-fluid" alt="...">
                        <p>
                        '.$news['content'].'
                        </p>';
            }else{
                echo getMessage("No news found");
            }
        }else{
            // redirect to home page 
            header("Location: index.php");
            // for security 
            exit();
            
        }
    ?>
    
</div>
<?php
require_once 'template/footer.tpl';
?>