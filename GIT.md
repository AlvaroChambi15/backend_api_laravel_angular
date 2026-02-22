## GIT

### Descargar e Instalar GIT

- https://git-scm.com/

## Crear una cuenta en (GITHUB - GITLAB - BITBUCKET)

- https://github.com

## Configurar GIT en su equipo

- Presentarse ante GIT

```
git config --global user.name "su nombre"
git config --global user.email "tu@correo.com"
```

---

## Crear un nuevo repositorio en (GITHUB)

- Ingresar a la pagina de GITHUB y Crear el Repositorio

## Configuración del Proyecto (Repositorio)

```
git init
// git remote add origin URL_DEL_REPOSITORIO_REMOTO
git remote add origin https://github.com/AlvaroChambi15/backend_api_laravel_angular.git
```

## Subir nuevos cambios al repositorio remoto (GITHUB)

```
git add .
git commit -m "Proyecto base con autenticación"
git push origin master
```

## Actualizar nuevos cambios

```
git pull origin master
```
