<?php
require_once './auth.php';
require_once '../lib/Editor.php';
require_once '../lib/News.php';
require_once '../lib/Category.php';
require_once '../helpers/output.php';
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <h2>Add new news</h2>
    <?php
        if(isset($_POST['addNews'])){
            // collect data 
            $title = $_POST['title'];
            $content = $_POST['content'];
            $id_editor = $_POST['id_editor'];
            $id_category = $_POST['id_category'];
            $image_tmp = $_FILES['main_image']['tmp_name'];
            $image_name = $_FILES['main_image']['name'];
            if($title == null){
                echo getNullMessage("News title");
            }else if($content == null){
                echo getNullMessage("News content");
            }else{
                // create object 
                $news  = new News($title, $content, $id_editor, $id_category, $image_tmp, $image_name);
                if($news->addNews()){
                    echo getSuccessMessage();
                }else{
                    echo getFailMessage();
                }
            }
        }
    ?>
    <form action="addnews.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">news title</label>
            <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">news content</label>
            <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">written by</label>
            <select name="id_editor" class="form-select" aria-label="Default select example">
                <?php
                    $allEditors = Editor::retreiveAllEditors();
                    if(is_array($allEditors) && count($allEditors) >0){
                        foreach ($allEditors as $editor):
                            echo '<option value="'.$editor['id'].'">'.$editor['name'].'</option>';
                        endforeach;
                    }else{
                        echo '<option value="">no editor found</option>';
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">belong to</label>
            <select name="id_category" class="form-select" aria-label="Default select example">
                <?php
                    $allCategories = Category::retreiveAllCategories();
                    if(is_array($allCategories) && count($allCategories) >0){
                        foreach ($allCategories as $category):
                            echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                        endforeach;
                    }else{
                        echo '<option value="">no category found</option>';
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">main image</label>
            <input class="form-control" name="main_image" type="file" id="formFile">
        </div>
        <input type="submit" class="btn btn-primary" name="addNews" value="add news"/>
    </form>
</div>
<?php
require_once 'template/footer.tpl';
?>

