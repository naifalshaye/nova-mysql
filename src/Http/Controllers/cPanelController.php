<?php
namespace Naif\NovaMysql\Http\Controllers;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

require_once '../vendor/autoload.php';

class cPanelController
{
    private $cpanel;
    private $database_prefix;

    public function __construct()
    {
        $this->cpanel = new \Gufy\CpanelPhp\Cpanel([
            'host' => 'https://192.254.234.144:2083', // ip or domain complete with its protocol and port
            'username' => env('CPANEL_USERNAME'), // username of your server, it usually root.
            'auth_type' => 'password', // set 'hash' or 'password'
            'password' => env('CPANEL_PASSWORD'), // long hash or your user's password
        ]);

        $this->database_prefix = env('CPANEL_PREFIX');
    }

    public function getDatabases()
    {
        $response = $this->cpanel->execute_action('2', 'MysqlFE', 'listdbs', $this->database_prefix);
        $response = json_decode($response);
        return ['databases' => $response->cpanelresult->data];
    }

    public function createDatabase(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'create_database', $this->database_prefix,
            ['name' => $this->database_prefix.'_'.$request->name]
        );
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Database has been created successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }


    public function deleteDatabase(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'delete_database', $this->database_prefix,
            ['name' => $request->name]
        );
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Database has been deleted successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }

    public function repairDatabase(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'repair_database', $this->database_prefix,
            ['name' => $request->name]
        );
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Database has been repaired successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }

    public function getUsers()
    {
        $response = $this->cpanel->execute_action('2', 'MysqlFE', 'listusers', $this->database_prefix);
        $response = json_decode($response);
        return ['dbusers' => $response->cpanelresult->data];
    }

    public function addUser(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'create_user', $this->database_prefix, [
            'name' => $this->database_prefix.'_'.$request->username,
            'password' => $request->password
        ]);
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Username has been added successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }

    public function deleteUser(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'delete_user', $this->database_prefix, [
            'name' => $request->username,
        ]);
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Username has been deleted successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }

    public function changeUserPassword(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'set_password', $this->database_prefix, [
            'user' => $request->user,
            'password' => $request->password
        ]);
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Password has been changed successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }


    public function addUserToDatabase(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'set_privileges_on_database', $this->database_prefix, [
            'user' => $request->user,
            'database' => $request->database,
            'privileges' => $request->privileges,
        ]);
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Username has been added to database successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }

    public function getUserPrivileges(Request $request)
    {
        $response = $this->cpanel->execute_action('2', 'MysqlFE', 'getdbuserprivileges', $this->database_prefix, [
            'dbuser' => 'phototim_naif',
            'db' => 'phototim_naifdb',
        ]);
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Database has been deleted successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }

    public function revokeDatabaseUser(Request $request)
    {
        $response = $this->cpanel->execute_action('3', 'Mysql', 'revoke_access_to_database', $this->database_prefix, [
            'user' => $request->user,
            'database' => $request->database,
        ]);
        $response = json_decode($response);
        if ($response->result->status) {
            return ['success' => 'Username has been revoked from database successfully'];
        }
        return ['error' => $response->result->errors[0]];
    }
}