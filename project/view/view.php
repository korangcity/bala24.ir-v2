<?php


use App\controller\Auth;
use App\controller\Instagram;
use EasyCSRF\Exceptions\InvalidCsrfTokenException;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

use GuzzleHttp\Client;
use Jenssegers\Blade\Blade;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use  Rakit\Validation\Validator;

function view(array $route)
{
    $sessionProvider = new EasyCSRF\NativeSessionProvider();
    $easyCSRF = new EasyCSRF\EasyCSRF($sessionProvider);
    $phraseBuilder = new PhraseBuilder(5, '0123456789');
    $builder = new CaptchaBuilder(null, $phraseBuilder);

    if ($route['page_for'] == 'guest') {

        if ($route['TheCourse'] == 'home') {

            echo "hiiiii";

//            $token = $easyCSRF->generate('my_token');

//           $validator=new Validator;
//           $validator->make($_POST + $_FILES,[
//               'name'                  => 'required',
//               'email'                 => 'required|email',
//               'password'              => 'required|min:6',
//               'confirm_password'      => 'required|same:password',
//               'avatar'                => 'required|uploaded_file:0,500K,png,jpeg',
//           ],[
//               'name:required'=>'is required'
//           ])->validate();


//            $phraseBuilder = new PhraseBuilder(5, '0123456789');
//            $builder = new CaptchaBuilder(null, $phraseBuilder);
//            if($builder->getPhrase())
//                echo $builder->getPhrase();
//            $builder->build();

//
//            $spreadsheet = new Spreadsheet();
//
//            $spreadsheet->getProperties()
//                ->setCreator("Maarten Balliauw")
//                ->setLastModifiedBy("Maarten Balliauw")
//                ->setTitle("Office 2007 XLSX Test Document")
//                ->setSubject("Office 2007 XLSX Test Document")
//                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
//                ->setKeywords("office 2007 openxml php")
//                ->setCategory("Test result file");
//
//
//            $sheet = $spreadsheet->getActiveSheet();
//            $sheet->setCellValue('A1', 'Hello World !');
//
//            $writer = new Xlsx($spreadsheet);
//            $writer->save('hello world.xlsx');

//            renderView('admin.register');


        }

        if ($route['TheCourse'] == 'signup') {
            $auth = new Auth();

            if (!isset($_REQUEST['error'])) {
                destroyErrors();
                requestSessionDestroy();
            }

            if ($_POST) {

                $checkCsrf = $easyCSRF->check('my_token', $_POST['token']);

                newRequest('email', $_POST['email']);

                if ($checkCsrf === false) {
                    setError('send information correctly');
                    redirect('signup?error=true');
                }
                if ($_POST['captcha'] != $_SESSION['phrase']) {
                    setError('enter captcha value correctly');
                    redirect('signup?error=true');

                }

                $email = sanitizeInput($_POST['email']);
                $password = sanitizeInput($_POST['password']);
                $confirm_password = sanitizeInput($_POST['confirm_password']);


                $result = $auth->register($email, $password, $confirm_password);

                if ($result == false)
                    redirect('signup?error=true');
                else
                    redirect('signup?signup=true');

            }


            $token = $easyCSRF->generate('my_token');
            $builder->build();
            $_SESSION['phrase'] = $builder->getPhrase();

            renderView('home.auth.signup', ['token' => $token, 'builder' => $builder]);

        }

        if ($route['TheCourse'] == 'signin') {

        }

        if ($route['TheCourse'] == 'downloader') {

        }


    } elseif ($route['page_for'] == 'sitemap') {

    } elseif ($route['page_for'] == 'admin') {


    }
}