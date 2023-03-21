<?php
    /*
     тут будет контроллер для админки. нужны: авторизация, въюв для страницы, модель, которая будет делать авторизацию/выход из системы
      и еще нужно сделать, чтобы у админа на странице автоматически подтягивались данные о новых документах(еще страница просмотра документа)
      можно при записи в бд в модели сделать счетчик, а во въюве запрос на счетчик и потом сравнивая смотреть, есть ли новые данные и обновлять страницу

      осталось сделать въювы для формы авторизации и для просмотра документов а еще функцию для удаления документа\после в бд записывать в статус сообщение админа
       и потом пользователь будет видеть это но нужно переработать в model_account отображение чтобы не было ошибок ибо файл удален а пользователь пытается его глянуть
    
    */
    class Controller_Admin extends Controller{

      public function __construct()
      {
          $this->view = new View();
          $this->model = new Model_Admin();
      }

      public function action_adminPanel()//use view
      {
          $data = $this->model->documentList();
          $this->view->generate('admin_view.php', $data);
      }

      public function action_authorization()//DONE
      {
          $this->view->generate('admin_view.php');//sign form
      }

      public function action_authorizeAdmin()//DONE
      {
          echo $this->model->signIn($_POST);
      }

      public function action_logOut()//DONE
      {
          $this->model->signOut();
      }

      public function action_checkDocument()//view for checking documents
      {
          $data=$this->model->showDocument($_GET['n']);
          $this->view->generate('admin_view.php', $data);//show doc
      }

      public function action_documentsList()//model with the list of docs DONE
      {
          echo $this->model->documentList();
      }

      /*public function action_numOfRecords()
      {
        echo $this->model->numOfRecords();
      }*/

    /*  public function action_showDocument()//model that returns a pick of document to the view DONE
      {
          return $this->model->showDocument($_POST['docName']);
      }*/

      public function action_manipulate()
      {
        echo $this->model->manipulateDocument($_POST['docName'], $_POST['message']);
      }

      public function action_checked()
      {
        echo  $this->model->checkDocument($_POST['docName']);
      }

      public function action_byDocName()
      {
        echo $this->model->sortByDocName($_POST['docName']);
      }

     /* public function action_post()
      {
        $this->view->generate('admin_view.php');
      }

      public function action_makePost()
      {
        echo $this->model->makePost($_POST);
      }

      public function action_articles_list()
      {
        $data = $this->model->articles_list();
        $this->view->generate('admin_view.php', $data);
//ТУТ МОЖНА ЗВЕРНУТИСЯ СПОЧАТКУ ДО МОДЕЛІ А ПОТІМ В₴ЮВУ ПЕРЕДАТИ ДАННІ
      }*/

    }
//НУЖНО КАКТО ИЗМЕНИТЬ РАБОТУ ВИДА ЧТОБЫ ОН ПРИНИМАЛ ПАРАМЕТР ДАТА И В КОНТРОЛЛЕРЕ ВЫЗЫВАТЬ СНАЧАЛА МОДЕЛЬ ПОЛУЧАТЬ ДАТУ И ОТПРАВЛЯТЬ В ВИД А НЕ ИССПОЛЬЗОВАТЬ ДВЕ ФУНКЦИИ
?>