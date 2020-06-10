# Backend

### Data base
There are two used databases, a MySQL one and a MongoDB one for notifications storage only.

### Routes

If not specified, the route needs an authentication JWT token. 

Users

    POST /users - creates a new user (doesn't need authentication token)
        input: 
            {
              "user_name": "UserName",
              "first_name": "FirstName",
              "last_name": "LastName",
              "email": "user@mail.com",
              "password": "12345678",
              "provider": true
            }
            
        output:
            {
              "id": "1",
              "user_name": "UserName",
              "first_name": "FirstName",
              "last_name": "LastName",
              "email": "user@mail.com",
              "provider": true,
              "avatar": {
                "url": "http://0.0.0.0:3333/tmp/uploads/image.jpeg",
                "name": "image.jpeg",
                "path": "image.jpeg"
              }
            }
    
    GET /users - returns all users
        input:
            no body
        
        output: 
              [
                {
                  "id": "1",
                  "user_name": "UserName",
                  "first_name": "FirstName",
                  "last_name": "LastName",
                  "email": "user@mail.com",
                  "password": "$2y$10$AwlIuUgzBQr5qxBkB.OodOH7eW\/52BddBdE9R9VpCPVj.zOfd7Qmi",
                  "provider": false,
                  "avatar_id": "18",
                  "created_at": "2020-04-06 17:59:59",
                  "updated_at": "2020-06-09 01:20:18"
                },
                {
                  "id": "2",
                  "user_name": "UserName2",
                  "first_name": "FirstName2",
                  "last_name": "LastName2",
                  "email": "user2@mail.com",
                  "password": "$2y$10$AwlIuUgzBQr5qxBkB.OodOH7eW\/52BddBdE9R9VpCPVj.zOfd7Qmi",
                  "provider": false,
                  "avatar_id": "18",
                  "created_at": "2020-04-06 17:59:59",
                  "updated_at": "2020-06-09 01:20:18"
                },
                {
                  "id": "3",
                  "user_name": "UserName3",
                  "first_name": "FirstName3",
                  "last_name": "LastName",
                  "email": "user3@mail.com",
                  "password": "$2y$10$AwlIuUgzBQr5qxBkB.OodOH7eW\/52BddBdE9R9VpCPVj.zOfd7Qmi",
                  "provider": false,
                  "avatar_id": "18",
                  "created_at": "2020-04-06 17:59:59",
                  "updated_at": "2020-06-09 01:20:18"
                }
              ]
              
    GET /users/show - shows the matching user
        input:
            {
              "login": "user@mail.com(or username)"
            }
            
        output:
            {
              "id": "1",
              "user_name": "UserName",
              "first_name": "FirstName",
              "last_name": "LastName",
              "email": "user@mail.com",
              "password": "$2y$10$BJTZHkGKnxx\/JEJZhtKI0e.3v9IhXSgtVnsvapJlL3FGch07Cm9rO",
              "provider": "1",
              "avatar_id": "1",
              "created_at": "2020-04-02 16:46:38",
              "updated_at": "2020-04-07 20:42:06",
              "name": "default-avatar.jpg",
              "path": "default-avatar.jpg"
            }

    PUT /users - updates the JSON's informations on the specified user by the token and returns
     the updated infos
        input example:
            {
              "first_name": "Usuário011"
            }
        
        output:
            {
              "id": "1",
              "user_name": "UserName",
              "first_name": "FirstName",
              "last_name": "LastName",
              "email": "user@mail.com",
              "provider": true,
              "avatar": {
                "url": "http://0.0.0.0:3333/tmp/uploads/image.jpeg",
                "name": "image.jpeg",
                "path": "image.jpeg"
              }
            }

     DELETE /users - deletes the specified user by token if the password matches
        input:
            {
              "password": "12345678"
            }
        
        output:
            true / false

Sessions

    POST /sessions (doesn't need authentication token)
        input: 
            {
               "login": "UserName"(or email),
               "password": "12345678"
            }

        output: 
            {
              "user": {
                "id": "1",
                "user_name": "UserName",
                "first_name": "FirstName",
                "last_name": "LastName",
                "email": "user@mail.com",
                "provider": true,
                "avatar": {
                  "url": "http://0.0.0.0:3333/tmp/uploads/image.jpeg",
                  "name": "image.jpeg",
                  "path": "image.jpeg"
                }
              },
              "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiMSIsImV4cCI6MTU5MTY5ODQ4MywiaXNzIjoibG9jYWxob3N0IiwiaWF0IjoxNTkxNjg4NDg0fQ.Am5YRGbYOczwVqxz1TsfWmc-SrPoPR70tuCJYCEg5rQ"
            }

Providers
    
    POST /providers - returns all providers
        input:
            [
              {
                "id": "1",
                "user_name": "UserName",
                "first_name": "FirstName",
                "last_name": "LastName",
                "email": "user@mail.com",
                "password": "$2y$10$AwlIuUgzBQr5qxBkB.OodOH7eW\/52BddBdE9R9VpCPVj.zOfd7Qmi",
                "provider": true,
                "avatar_id": "18",
                "created_at": "2020-04-06 17:59:59",
                "updated_at": "2020-06-09 01:20:18"
              },
              {
                "id": "2",
                "user_name": "UserName2",
                "first_name": "FirstName2",
                "last_name": "LastName2",
                "email": "user2@mail.com",
                "password": "$2y$10$AwlIuUgzBQr5qxBkB.OodOH7eW\/52BddBdE9R9VpCPVj.zOfd7Qmi",
                "provider": true,
                "avatar_id": "18",
                "created_at": "2020-04-06 17:59:59",
                "updated_at": "2020-06-09 01:20:18"
              }
            ]

    GET /providers/:provider_id/available - returns available dates/hours from the specified
     provider
        input:
            no body
        
        output:
            [
              {
                "time": "08:00",
                "value": "2020-05-02 08:00:00",
                "available": false
              },
              {
                "time": "09:00",
                "value": "2020-05-02 09:00:00",
                "available": false
              },
              {
                "time": "10:00",
                "value": "2020-05-02 10:00:00",
                "available": false
              },
              {
                "time": "11:00",
                "value": "2020-05-02 11:00:00",
                "available": false
              }
            ]

Schedule

    GET /schedule - returns the appointments from the specified user by token if it's a provider
        input: 
            no body
        
        output:

Files

    POST /files - replaces specified by token users avatar with the added image
        input:
            (multipart form/data)
            image - file.img
        
        output:
            true/false

Notifications


    GET /notifications - returns specified by token users notifications
        input:
            no body
        
        output:
            [
              {
                "_id": {
                  "$oid": "5edf0d6f4e1bf043d36df425"
                },
                "user": "21",
                "content": "Novo agendamento de New User Provider para o dia 15 do 06 de 2020 às 08:00.",
                "read": true,
                "created_at": "06-09-2020 01:17:51",
                "updated_at": "06-09-2020 01:17:51"
              },
              {
                "_id": {
                  "$oid": "5edf0d4d4e1bf043d36df424"
                },
                "user": "21",
                "content": "Novo agendamento de New User Provider para o dia 10 do 06 de 2020 às 10:00.",
                "read": false,
                "created_at": "06-09-2020 01:17:16",
                "updated_at": "06-09-2020 01:17:16"
              }
            ]
        
    PUT /notifications/:notification_id - updates the notification status from unread to read
        input: 
            no body
        
        output: 
            true/false

