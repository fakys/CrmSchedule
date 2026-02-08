BEGIN;
-- Добавляем пользователя
INSERT INTO users(id,
                  username,
                  password)
VALUES (1,
        'system_user',
        '$2y$12$l9dcQj7D2M/bnY9V8mCxEuGuVhqf3XJtEvI3vyVdMn5PaaSnJ3DEG');
-- Добавляем системную группу
INSERT INTO user_groups(id,
                        name,
                        accesses,
                        active,
                        description)
VALUES (1, 'system',
        '["system_settings_crm_settings","system_settings_settings","modules_settings_settings","modules_settings_add_module","modules_settings_save_module","modules_settings_save_status_modules","users_interface_users_info","users_interface_tabs_users_tabs","users_interface_tabs_user_tabs","users_interface_tabs_edit_user_tabs","users_interface_tabs_set_edit_user_tabs","users_interface_tabs_get_access_tabs","users_interface_tabs_set_access_tabs","users_interface_tabs_get_role_tabs","users_interface_user_groups_info","users_interface_user_groups_add","users_interface_create_user_groups","users_interface_tabs_set_users_group_tabs","users_interface_edit_users_group_action","users_interface_edit_users_group","users_interface_delete_user_groups"]',
        true, 'Системная роль');
-- Добавляем системного пользователя в группу
INSERT INTO groups_users(id,
                         user_group_id,
                         users_id)
VALUES (1, 1, 1);
-- Добавляем в настройки, что пользователь системный
INSERT INTO system_settings(id,
                            name,
                            settings,
                            create_user_id)
VALUES (1, 'system_settings', '{"system_users":["1"],"system_user_groups":["1"]}', 1);
COMMIT;
