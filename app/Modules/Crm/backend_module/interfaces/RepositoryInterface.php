<?php
namespace App\Modules\Crm\backend_module\interfaces;

use App\Entity\DurationLesson;
use App\Entity\FormatLesson;
use App\Entity\GroupUser;
use App\Entity\Holiday;
use App\Entity\Lesson;
use App\Entity\PairNumber;
use App\Entity\PlanDurationLesson;
use App\Entity\PlanSchedule;
use App\Entity\Schedule;
use App\Entity\SchedulePlanType;
use App\Entity\ScheduleTask;
use App\Entity\Semester;
use App\Entity\Specialty;
use App\Entity\StudentGroup;
use App\Entity\Subject;
use App\Entity\User;
use App\Entity\UserDocumet;
use App\Entity\UserGroup;
use App\Entity\UserInfo;
use App\Modules\Crm\backend_module\repositories\CronRepository;
use App\Modules\Crm\backend_module\repositories\TaskRepository;
use App\Modules\Crm\reports\repositories\ReportsRepository;
use App\Modules\Crm\schedule\models\SemestersModel;
use App\Modules\Crm\schedule\repositories\ScheduleRepository;
use App\Modules\Crm\users_interface\repositories\UsersRepositories;


/**
 * @mixin TaskRepository
 * @mixin ReportsRepository
 * @mixin UsersRepositories
 * @mixin ScheduleRepository
 * @mixin CronRepository
 *
 */
interface RepositoryInterface{
    /**
     * Возвращает пользователей по условию
     * @param $data
     * @return User[]
     */
    public function getUserList($data);

    /**
     * Возвращает расширенную информацию по пользователю
     * @return mixed
     */
    public function getFullUsersInfo();

    /**
     * Возвращает пользователя по id
     * @param $id
     * @return User
     */
    public function getUserById($id);

    /**
     * Обновляет пользователя по id
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateUsersById($id, $data);

    /**
     * Обновляет информацию по пользователю по id
     * @param $id
     * @param $value
     * @return bool
     */
    public function updateUsersInfoById($id, $value);

    /**
     * Обновляет документы пользователя по id
     * @param $id
     * @param $value
     * @return bool
     */
    public function updateUsersDocumentById($id, $value);

    /**
     * Обновляет доступ(Логин и пароль) пользователя по id
     * @param $id
     * @param $value
     * @return bool
     */
    public function saveAccessUser($id, $model);

    /**
     * Добавляет пользователя в группу
     * @param $user_id
     * @param $group_id
     * @return mixed
     */
    public function addUserInGroup($user_id, $group_id);

    /**
     * Проверяет есть ли пользователь в группе
     * @param $user_id
     * @param $group_id
     * @return bool
     */
    public function hasUserInGroup($user_id, $group_id);

    /**
     * Берет все группы пользователя
     * @param $user_id
     * @return GroupUser[]
     */
    public function getGroupsUserByUserId($user_id);

    /**
     * Возвращает группы пользователей по id
     * @param $id
     * @return UserGroup
     */
    public function getUsersGroupById($id);

    /**
     * Создает группу пользователей
     * @param string $name
     * @param string $access
     * @return bool
     */
    public function updateUserGroup($group_id, $name, $access, $active = true, $description = '');

    /**
     * Создает группу пользователей
     * @param string $name
     * @param string $access
     * @return bool
     */
    public function createUsersGroup($name, $access, $active = true, $description ='');

    /**
     * Удаляет группу пользователей по id
     * @param $id
     * @return bool|null
     */
    public function deleteUserGroupById($id);

    /**
     * Возвращает все группы пользователей
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsersGroup();

    /**
     * Возвращает всех активных пользователей
     * @return \Illuminate\Database\Eloquent\Collect
     */
    public function getAllActiveUsers();

    /**
     * возвращает актуальные настройки системы
     * @param $name
     * @return mixed
     */
    public function getActiveSystemSettings($name);

    /**
     * возвращает последние настройки системы
     * @param $name
     * @return mixed
     */
    public function getLastSystemSettings($name);

    /**
     * делает переданные настройки актуальными
     * @param $settings
     * @return mixed
     */
    public function saveActiveSystemSettings($settings);

    /**
     * Репозиторий создает пользователе
     * @param $data
     * @return User|null
     */
    public function createUser($data);

    /**
     * Репозиторий создает информацию пользователя
     * @param $data
     * @param $user_id
     * @return UserInfo|null
     */
    public function createUserInfo($data, $user_id);

    /**
     * Репозиторий создает документы пользователя
     * @param $data
     * @param $user_id
     * @return UserDocumet|null
     */
    public function createUserDocument($data, $user_id);

    /**
     * Выдает информацию по пользователю с поиском
     * @param $data
     * @return array
     */
    public function getFullUsersInfoSearch($data);

    /**
     * Создание специальности
     * @return Specialty|null
     */
    public function createSpecialty($number, $name, $description = '');

    /**
     * Возвращает все специальности
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSpecialties();


    /**
     * Создание студенческой группы
     * @return StudentGroup|null
     */
    public function createStudentGroup($number, $name, $specialty_id = '');

    /**
     * Создает предмет
     * @param $name
     * @param $full_name
     * @param $description
     * @return Subject|null
     */
    public function createSubject($name, $full_name, $description = '');

    /**
     * Возвращает все группы со специальностями
     * @return array
     */
    public function getStudentGroupsInfo();

    /**
     * Поиск групп студентов
     * @return array
     */
    public function searchStudentGroups($data);

    /**
     * Возвращает предметы для таблицы
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubjectInfo();

    /**
     * Возвращает все предметы
     * @return Subject[]
     */
    public function getFullSubject();

    /**
     * Получает группу студентов то id
     * @param $id
     * @return StudentGroup
     */
    public function getStudentGroupById($id);


    /**
     * Обновляет группу студентов по id
     * @param int $id id группы студентов
     * @param string $field название поля
     * @param mixed $value содержимое поля
     * @return bool
     */
    public function updateStudentGroupById($id, $field, $value);

    /**
     * Обновляет специальность по id
     * @param $id
     * @param $field
     * @param $value
     * @return mixed
     */
    public function updateSpecialtyByStudentGroupId($id, $field, $value);

    /**
     * Возвращает предмет по id
     * @param $id
     * @return Subject
     */
    public function getSubjectById($id);

    /**
     * Обновляет предмет по id и полю
     * @param $id
     * @param $field
     * @param $value
     * @return bool
     */
    public function updateSubjectField($id, $field, $value);


    /**
     * Возвращает предметы для таблицы с поиском
     * @param $searchData
     * @return array
     */
    public function getSearchSubjectInfo($searchData);

    /**
     * Возвращает все последовательности пар
     * @return PairNumber[]
     */
    public function getNumberPair();

    /**
     * Возвращает последовательность пар по id
     * @param $id
     */
    public function getNumberPairById($id);

    /**
     * Создает последовательность пар
     * @param array $data
     * @return bool
     */
    public function addNumberPair($data);

    /**
     * Обновляет последовательность пар по id
     * @param $data
     * @param $id
     * @return bool
     */
    public function updateNumberPairById($data, $id);

    /**
     * Удаляет последовательность пар по id
     * @param $id
     * @return bool
     */
    public function deleteNumberPairById($id);

    /**
     * Возвращает все группы студентов
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFullStudentGroups();

    /**
     * Возвращает расписание по группе за период для менеджера расписаний
     * @param string $date_start
     * @param string $date_end
     * @param $groups_id
     * @return array
     */
    public function getScheduleByGroupFroManager($date_start, $date_end, $groups_id = null);

    /**
     * Возвращает формат
     * @return FormatLesson[]
     */
    public function getFullFormatLessons();

    /**
     * Получает расписание по дате, группе и номеру пары
     * @param $id
     * @return Schedule
     */
    public function getSchedulesById($id);

    /**
     * Создает длительность пары
     * @param $date_start
     * @param $time_start
     * @param $time_end
     * @param string $duration_minutes
     * @return DurationLesson|null
     */
    public function createDurationLessons($date_start, $time_start, $time_end, $duration_minutes = '');

    /**
     * Получает расписание по данным
     * @param $date
     * @param $group_id
     * @param $pair_number_id
     * @return array
     */
    public function getScheduleByDate($date, $group_id, $pair_number_id);


    /**
     * Создает урок для расписания
     * @param $subject_id
     * @param $format_lesson_id
     * @param $user_id
     * @return Lesson|null
     */
    public function createLessons($subject_id, $format_lesson_id, $user_id);

    /**
     * Обновляет данные по id и entity
     * @param $data
     * @param $field_name
     * @param $id
     * @param $entity
     * @return mixed
     */
    public function updateDataByEntity($data, $field_name, $entity);


    /**
     * Удаляет расписание по id
     * @param $id
     * @return bool
     */
    public function deleteScheduleById($id);

    /**
     * Создает расписание
     * @param $duration_lesson_id
     * @param $pair_number_id
     * @param $student_group_id
     * @param $lessons_id
     * @param $description
     * @return Schedule|null
     */
    public function createSchedule($duration_lesson_id, $pair_number_id, $student_group_id, $lessons_id, $description = '');

    /**
     * Возвращает все семестры
     * @return Semester[]
     */
    public function getAllSemesters();

    /**
     * @param SemestersModel $model
     * @return Semester|bool
     */
    public function createSemester($model);

    /**
     * Удаляет сестер
     * @param $id
     * @return false
     */
    public function deleteSemesterById($id);

    /**
     * Возвращает семестр по id
     * @param $id
     * @return Semester
     */
    public function getSemesterById($id);

    /**
     * Обновляет по id
     * @param $id
     * @param $field
     * @param $value
     * @return void
     */
    public function updateSemester($id, $data);

    /**
     * Возвращает специальность по id
     * @return Specialty
     */
    public function getSpecialtyById($id);

    /**
     * Получает план расписания
     * @param $group_id
     * @param $semester_id
     * @return array
     */
    public function getPlanScheduleByGroupFroManager($group_id, $semester_id);

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return Semester[]
     */
    public function getSemestersByPeriod($start, $end);

    /**
     * Возвращает последовательность пар по номеру
     * @param $number
     * @return PairNumber
     */
    public function getPairByNumber($number);

    /**
     * Возвращает формат по id
     * @return FormatLesson
     */
    public function getFormatLessonsById($id);

    /**
     * @param \DateTime $date
     * @return Semester
     */
    public function getSemestersByDate($date);

    /**
     * Создает тип плана расписания
     * @param string $name
     * @param string $data
     * @return SchedulePlanType|false
     */
    public function addSchedulePlanType($name, $data);

    /**
     * Возвращает все типы планов расписания
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allSchedulePlanType();

    /**
     * Получает тип плана расписания по id
     * @param $id
     * @return SchedulePlanType
     */
    public function getSchedulePlanTypeById($id);

    /**
     * Изменяет тип плана расписания по id
     * @param $id
     * @param $name
     * @param $data
     * @return bool
     */
    public function editSchedulePlanTypeById($id, $name, $data);

    /**
     * Создает длительность пары для плана
     * @param $week_day
     * @param $time_start
     * @param $time_end
     * @param $week_number
     * @param $duration_minutes
     * @return PlanDurationLesson|false
     */
    public function addPlanDurationLessons($week_day, $time_start, $time_end, $week_number, $duration_minutes = null);

    /**
     * Обновляет длительность пары для плана
     * @param $id
     * @param $week_day
     * @param $time_start
     * @param $time_end
     * @param $week_number
     * @param $duration_minutes
     * @return PlanDurationLesson|false
     */
    public function updatePlanDurationLessons($id, $week_day, $time_start, $time_end, $week_number, $duration_minutes = null);

    /**
     * Создает план расписания
     * @param $plan_duration_lesson_id
     * @param $pair_number_id
     * @param $student_group_id
     * @param $semester_id
     * @param $plan_type_id
     * @param $lessons_id
     * @param $description
     * @return PlanSchedule|false
     */
    public function addSchedulePlan(
        $plan_duration_lesson_id,
        $pair_number_id,
        $student_group_id,
        $semester_id,
        $plan_type_id,
        $lessons_id,
        $description = ''
    );

    /**
     * Обновление урок для расписания
     * @param $id
     * @param $subject_id
     * @param $format_lesson_id
     * @param $user_id
     * @return Lesson|null
     */
    public function updateLessons($id, $subject_id, $format_lesson_id, $user_id);

    /**
     * Обновление описания плана расписания для формы
     * @param $id
     * @param $description
     * @return PlanSchedule|false
     */
    public function updateDescriptionSchedulePlan(
        $id,
        $description
    );

    /**
     * Получает первое расписание по группе в семестре
     * @param $group_id
     * @param $semester_id
     * @return PlanSchedule
     */
    public function getFirstPlanSchedule($group_id, $semester_id);

    /**
     * Возвращает план по семестру и группе
     * @param $semester_id
     * @param $group_id
     */
    public function getSchedulePlanTypeByGroupSemester($semester_id, $group_id);

    /**
     * Создает запись о празднике
     * @param $name
     * @param $date_start
     * @param $date_end
     * @param $week_days
     * @param $format_id
     * @param $description
     * @return Holiday|void
     */
    public function createHoliday($name, $date_start, $date_end, $week_days, $format_id, $description = null);

    /**
     * Возвращает все праздничные дни
     * @return Holiday[]
     */
    public function getAllHolidays();

    /**
     * Получает праздник по id
     * @param $id
     * @return Holiday
     */
    public function getHolidayById($id);

    /**
     * Обновляет запись о празднике
     * @param $id
     * @param $name
     * @param $period
     * @param $week_days
     * @param $format_id
     * @param $description
     * @return Holiday|void
     */
    public function editHoliday($id, $name, $date_start, $date_end, $week_days, $format_id, $description = null);

    /**
     * Удаляет праздник по id
     * @param $id
     * @return bool|null
     */
    public function deleteHoliday($id);

    /**
     * Возвращает праздники по дате
     * @param string $date
     * @return Holiday
     */
    public function getHolidayByDate($date);
}
