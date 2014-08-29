<?php
define('SCRIPTS_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/scripts/');
define('ADMIN_ROOT', SCRIPTS_ROOT . 'admin/');
define('CLASSES_ROOT', SCRIPTS_ROOT . 'classes/');
define('HANDLERS_ROOT', SCRIPTS_ROOT . 'handlers/');

require_once SCRIPTS_ROOT . 'container.php';

switch ($request_parts[0]) {
   case '': case null: case false:
      require_once SCRIPTS_ROOT . 'main.php';
      break;

   case 'departments':
      require_once SCRIPTS_ROOT . 'departments.php';
      break;

   case 'resume':
      require_once CLASSES_ROOT . 'class.Meta.php';
      require_once CLASSES_ROOT . 'class.Resume.php';
      $smarty->assign('sliders', $_resume->SetSamplingScheme(Resume::PAGE_SCHEME)->GetAll())
             ->assign('meta', $_meta->SetSamplingScheme(Meta::PAGE_SCHEME)->GetById(Meta::RESUME_META_ID))
             ->display('resume.tpl');
      break;

   case 'contacts':
      require_once CLASSES_ROOT . 'class.Meta.php';
      $smarty->assign('meta', $_meta->SetSamplingScheme(Meta::PAGE_SCHEME)->GetById(Meta::CONTACTS_META_ID))->display('contacts.tpl');
      break;

   case 'portfolio':
      require_once SCRIPTS_ROOT . 'portfolio.php';
      break;

   case 'news':
      require_once CLASSES_ROOT . 'class.News.php';
      if (empty($request_parts[1])) {
         require_once CLASSES_ROOT . 'class.Meta.php';
         $smarty->assign($_news->GetAllNews())
                ->assign('meta', $_meta->SetSamplingScheme(Meta::PAGE_SCHEME)->GetById(Meta::NEWS_META_ID))
                ->display('allnews.tpl');
      } else {
         $data = $_news->SetSamplingScheme(News::ARTICLE_SCHEME)->GetByURL($request_parts[1]);
         if (empty($data)) Redirect('/#news');
         $smarty->assign('article', $data)
                ->assign(
                     'other_articles',
                     $_news->GetOtherNews($data[$_news->ToPrfxNm(News::ID_FLD)], $data[$_news->ToPrfxNm(News::CATEGORIES_FLD)]
                  )
                )->display('news.tpl');
      }
      break;

   case 'uploadphoto':
      require_once SCRIPTS_ROOT . 'upload_photo.php';
      break;

   case 'uploadimage':
      require_once SCRIPTS_ROOT . 'uploadimage.php';
      break;

   case 'resizeimage':
      require_once SCRIPTS_ROOT . 'resize.php';
      break;

   case 'handler':
      $possible_handlers = [
         'news'     => HANDLERS_ROOT . 'handler.News.php',
         'image'    => HANDLERS_ROOT . 'handler.Image.php',
         'proposal' => HANDLERS_ROOT . 'handler.Proposal.php'
      ];
      if (empty($request_parts[1]) || empty($possible_handlers[$request_parts[1]])) Redirect('/404');
      require_once $possible_handlers[$request_parts[1]];
      break;

   case 'admin':
      require_once CLASSES_ROOT . 'class.Admin.php';

      $isLoginPage = empty($request_parts[1]) || $request_parts[1] == 'login';
      if ($_admin->IsAdmin()) {
         if ($isLoginPage) {
            Redirect(ADMIN_START_PAGE);
         }
      } elseif (!$isLoginPage) {
         Redirect('/admin/');
      }
      $request_parts[1] = !empty($request_parts[1]) ? $request_parts[1] : null;
      switch ($request_parts[1]) {
         case '': case 'login': case null: case false:
            require_once ADMIN_ROOT . 'admin.login.php';
            break;

         case 'news':
            require_once ADMIN_ROOT . 'admin.news.php';
            break;

         case 'slider':
            require_once ADMIN_ROOT . 'admin.slider.php';
            break;

         case 'resume':
            require_once ADMIN_ROOT . 'admin.resume.php';
            break;

         case 'portfolio':
            require_once CLASSES_ROOT . 'class.Portfolio.php';
            $smarty->assign($_portfolio->GetPortfolio($_portfolio->GetAllAmount(), Portfolio::ADMIN_AMOUNT))
                   ->display('admin.portfolio.tpl');
            break;

         case 'projects':
         case 'departments':
            require_once CLASSES_ROOT . 'class.Project.php';
            require_once CLASSES_ROOT . 'class.Department.php';
            $page = $request_parts[1];
            $obj = $page == 'projects' ? $_project : $_department;
            $smarty->assign('pname', $page == 'projects' ? 'Проект' : 'Отдел');
            require_once ADMIN_ROOT . 'admin.textsbase.php';
            break;

         case 'change_data':
            require_once ADMIN_ROOT . 'admin.change_data.php';
            break;

         case 'meta':
            require_once ADMIN_ROOT . 'admin.meta.php';
            break;

         case 'proposals':
            require_once CLASSES_ROOT . 'class.Proposal.php';
            $smarty->assign($_proposal->GetProposals())->display('admin.proposals.tpl');
            break;

         case 'logout':
            unset($_SESSION['admin_login']);
            unset($_SESSION['admin_pass']);
            Redirect(ADMIN_START_PAGE);
            break;

         case 'add':
            if (empty($request_parts[2])) {
               Redirect(ADMIN_START_PAGE);
            }
            $id = null;
            $smarty->assign('isAdd', true);
            switch ($request_parts[2]) {
               case 'news':
                  $smarty->assign('handle_url', 'add/news');
                  require_once ADMIN_ROOT . 'admin.change.news.php';
                  break;

               case 'portfolio':
                  $smarty->assign('handle_url', 'add/portfolio');
                  require_once ADMIN_ROOT . 'admin.change.portfolio.php';
                  break;

               default:
                  Redirect(ADMIN_START_PAGE);
                  break;
            }
            break;

         case 'edit':
         case 'delete':
            if (empty($request_parts[2]) || empty($request_parts[3]) || !IsPositiveNumber($request_parts[2])) {
               Redirect(ADMIN_START_PAGE);
            }
            $id = $request_parts[2];
            switch ($request_parts[3]) {
               case 'news':
                  if ($request_parts[1] == 'delete') {
                     $request->request->set('id', $id);
                     $request->request->set('mode', 'Delete');
                  }
                  require_once CLASSES_ROOT . 'class.News.php';
                  $data = $_news->SetSamplingScheme(News::ADMIN_CHANGE_SCHEME)->GetById($id);
                  if (empty($data)) Redirect('/admin/add/news');
                  $smarty->assign('article', $data)->assign('handle_url', "edit/$id/news");
                  require_once ADMIN_ROOT . 'admin.change.news.php';
                  break;

               case 'portfolio':
                  if ($request_parts[1] == 'delete') {
                     $request->request->set('id', $id);
                     $request->request->set('mode', 'Delete');
                  }
                  require_once CLASSES_ROOT . 'class.Portfolio.php';
                  $data = $_portfolio->GetById($id);
                  if (empty($data)) Redirect('/admin/add/portfolio');
                  $smarty->assign('portfolio', $data)->assign('handle_url', "edit/$id/portfolio");
                  require_once ADMIN_ROOT . 'admin.change.portfolio.php';
                  break;

               default:
                  Redirect(ADMIN_START_PAGE);
                  break;
            }
            break;

         default:
            Redirect(ADMIN_START_PAGE);
            break;
      }
      break;

   default:
      echo "FAIL ERROR";
      #error page
}
