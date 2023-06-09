<?php

namespace App\Models;

use App\core\Model;
use App\core\Application;

class Doctor extends Model
{

    //!refactor
    public function setTableName()
    {
        return 'Doctor';
    }

    public static function do()
    {
        return new static;
    }


    //!refactor
    public function setRegister(array $body)
    {


        $SQL = [

            "firstName" => "null",
            "lastName" => "null",
            "email" => "null",
            "password" => "null",
            "statuse" => "0"
        ];
        $SQL["firstName"]  = $body['firstName'];
        $SQL["lastName"] = $body['lastName'];
        $SQL["email"] = $body['email'];
        $SQL["password"] = md5($body['password']);

        $this->insert($SQL);
    }
    //!refactor
    public function showTable($where)
    {
        $SQL = "SELECT
	    doctor.id, doctor.firstName,url_picture, doctor.lastName,
        doctor.statuse, doctor.email, doctor_profile.zip_code,
        doctor_profile.ed_info, doctor_profile.amount_visit,
        doctor_profile.phone_number, clinic_section.`name`, 
        worktime.start_worktime, 	worktime.end_worktime,
        worktime.week_days FROM doctor INNER JOIN 
        doctor_profile ON doctor.profile_id = doctor_profile.id
        INNER JOIN worktime ON doctor.id = worktime.doctor_id INNER JOIN clinic_section ON 
	    doctor.clinic_id = clinic_section.id WHERE ( doctor.id =$where) GROUP BY doctor.id
        ;";

        // $SQL = "SELECT doctor.id,doctor.firstName,doctor.statuse,doctor.lastName,clinic_section.name from doctor 
        // INNER JOIN clinic_section on doctor.clinic_id = clinic_section.id
        // WHERE ( doctor.id =$where) GROUP BY doctor.id;";

        return  Application::$app->Connection->getMedoo()->exec($SQL)->fetch(\PDO::FETCH_ASSOC);
    }


    public function getData($where)
    {

        return  Application::$app->Connection->getMedoo()->select(
            'doctor',
            [
                '[><]doctor_profile' => ['profile_id' => 'id'],

                '[><]clinic_section' => ['clinic_id' => 'id'],

                '[><]worktime' => ['id' => 'doctor_id'],
            ],
            [
                'doctor_profile.zip_code',
                'doctor_profile.url_picture',
                'doctor_profile.ed_info',
                'doctor_profile.id(imgID)',
                'doctor_profile.amount_visit',
                'doctor_profile.phone_number',
                'doctor_profile.madia_1',
                'clinic_section.name',
                'clinic_section.creat_at',
                'worktime.start_worktime',
                'worktime.end_worktime',
                'worktime.id(workID)',
                'worktime.week_days',
                'doctor.firstName',
                'doctor.lastName',
                'doctor.email',
                'doctor.creat_at'
            ],
            [
                'doctor.id' => $where
            ]
        );
    }


    //!refactor
    public function filterTable($where)
    {
        $SQL = "SELECT doctor.id, doctor.firstName,doctor.statuse,doctor.lastName,clinic_section.name from doctor 
        INNER JOIN clinic_section on doctor.clinic_id = clinic_section.id
        WHERE clinic_section.name LIKE '$where%'
        ;";
        return  Application::$app->Connection->getMedoo()->exec($SQL)->fetchAll();
    }


    //!refactor
    public function search($where)
    {
        $SQL = "SELECT doctor.id,doctor.firstName,doctor.statuse,doctor.lastName,clinic_section.name from doctor 
        INNER JOIN clinic_section on doctor.clinic_id = clinic_section.id
        WHERE doctor.firstName LIKE '$where%' OR doctor.lastName LIKE '$where%';";
        return  Application::$app->Connection->getMedoo()->exec($SQL)->fetchAll();
    }


    //!refactor
    public function appointments($where)
    {
        $SQL = "SELECT
	doctor.id, 
	worktime.start_worktime, 
	worktime.week_days, 
	worktime.end_worktime, 
    worktime.id as worktID , 
	clinic_section.`name` as clinicName,
    clinic_section.`id` as clinicID
    FROM
	doctor
	INNER JOIN
	doctor_profile
	ON 
		doctor.profile_id = doctor_profile.id
	INNER JOIN
	worktime
	ON 
		doctor.id = worktime.doctor_id
	INNER JOIN
	clinic_section
	ON 
		doctor.clinic_id = clinic_section.id
    WHERE
	doctor.id = $where
    GROUP BY
	doctor.id,worktime.id";



        return  Application::$app->Connection->getMedoo()->exec($SQL)->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function bootTable($doctorID)
    {
        $sql = "
         SELECT
	clinic_section.`name`,
	appointment.statuse,
	doctor.email,
	worktime.start_worktime,
	worktime.end_worktime,
	worktime.week_days,
	doctor_profile.amount_visit,
	appointment.id, 
	appointment.reason, 
	appointment.creat_at 
    FROM
	appointment
	INNER JOIN doctor ON appointment.doctor_id = doctor.id
	INNER JOIN worktime ON doctor.id = worktime.doctor_id 
	AND appointment.worktime_id = worktime.id
	INNER JOIN doctor_profile ON doctor.profile_id = doctor_profile.id
	INNER JOIN clinic_section ON appointment.clinic_id = clinic_section.id 
	AND doctor.clinic_id = clinic_section.id 
    WHERE
	doctor.id = $doctorID
    GROUP BY
	appointment.id;";

    $sql2="SELECT
    clinic_section.name,
    appointment.statuse,
    doctor.email,
    worktime.start_worktime,
    worktime.end_worktime,
    worktime.week_days,
    doctor_profile.amount_visit,
    appointment.id,
    appointment.reason,
    appointment.creat_at
         FROM
    appointment
    INNER JOIN doctor ON appointment.doctor_id = doctor.id
    INNER JOIN worktime ON doctor.id = worktime.doctor_id
    AND appointment.creat_at
    INNER JOIN doctor_profile ON doctor.profile_id = doctor_profile.id
    INNER JOIN clinic_section ON doctor.clinic_id = clinic_section.id
         WHERE
    doctor.id = $doctorID
         GROUP BY
    appointment.id;";

    return  Application::$app->Connection->getMedoo()->exec($sql2)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
