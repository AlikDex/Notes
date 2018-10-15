# Notes
Yii2 notes module

## Install
```

'modules' => [
    'notes' => [
        'class' => Adx\Module\NoteModule\Module::class,
    ],
],
```

## Db
```
'controllerMap' => [
    'migrate' => [
        'class' => yii\console\controllers\MigrateController::class,
        'migrationNamespaces' => [],
        'migrationPath' => [
            '@vendor/alikdex/notes/src/Migration',
        ],
    ],
],
```
or in composer
```
"post-update-cmd": [
    "php yii migrate --migrationPath=@vendor/alikdex/notes/src/Migration"
],
"post-install-cmd": [
    "php yii migrate --migrationPath=@vendor/alikdex/notes/src/Migration"
]
```
