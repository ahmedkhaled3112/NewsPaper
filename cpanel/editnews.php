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
    <h2>Show all News</h2>
    <?php
        if(isset($_GET['action'], $_GET['id'])){
            // collect data
            $action = $_GET['action']; // may be delete or edit
            $id = $_GET['id'];
            switch($action){
                case 'delete':
                    if(News::deleteNews($id)){
                        echo getSuccessMessage();
                    }else{
                        echo getFailMessage();
                    }
                    break;
                case 'edit':
                    $news = News::retreiveNewsById($id);
                    if(is_array($news)){
                        echo '<form action="editnews.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">news title</label>
                                    <input type="text" value="'.$news['title'].'" name="title" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">news content</label>
                                    <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3">
                                        '.$news['content'].'
                                    </textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">written by</label>
                                    <select name="id_editor" class="form-select" aria-label="Default select example">';
                                        $allEditors = Editor::retreiveAllEditors();
                                        if(is_array($allEditors) && count($allEditors) >0){
                                            foreach ($allEditors as $editor):
                                                if($editor['id'] == $news['id_editor']){
                                                    echo '<option selected="selected" value="'.$editor['id'].'">'.$editor['name'].'</option>';
                                                }else{
                                                    echo '<option value="'.$editor['id'].'">'.$editor['name'].'</option>';
                                                }
                                            endforeach;
                                        }else{
                                            echo '<option value="">no editor found</option>';
                                        }
                                    echo '</select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">belong to</label>
                                    <select name="id_category" class="form-select" aria-label="Default select example">';
                                        $allCategories = Category::retreiveAllCategories();
                                        if(is_array($allCategories) && count($allCategories) >0){
                                            foreach ($allCategories as $category):
                                                if($category['id'] == $news['id_category']){
                                                    echo '<option selected="selected" value="'.$category['id'].'">'.$category['name'].'</option>';
                                                }else{
                                                    echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                                                }
                                            endforeach;
                                        }else{
                                            echo '<option value="">no category found</option>';
                                        }
                                    echo '</select>
                                </div>
                                <div class="mb-3">
                                    <img src="../upload/'.$news['image_name'].'" class="img-thumbnail" width="60" height="60">
                                    <label for="formFile" class="form-label">main image</label>
                                    <input class="form-control" name="main_image" type="file" id="formFile">
                                </div>
                                <input type="hidden" value="'.$news['id'].'" name="id" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                <input type="submit" class="btn btn-primary" name="updateNews" value="update news"/>
                            </form>';
                    }else{
                        echo getMessage("No news found");
                    }
                    break;
                default:
                    echo getMessage("Invalid action");
            }
        }
        
        if(isset($_POST['updateNews'])){
            // collect data 
            $title = $_POST['title'];
            $content = $_POST['content'];
            $id_editor = $_POST['id_editor'];
            $id_category = $_POST['id_category'];
            $image_tmp = $_FILES['main_image']['tmp_name'];
            $image_name = $_FILES['main_image']['name'];
            $id = $_POST['id'];
            if($title == null){
                echo getNullMessage("News title");
            }else if($content == null){
                echo getNullMessage("News content");
            }else{
                // create object 
                $news  = new News($title, $content, $id_editor, $id_category, $image_tmp, $image_name, $id);
                if($news->updateNews()){
                    echo getSuccessMessage();
                }else{
                    echo getFailMessage();
                }
            }
        }
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">image</th>
                <th scope="col">title</th>
                <th scope="col">written by</th>
                <th scope="col">belong to</th>
                <th scope="col">delete</th>
                <th scope="col">edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $allNews = News::retreiveAllNews();
                if(is_array($allNews) && count($allNews) > 0){
                    foreach ($allNews as $news):
                        echo '<tr>
                                <th scope="row">'.$news['id'].'</th>
                                <td><img src="../upload/'.$news['image_name'].'" class="img-thumbnail" width="60" height="60"></td>
                                <td>'.$news['title'].'</td>
                                <td>'.Editor::retreiveEditorNameById($news['id_editor']).'</td>
                                <td>'.Category::retreiveCategoryNameById($news['id_category']).'</td>
                                <td><a href="?action=delete&id='.$news['id'].'" class="btn btn-warning">delete</a></td>
                                <td><a href="?action=edit&id='.$news['id'].'" class="btn btn-success">edit</a></td>
                            </tr>';
                    endforeach;
                }else{
                    echo '<tr>
                            <td colspan="7">ali</td>
                        </tr>';
                }
            ?>
            
        </tbody>
    </table>
</div>
<?php
require_once 'template/footer.tpl';
?>

