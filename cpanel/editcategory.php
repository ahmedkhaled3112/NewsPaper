<?php
require_once './auth.php';
require_once '../lib/Editor.php';
require_once '../lib/Category.php';
require_once '../lib/News.php';
require_once '../helpers/output.php';
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <h2>Show all Categories</h2>
    <?php
        if(isset($_GET['action'], $_GET['id'])){
            // collect data 
            $action = $_GET['action']; // may be delete or edit
            $id = $_GET['id'];
            switch($action){
                case 'delete':
                    if(Category::deleteCategory($id)){
                        echo getSuccessMessage();
                    }else{
                        echo getFailMessage();
                    }
                    break;
                case 'edit':
                    $category = Category::retreiveCategoryById($id);
                    if(is_array($category)){
                        echo '<form action="editcategory.php" method="post">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Category name</label>
                                    <input type="text" name="name" value="'.$category['name'].'" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Managed by</label>
                                    <select name="id_manager" class="form-select" aria-label="Default select example">';
                                    $allEditors = Editor::retreiveAllEditors();
                                    if(is_array($allEditors) && count($allEditors) >0){
                                        foreach ($allEditors as $editor):
                                            if($editor['id'] == $category['id_manager']){
                                                 echo '<option selected="selected" value="'.$editor['id'].'">'.$editor['name'].'</option>';
                                            }else{
                                                 echo '<option value="'.$editor['id'].'">'.$editor['name'].'</option>';
                                            }
                                        endforeach;
                                    }else{
                                        echo '<option value="">no editor found</option>';
                                    }

                                   echo' </select>
                                </div>
                                <input type="hidden" name="id" value="'.$category['id'].'" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                <input type="submit" class="btn btn-primary" name="updateCategory" value="update category"/>
                            </form>';
                    }else{
                        echo getMessage("no category found");
                    }
                    break;
                default:
                    echo getMessage("invalid action");
            }
        }
        
        if(isset($_POST['updateCategory'])){
             // collect data
            $name = $_POST['name'];
            $id_manager = $_POST['id_manager'];
            $id = $_POST['id'];
            // check data valid or no 
            if($name == null){
                echo getNullMessage("Category name");
            }else{
                // create object 
                $category = new Category($name, $id_manager, $id);
                if($category->updateCategory()){
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
                <th scope="col">name</th>
                <th scope="col">no of news</th>
                <th scope="col">managed by </th>
                <th scope="col">delete</th>
                <th scope="col">edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $allCategories = Category::retreiveAllCategories();
                if(is_array($allCategories) && count($allCategories)>0){
                    foreach ($allCategories as $category):
                        echo '<tr>
                                <th scope="row">'.$category['id'].'</th>
                                <td>'.$category['name'].'</td>
                                <td>'.News::retreiveNoOfNewsByCategoryId($category['id']).'</td>
                                <td>'.Editor::retreiveEditorNameById($category['id_manager']).'</td>
                                <td><a href="?action=delete&id='.$category['id'].'" class="btn btn-warning">delete</a></td>
                                <td><a href="?action=edit&id='.$category['id'].'" class="btn btn-success">edit</a></td>
                            </tr>';
                    endforeach;
                }else{
                    echo '<tr>
                            <td colspan="6">'. getMessage("no category found").'</td>
                        </tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<?php
require_once 'template/footer.tpl';
?>

