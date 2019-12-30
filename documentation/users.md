## <code>/users</code> [/users]

### Search for items [GET]
##### Available includes: [userSessions, roles, socialNetworks]
##### Available parameters <a href="#header-filters">See more...</a>
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[User, User])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: [userSessions, roles, socialNetworks]
[
{{rules}}
        ]
[
{{rules}}
        ]
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: User successfully created (string)
        + data: (User)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## <code>/users/bulk</code> [/users/bulk]
### Bulk create items [POST]
Available includes: [userSessions, roles, socialNetworks]
[
{{rules}}
        ]
[
{{rules}}
        ]
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Group of Users successfully created (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Bulk delete items [DELETE]
+ Request (application/json)
    <!-- include(request/header.md) -->    
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Group of Users successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## <code>/users/{id}</code> [/users/{id}]
### Update item [PUT]
Available includes: [userSessions, roles, socialNetworks]
<!-- include(parameters/id.md) -->
+ Request Rules:
    {
            "name": 'required',
            "avatar": 'required|image',

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {
            "name": fuga (string),
            "avatar": optio (string),

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: User successfully updated (string)
        + data: (User)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: [user]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (User)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->
### Delete item [DELETE]
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->    
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: User successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->



