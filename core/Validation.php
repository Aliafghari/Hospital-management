<?php

namespace App\core;

use App\core\connection\MedooDatabase;
use App\Models\Doctor;

class Validation extends Controller
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_UNIQUE = 'unique';
    public const RULE_MATCH = 'match';
    public const RULE_HAVETABLE = 'role';

    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $role = '';
    public string $password = '';

    public string $confirmPassword = '';
    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
        return $this;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_UNIQUE => 'Record this field is already exist',
            self::RULE_MATCH => 'Password does not match',
            self::RULE_HAVETABLE => 'This field is not available'
        ];
    }
    public function registerRules(): array
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'role' => [self::RULE_REQUIRED, self::RULE_HAVETABLE],
            'password' => [self::RULE_REQUIRED],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }
    public function loginRules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
            'role' => [self::RULE_REQUIRED, self::RULE_HAVETABLE]

        ];
    }
    public function passwordForgets()
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'role' => [self::RULE_REQUIRED, self::RULE_HAVETABLE]
        ];
    }
    public function  passwordRest()
    {
        return [
            'password' => [self::RULE_REQUIRED],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }


    public function findOneLogin($table)
    {
        $user = Application::$app->Connection->getMedoo()->select($table, '*', ['email' => $this->email]);
        

        if (!$user) {
            $this->errors['email'][] = 'This email not exist';//.var_dump(!$user);
            return false;
        }

        if ($user[0]['password'] !=$this->password) {
            $this->errors['password'][] = 'Wrong password';
            return false;
        }
        return $user[0];
    }
    public function findOneRegister($classSet)
    {
        return  $classSet::do()->select("*", ['email' => $this->email]);
    }


    public function findOneForgets($table)
    {
        $user = Application::$app->Connection->getMedoo()->select($table, '*', ['email' => $this->email]);
        if (!$user) {
            $this->errors['email'][] = 'This email not exist';
            return false;
        }
        return $user[0];
    }
    public function validation($validationRules)
    {

        foreach ($validationRules as $attribute => $rules) {

            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MATCH && $value != $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {

                    $tableName = $this->role;
                    $record = Application::$app->Connection->getMedoo()->select($tableName, '*', [$attribute => $value]);

                    if ($record) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE);
                    }
                }
                if ($ruleName === self::RULE_HAVETABLE) {

                    $tableName = $this->role;

                    $sql = "SELECT table_name FROM information_schema.tables
                     WHERE table_name = '$tableName';";

                    $record = Application::$app->Connection->getMedoo()->exec($sql)->fetch(); //TABLE_NAME LIKE '%Doctor'

                    if ($record == false) {
                        $this->addErrorForRule($attribute, self::RULE_HAVETABLE);
                    }
                }
            }
        }
        return empty($this->errors);
    }
    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        $errorsMassages = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $errorsMassages = str_replace("{{$key}}", $value, $errorsMassages);
        }
        $this->errors[$attribute][] = $errorsMassages;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
