# Prueba técnica para Lleego

## Requisitos y objetivo de la prueba

Se entiende que la prueba pretende verificar los conocimientos del propio
framework como de arquitectura hexagonal. También se requiere el conocimiento de
la lectura de ficheros XML como SOAP.

## Suposiciones

Dado que tenemos los ficheros de datos tanto XML como SOAP, se entiende que no es
necesario persistir los datos en la base de datos, por lo que se hará uso solo de la
lectura de los ficheros.

Se realizará pruebas de integración y de aceptación (endpoints), las de integración
estarán enfocadas a casos de uso y commandos, la de aceptación a los endpoints.
Esto debería ser suficiente para llegar a un buen porcentaje de cobertura y no escribir
test redundantes y que no aporten valor.

## Puesta en marcha

Para la puesta en marcha del proyecto usaremos un fichero Makefile donde se reunirán
los scripts necesarios para lanzar por docker tanto los comandos como el servidor web.

## Testing

Utilizar el comando make para el uso de las diferentes acciones

Lazar test con detalle sobre cobertura:
```shell
make tests
```

## Servidor web

Mediante makefile usaremos en cli de symfony para facilitar este apartado
```shell
make up #symfony server:start --no-tls
```

Nota: Se debe tener instalado symfony cli

Se puede acceder al endpoint de la prueba en la ruta /api/avail

```
http://localhost:8000/api/avail?origin=MAD&destination=BIO&date=2022-06-01
```
