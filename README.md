# Trabajo práctico especial (2da parte)- Web 2
## API Celulares

### Desarrollado por
- Mateo Fernandez

## Descripción del proyecto
Dando continuidad al proyecto iniciado en https://github.com/mateoymichis/tpe-web2, se desarrolla una API RESTful que utiliza la misma base de datos del proyecto anterior.
Se utilizaron las tecnologías trabajadas en la materia, por lo que este sitio cuenta con:
- <b>PHP</b> como lenguaje de desarrollo server side.
- <b>MySQL</b> como sistema de gestión de bases de datos.

## Endpoints

Todas las rutas indicadas son a partir de la URL base.


Elemento  | Valor
------------- | -------------
Descripción | Retorna una lista con todos los celulares. Puede paginarse, ordenarse y filtrarse
Endpoint  | /api/celulares
Verbo HTTP | GET
Parámetro opcional | order (**id**, modelo, descripcion, imagen, marca)
Parámetro opcional | direction (**asc**, desc)
Parámetro opcional | filter (**modelo**, descripcion, imagen, marca)
Parámetro opcional | value (string)
Parámetro opcional | lower (numero mayor o igual a 0) (**0**)
Parámetro opcional | results (numero mayor a 0 y menor a 51) (**10**)
Códigos de respuesta | 200, 404
Ejemplo de request | GET http://localhost/tpe/api/celulares?order=descripcion&direction=desc&filter=marca&value=moto&lower=0&results=5

Elemento  | Valor
------------- | -------------
Descripción | Retorna un celular dado su id
Endpoint  | /api/celulares/:ID
Verbo HTTP | GET
Parámetro | ID (numero positivo)
Códigos de respuesta | 200, 404
Ejemplo de request | GET http://localhost/tpe/api/celulares/12

Elemento  | Valor
------------- | -------------
Descripción | Crea un celular dado un json con sus atributos y valores
Endpoint  | /api/celulares
Verbo HTTP | POST
Body | Json con modelo, descripcion, imagen, marca_id
Códigos de respuesta | 201, 404
Ejemplo de request | POST http://localhost/tpe/api/celulares
Ejemplo de body | `{"modelo": "C115", "descripcion":"Gran celular retro","imagen":"http://server.com/imagen546", "marca_id":2}`

Elemento  | Valor
------------- | -------------
Descripción | Elimina un celular dado su id
Endpoint  | /api/celulares/:ID
Verbo HTTP | DELETE
Parámetro | ID (numero positivo)
Códigos de respuesta | 200, 404
Ejemplo de request | DELETE http://localhost/tpe/api/celulares/12

Elemento  | Valor
------------- | -------------
Descripción | Edita un celular dado su id
Endpoint  | /api/celulares/:ID
Verbo HTTP | PUT
Parámetro | ID (numero positivo)
Códigos de respuesta | 200, 404
Ejemplo de request | PUT http://localhost/tpe/api/celulares/12
Ejemplo de body | `{"modelo": "C115", "descripcion":"Gran celular retro","imagen":"http://server.com/imagen546", "marca_id":2}`

Elemento  | Valor
------------- | -------------
Descripción | Inicia sesión dado email y contraseña y retorna un bearer token
Endpoint  | /api/login
Verbo HTTP | POST
Body | Json con email y password
Códigos de respuesta | 200, 404
Ejemplo de request | POST http://localhost/tpe/api/login
Ejemplo de body | `{"email": "user@gmail.com", "password":"user"}`

Elemento  | Valor
------------- | -------------
Descripción | Crea un usuario dado email y contraseña
Endpoint  | /api/usuario
Verbo HTTP | POST
Body | Json con email y password
Códigos de respuesta | 201, 404
Ejemplo de request | POST http://localhost/tpe/api/usuario
Ejemplo de body | `{"email": "user@gmail.com", "password":"user"}`

Elemento  | Valor
------------- | -------------
Descripción | Retorna una lista con todas las marcas
Endpoint  | /api/marcas
Verbo HTTP | GET
Códigos de respuesta | 200, 404
Ejemplo de request | GET http://localhost/tpe/api/marcas


Elemento  | Valor
------------- | -------------
Descripción | Retorna una marca dado su id
Endpoint  | /api/marcas/:ID
Verbo HTTP | GET
Parámetro | ID (numero positivo)
Códigos de respuesta | 200, 404
Ejemplo de request | GET http://localhost/tpe/api/marcas/12

Elemento  | Valor
------------- | -------------
Descripción | Crea una marca dado un json con sus atributos y valores
Endpoint  | /api/marcas
Verbo HTTP | POST
Body | Json con nombre, cuit
Códigos de respuesta | 201, 404
Ejemplo de request | POST http://localhost/tpe/api/marcas
Ejemplo de body | `{"nombre": "Nokia", "cuit": "30684125792"}`

Elemento  | Valor
------------- | -------------
Descripción | Elimina una marca dado su id
Endpoint  | /api/marcas/:ID
Verbo HTTP | DELETE
Parámetro | ID (numero positivo)
Códigos de respuesta | 200, 404
Ejemplo de request | DELETE http://localhost/tpe/api/marcas/12

Elemento  | Valor
------------- | -------------
Descripción | Edita una marca dado su id
Endpoint  | /api/marca/:ID
Verbo HTTP | PUT
Parámetro | ID (numero positivo)
Códigos de respuesta | 200, 404
Ejemplo de request | PUT http://localhost/tpe/api/marcas/12
Ejemplo de body |`{"nombre": "Nokia", "cuit": "30684125792"}`