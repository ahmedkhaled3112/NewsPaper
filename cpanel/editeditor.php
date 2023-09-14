<?php
require_once './auth.php';
require_once '../lib/Editor.php';
require_once '../lib/News.php';
require_once '../helpers/output.php';
require_once 'template/header.tpl';
require_once 'template/navbar.tpl';
?>
<div id="content" class="row">
    <h2>Show all editors</h2>
    <?php
        if(isset($_GET['action'], $_GET['id'])){
            // collect data 
            $action = $_GET['action']; // may be delete or edit
            $id = $_GET['id'];
            switch ($action){
                case 'delete':
                    if(Editor::deleteEditor($id)){
                        echo getSuccessMessage();
                    }else{
                        echo getFailMessage();
                    }
                    break;
                case 'edit':
                    $editor = Editor::retreiveEditorById($id);
                    if(is_array($editor)){
                        echo '<form action="editeditor.php" method="post">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Editor name</label>
                                    <input type="text" value="'.$editor['name'].'" name="name" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Editor salary</label>
                                    <input type="text" value="'.$editor['salary'].'" name="salary" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                </div>
                                <input type="hidden" value="'.$editor['id'].'" name="id" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                <input type="submit" class="btn btn-primary" name="updateEditor" value="update editor"/>
                            </form>';
                    }else{
                        echo getMessage("No editor found");
                    }
                    break;
                default:
                    echo getMessage("invalid action");
            }
        }
        
        if(isset($_POST['updateEditor'])){
            // collect data 
            $name = $_POST['name'];
            $salary = $_POST['salary'];
            $id = $_POST['id'];
            // check data valid or no 
            if($name == null){
                echo getNullMessage('Editor name');
            }else if($salary == null){
                echo getNullMessage('Editor salary');
            }else if(!is_numeric($salary)){
                echo getNonNumericMessage("Editor salary");
            }else{
                // create object from editor 
                $editor = new Editor($name, $salary, $id);
                if($editor->updateEditor()){
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
                <th scope="col">No of News</th>
                <th scope="col">delete</th>
                <th scope="col">edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $allEditors = Editor::retreiveAllEditors();
                if(is_array($allEditors) && count($allEditors)>0){
                    foreach ($allEditors as $editor):
                        echo '<tr>
                                <th scope="row">'.$editor['id'].'</th>
                                <td>'.$editor['name'].'</td>
                                <td>'.News::retreiveNoOfNewsByEditorId($editor['id']).'</td>
                                <td><a href="?action=delete&id='.$editor['id'].'" class="btn btn-warning">delete</a></td>
                                <td><a href="?action=edit&id='.$editor['id'].'" class="btn btn-success">edit</a></td>
                            </tr>';
                    endforeach;
                }else{
                    echo '<tr>
                            <td colspan="5">'. getMessage("No Editor Found").'</td>
                        </tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<?php
require_once 'template/footer.tpl';
?>

