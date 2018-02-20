# Gestión de sílabos por curso

Plugin para gestionar los sílabos en formato pdf por curso

## Instalación

Descarga el repositorio

`$ git clone https://github.com/johnny14028/silabos.git`

Agregar los requerimientos al composer.json en la raíz del proyecto.

```json
{
  "require": {
    "symfony/http-foundation": "^3.2",
    "symfony/routing": "^3.2",
    "symfony/http-kernel": "^3.2",
    "twig/twig": "^1.32",
    "symfony/console": "^3.2",
    "symfony/filesystem": "^3.2",
    "symfony/var-dumper": "^3.3",
    "symfony/twig-bundle": "^3.3",
    "symfony/framework-bundle": "^3.3",
    "symfony/templating": "^3.3",
    "symfony/yaml": "^3.3"
  },
  "autoload": {
    "psr-4": {
      "extrafields\\": "local/extrafields/"
    }
  }
}
```

Requerir el vendor en el archivo index.php del plugin

```php
// plugin/index.php
require_once $CFG->dirroot.'/vendor/autoload.php';

use silaboos\Core\Module;

$context_system = context_system::instance();

if (Module::isAjax()) {
    // Symfony Start.
    Module::start();
    // Symfony End.
} else {
    $name = get_string('name', 'local_silabos');

    $PAGE->set_context($context_system);
    $PAGE->navbar->add('Gestión de sílabos');
    $PAGE->set_title('Gestión de sílabos');
    $PAGE->set_heading('Gestión de sílabos');
    $PAGE->requires->js('/local/silabos/Resources/js/silabos.js');

    echo $OUTPUT->header();
    // Symfony Start.
    Module::start();
    // Symfony End.
    echo $OUTPUT->footer();
}
```
## Uso

Tener en cuenta el autoload para los diferentes plugins, cada uno debería estar cargado con sus respectivo namespace. Por ejemplo.

```json
"autoload": {
    "psr-4": {
      "<namespace1>\\": "local/<pluginname1>/",
      "<namespace2>\\": "report/<pluginname2>/",
      "<namespace3>\\": "local/<pluginname3>/"
    }
  }
```

Configurar los namespace en las distintas clases para evitar errores de dependencias. Ejemplos de namespace para el plugin silabos

<!-- language: php -->
```
// Controler/HomeController.php
namespace silabos\Controller;
```

Ejemplo dentro de Core/

<!-- language: php -->
```
// Core/Framework.php
namespace silabos\Core;
```

Ejemplo dentro de Model

<!-- language: php -->
```
// Model/HomeModel.php
namespace silabos\Model;
```
Ejemplo dentro de Service

<!-- language: php -->
```
// Service/HomeService.php
namespace silabos\Services;
```

#### Rutas

Las rutas están definidas en Resoruces/config/routes.yml

<!-- language: yml -->
```yml
index:
    path:     /
    Homes: { _controller: dashboard\Controller\HomeController::indexAction }
```

Material extra acerca de las rutas puede ser encontrado en la [documentación](http://symfony.com/doc/current/routing/requirements.html#adding-http-method-requirements) de Symfony2.

## Recomendación

Emplear las siguientes [directivas](https://drive.google.com/file/d/0B-taOEbTG5MbR2JXellHT184UTNoQ25pN1hSZzZvUWloZnow/view?usp=sharing) para la implemetanción de los distintos plugins en Moodle

## Contribución

1. Fork!!
2. Crea tu rama: `git checkout -b my-new-feature`
3. Commitea tus cambios: `git commit -am 'Add some feature'`
4. Pushea tus cambios: `git push origin my-new-feature`
5. Envía un pull request :D

## Todo

- Automatizar la creación de plugins mediante consola.
- Automatizar la creación de controladores con sus utils.

## History

V 1.0 Release

## License

Licensed under the MIT license.