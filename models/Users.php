<?php

namespace App\Models;
//namespace App\models;

use App\core\Model;

use App\core\Application;

class Users extends Model
{


    public function setTableName()
    {
        return 'Users';
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
    public function getData($where)
    {
        $table = $this->setTableName();
        $column = ['id', 'firstName', 'lastName', 'email'];
        $findBy = ["id" => $where];
        return  Application::$app->Connection->getMedoo()->select($table, $column, $findBy);
    }

    public function visitSearch()
    {
        // $sql2 = "SELECT appointment.reason, appointment.statuse, doctor.firstName, doctor.lastName, clinic_section.`name`, worktime.week_days, worktime.end_worktime, worktime.start_worktime, appointment.id FROM appointment INNER JOIN doctor ON appointment.doctor_id = doctor.id INNER JOIN clinic_section ON doctor.clinic_id = clinic_section.id AND doctor.clinic_id = clinic_section.id INNER JOIN worktime ON doctor.id = worktime.doctor_id ORDER BY appointment.id;";

        // $sql3 = "SELECT appointment.id, appointment.reason, appointment.creat_at, appointment.days, appointment.timeSet, appointment.status, doctor.firstName AS doctorFirstName, doctor.lastName AS doctorLastName, users.firstName AS userFirstName, users.lastName AS userLastName 
        // FROM appointment 
        // LEFT JOIN doctor ON appointment.doctor_id = doctor.id 
        // LEFT JOIN users ON appointment.users_id = users.id;";

        // $sql4 = "SELECT appointment.id, appointment.reason,appointment.creat_at, appointment.days, appointment.timeSet,appointment.statuse, doctor.firstName, doctor.lastName, users.firstName, users.lastName
        // FROM appointment 
        // LEFT JOIN doctor ON appointment.doctor_id = doctor.id 
        // LEFT JOIN users ON appointment.users_id = users.id;";

        // $sql5="SELECT appointment.id, appointment.reason, appointment.creat_at, appointment.days, appointment.timeSet, appointment.statuse, doctor.firstName, doctor.lastName
        // FROM appointment 
        // LEFT JOIN doctor ON appointment.doctor_id = doctor.id;";

        $sql = "SELECT
    clinic_section.name,
    appointment.statuse,
    doctor.email,
    worktime.start_worktime,
    worktime.end_worktime,
    worktime.week_days,
    doctor_profile.amount_visit,
    appointment.id,
    appointment.reason,
    appointment.creat_at,
    doctor.firstName,
    doctor.lastName
         FROM
    appointment
    INNER JOIN doctor ON appointment.doctor_id = doctor.id
    INNER JOIN worktime ON doctor.id = worktime.doctor_id
    AND appointment.creat_at
    INNER JOIN doctor_profile ON doctor.profile_id = doctor_profile.id
    INNER JOIN clinic_section ON doctor.clinic_id = clinic_section.id
         GROUP BY
    appointment.id;";
        return Application::$app->Connection->getMedoo()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}
