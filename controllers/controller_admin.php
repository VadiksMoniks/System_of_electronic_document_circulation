<?php
    /*
     тут будет контроллер для админки. нужны: авторизация, въюв для страницы, модель, которая будет делать авторизацию/выход из системы
      и еще нужно сделать, чтобы у админа на странице автоматически подтягивались данные о новых документах(еще страница просмотра документа)
      можно при записи в бд в модели сделать счетчик, а во въюве запрос на счетчик и потом сравнивая смотреть, есть ли новые данные и обновлять страницу

      осталось сделать въювы для формы авторизации и для просмотра документов а еще функцию для удаления документа\после в бд записывать в статус сообщение админа
       и потом пользователь будет видеть это но нужно переработать в model_account отображение чтобы не было ошибок ибо файл удален а пользователь пытается его глянуть
    
    */
    use Models\Model_Admin;
    use Core\Controller;
    use Core\View;

    class Controller_Admin extends Core\Controller{

      public function __construct()
      {
          $this->view = new Core\View();
          $this->model = new \Models\Model_Admin();
      }

      public function action_index()//use view
      {
          $data = $this->model->documentList();
          $this->view->generate('admin_view.php', 'adminPanel', $data);
      }

      public function action_authorization()//DONE
      {
          $this->view->generate('admin_view.php', 'authorization');//sign form
      }

      public function action_authorizeAdmin()//DONE
      {
          echo $this->model->signIn($_POST);
      }

      public function action_logOut()//DONE
      {
          $this->model->signOut(\Core\Model::ADMIN);
      }

      public function action_checkDocument()//view for checking documents
      {
          $data=$this->model->showDocument($_GET['n']);
          $this->view->generate('admin_view.php', 'checkDocument', $data);//show doc
      }

      public function action_documentsList()//model with the list of docs DONE
      {
          echo $this->model->documentList();
      }


      public function action_manipulate()
      {
        echo $this->model->manipulateDocument($_POST['docName'], $_POST['message']);
      }

      public function action_checked()
      {
        echo  $this->model->checkDocument($_POST['docName']);
      }

      public function action_filter()
      {
        echo $this->model->sort($_POST);
      }

    }
