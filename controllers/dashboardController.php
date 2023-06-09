<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Management;

class dashboardController extends Controller
{

    public function dashboardDoctor()
    {

        Application::$app->checkAccess->check('id', 'doctor');




        Controller::setLayout('main2');
        echo $this->render('Doctor/homeDoctor', [
            "navbar" =>
            [
                "link1" => '/Profile/Edit',
                'viw1' => "Panel Profile",
                "link2" => '/home',
                'viw2' => "Home page",
                "link3" => '/visit/appointment',
                'viw3' => "visit list"
            ]
        ]);
    }

    public function profileEdited()
    {
        Application::$app->checkAccess->check('id', 'doctor');
        Application::$app->checkStatus->check();

        $id = Application::$app->session->get('id');
        $email = Application::$app->session->get('email');
        $role = Application::$app->session->get('role');
        // var_dump($role);
        // exit;
        $data = Doctor::do()->getData($id);
        // var_dump($data);
        // exit;
        $data2 = Clinic::do()->getDataJustName();
        // var_dump($data2);
        // exit;
        Controller::setLayout('main2');
        echo $this->render('Doctor/profileEdited', [
            "navbar" =>
            [
                "link1" => '/Profile/Edit',
                'viw1' => "Panel Profile",
                "link2" => '/home',
                'viw2' => "Home page",
                "link3" => '/visit/appointment',
                'viw3' => "visit list"
            ],
            "data" => $data,
            "data2" => $data2
        ]);
    }


    public function dashboardManagement()
    {
        Application::$app->checkAccess->check('id', 'management');
        Application::$app->checkStatus->check();

        Controller::setLayout('main2');
        echo $this->render('management/homeManagement', [
            "navbar" =>
            [
                "link1" => '/list/Accept',
                'viw1' => "Panel Profile",
                "link2" => '/add/section',
                'viw2' => "section",
                "link3" => '/management/account/active',
                'viw3' => "accept management"
            ]
        ]);
    }


    public function AcceptList()
    {
        Application::$app->checkAccess->check('id', 'management');
        Application::$app->checkStatus->check();
        $result = Application::$app->Connection->getMedoo()->select('doctor', [
            'id',
            'firstName',
            'lastName',
            'email',
            'statuse',
            'creat_at',
        ]);

        // var_dump($result);
        // exit;
        Controller::setLayout('main2');
        echo $this->render('management/checkDoctorList', [
            "navbar" => [
                "link1" => '/list/Accept',
                'viw1' => "Panel Profile",
                "link2" => '/add/section',
                'viw2' => "section",
                "link3" => '/management/account/active',
                'viw3' => "accept management"
            ],
            "result" => $result
        ]);
    }

    public function section()
    {
        Application::$app->checkAccess->check('id', 'management');


        $result = Application::$app->Connection->getMedoo()->select('clinic_section', [
            'id',
            'name',
            'creat_at',
        ]);


        Controller::setLayout('main2');
        echo $this->render(
            'management/Section',
            [
                "navbar" =>
                [
                    "link1" => '/list/Accept',
                    'viw1' => "Panel Profile",
                    "link2" => '/add/section',
                    'viw2' => "section",
                    "link3" => '/management/account/active',
                    'viw3' => "accept management"
                ],
                'result' => $result
            ]
        );
    }
}
