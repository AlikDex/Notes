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

## Migrations
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
"scripts": {
    "post-update-cmd": [
        "yes | php yii migrate --migrationPath=@vendor/alikdex/notes/src/Migration"
    ],
    "post-install-cmd": [
        "yes | php yii migrate --migrationPath=@vendor/alikdex/notes/src/Migration"
    ]
}
```
