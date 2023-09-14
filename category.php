<?php
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <h2>LATEST NEWS</h2>
    <?php
        if(isset($_GET['id_category'])){
            // collect data 
            $id_category = $_GET['id_category'];
            // get all news by id_category
            $allNews = News::retreiveAllNewsOrderByIdDescByIdCategory($id_category);
            if(is_array($allNews) && count($allNews)>0){
                foreach ($allNews as $news):
                    echo '<div class="col-3">
                            <div class="card" style="width: 18rem;">
                                <img src="upload/'.$news['image_name'].'" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">'.$news['title'].'</h5>
                                    <a href="news.php?id_news='.$news['id'].'" class="btn btn-primary">read more</a>
                                </div>
                            </div>
                        </div>';
                endforeach;
            }else{
                echo getMessage("No News Found");
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