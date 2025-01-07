<?php
namespace App\Modules\Crm\users_interface\src;

use App\Src\helpers\ArrayHelper;

/**
 * Модель для добавления пользователя (Используется в операции addUser)
 */
class UserData
{

    private array $data;

    private $username;
    private $password;

    private $first_name;
    private $last_name;
    private $patronymic;
    private $email;
    private $number_phone;

    private $photo;
    private $birthday;

    private $inn;
    private $passport_series;
    private $passport_number;
    private $snils;
    private $address;

    private array $groups;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->init();
    }

    /**
     * Инициализирует модель
     * @return void
     */
    private function init()
    {
        $this->username = isset($this->data['username']) ? $this->data['username'] : null;
        $this->password = isset($this->data['password']) ? $this->data['password'] : null;
        $this->first_name = isset($this->data['first_name']) ? $this->data['first_name'] : null;
        $this->last_name = isset($this->data['last_name']) ? $this->data['last_name'] : null;
        $this->patronymic = isset($this->data['patronymic']) ? $this->data['patronymic'] : null;
        $this->email = isset($this->data['email']) ? $this->data['email'] : null;
        $this->number_phone = isset($this->data['number_phone']) ? $this->data['number_phone'] : null;
        $this->birthday = isset($this->data['birthday']) ? $this->data['birthday'] : null;
        $this->photo = isset($this->data['photo']) ? $this->data['photo'] : null;
        $this->inn = isset($this->data['inn']) ? $this->data['inn'] : null;
        $this->passport_series = isset($this->data['passport_series']) ? $this->data['passport_series'] : null;
        $this->passport_number = isset($this->data['passport_number']) ? $this->data['passport_number'] : null;
        $this->snils = isset($this->data['snils']) ? $this->data['snils'] : null;
        $this->address = isset($this->data['address']) ? $this->data['address'] : null;
        $this->groups = isset($this->data['groups']) ? $this->data['groups'] : [];
    }

    /**
     * Возвращает логин
     * @return string
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * Возвращает пароль
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * Возвращает имя
     * @return string
     */
    public function getFirstName(){
        return $this->first_name;
    }

    /**
     * Возвращает фамилию
     * @return string
     */
    public function getLastName(){
        return $this->last_name;
    }

    /**
     * Возвращает отчество
     * @return string
     */
    public function getPatronymic(){
        return $this->patronymic;
    }

    /**
     * Возвращает email
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Возвращает номер телефона
     * @return string
     */
    public function getNumberPhone(){
        return $this->number_phone;
    }

    /**
     * Возвращает дату рождения
     * @return string
     */
    public function getBirthday(){
        return $this->birthday;
    }

    /**
     * Возвращает фото
     * @return string
     */
    private function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Возвращает ИНН
     * @return string
     */
    public function getInn(){
        return $this->inn;
    }

    /**
     * Возвращает серию паспорта
     * @return string
     */
    public function getPassportSeries(){
        return $this->passport_series;
    }

    /**
     * Возвращает номер паспорта
     * @return string
     */
    public function getPassportNumber(){
        return $this->passport_number;
    }

    /**
     * Возвращает номер СНИЛС
     * @return string
     */
    public function getSnils(){
        return $this->snils;
    }

    /**
     * Возвращает адрес
     * @return string
     */
    public function getAddress(){
        return $this->address;
    }

    /**
     * Возвращает группы пользователя
     * @return array
     */
    public function getGroups(){
        return ArrayHelper::arrayInt($this->groups);
    }

    /**
     * Возвращает данные для таблицы users
     * @return array
     */
    public function getDataForUsersTable()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    /**
     * Возвращает данные для таблицы users_info
     * @return array
     */
    public function getDataForUsersInfoTable()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->patronymic,
            'email' => $this->email,
            'number_phone' => $this->number_phone,
            'birthday' => $this->birthday,
            'photo' => $this->photo,
        ];
    }

    /**
     * Возвращает данные для таблицы users_documents
     * @return array
     */
    public function getDataForUsersDocumentsTable()
    {
        return [
            'inn' => $this->inn,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'snils' => $this->snils,
            'address' => $this->address,
        ];
    }

}
