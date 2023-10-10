<p align="center">
    <a href="https://github.com/njmdistrisoft/ProgramasAulas" target="_blank">
        <img src="http://web.curza.uncoma.edu.ar/cms/wp-content/themes/curza/img/logo_unc.png" height="100px">
    </a>
    <h1 align="center">Sistema de programas y aulas</h1>
    <h3> creado en [Yii Framework 2] (http://www.yiiframework.com/)</h3>
    <br>
</p>

## Consideraciones al momento de instalar
1. Se debe crear la carpeta `tmp` en el directorio `common/`
```shell
mkdir common/tmp
```
2. Crear la carpeta `programas` en api/web/public
```shell
mkdir -p api/web/public/programas
```
3. Es importante que las carpetas tengan como owner y group `www-data` o el usuario que posea permisos para su servidor web.
4. El `.env.example` es un ejemplo de las variables requeridas para el correcto funcionamiento del sistema
5. Puede consultar los registros (logs) de cada módulo en la carpeta `runtime/logs`. Por ejemplo, si hay una falla en el frontend puede consultar en `frontend/runtime/logs`.

## API
Puede consultar la api mediante la URL `{url}/api/v1/{resource}`. Los principales endpoints son:
- /departamento
- /asignatura
- /carrera
- /plan

