<?php

return [
'models' => [
    /*
     * When using the "HasPermissions" trait from this package, we need to know which
     * Eloquent model should be used to retrieve your permissions. Of course, it
     * is often just the "Permission" model but you may use whatever you like.
     *
     * The model you want to use as a Permission model needs to implement the
     * `Spatie\Permission\Contracts\Permission` contract.
     */

    'permission' => Spatie\Permission\Models\Permission::class,

    /*
     * When using the "HasRoles" trait from this package, we need to know which
     * Eloquent model should be used to retrieve your roles. Of course, it
     * is often just the "Role" model but you may use whatever you like.
     *
     * The model you want to use as a Role model needs to implement the
     * `Spatie\Permission\Contracts\Role` contract.
     */

    'role' => Spatie\Permission\Models\Role::class,
],

/*
 * When set to true, the method for checking permissions will be registered on the gate.
 * Set this to false, if you want to implement custom logic for checking permissions.
 */

'register_permission_check_method' => true,

/*
 * When set to true the package will use the guard 'web' by default.
 * When set to false, the package will use the default guard 'auth'.
 */

'use_cache' => true,

/*
 * Define which column type will be used for the `model_id` in the pivot tables.
 * Possible values: 'char', 'string', 'uuid'.
 */

'column_names' => [
    'model_morph_key' => 'model_id',
    'team_foreign_key' => 'team_id',
],

'teams' => false,

'table_names' => [
    /*
     * When using the "HasRoles" trait from this package, we need to know which
     * table should be used to retrieve your roles. We have chosen a basic
     * default value but you may easily change it to any table you like.
     */

    'roles' => 'roles',

    /*
     * When using the "HasPermissions" trait from this package, we need to know which
     * table should be used to retrieve your permissions. We have chosen a basic
     * default value but you may easily change it to any table you like.
     */

    'permissions' => 'permissions',

    /*
     * When using the "HasPermissions" trait from this package, we need to know which
     * table should be used to retrieve your models permissions. We have chosen a
     * basic default value but you may easily change it to any table you like.
     */

    'model_has_permissions' => 'model_has_permissions',

    /*
     * When using the "HasRoles" trait from this package, we need to know which
     * table should be used to retrieve your models roles. We have chosen a
     * basic default value but you may easily change it to any table you like.
     */

    'model_has_roles' => 'model_has_roles',

    /*
     * When using the "HasRoles" trait from this package, we need to know which
     * table should be used to retrieve your roles permissions. We have chosen a
     * basic default value but you may easily change it to any table you like.
     */

    'role_has_permissions' => 'role_has_permissions',
],

'display_permission_in_exception' => false,

'display_role_in_exception' => false,

'enable_wildcard_permission' => false,

'cache' => [
    'expiration_time' => DateInterval::createFromDateString('24 hours'),
    'key' => 'spatie.permission.cache',
    'store' => 'default',
],

];
