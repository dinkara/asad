## <code>/srks</code> [/srks]

### Search for items [GET]
##### Available includes: []
##### Available parameters <a href="#header-filters">See more...</a>
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (array[Srk, Srk])

<!-- include(response/401.md) -->
<!-- include(response/500.md) -->
### Create item [POST]
Available includes: []
[
{{rules}}
        ]
[
{{rules}}
        ]
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Srk successfully created (string)
        + data: (Srk)

<!-- include(response/401.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->

## <code>/srks/bulk</code> [/srks/bulk]
### Bulk create items [POST]
Available includes: []
[
{{rules}}
        ]
[
{{rules}}
        ]
+ Response 201 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Group of Srks successfully created (string)
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
        + message: Group of Srks successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->

## <code>/srks/{id}</code> [/srks/{id}]
### Update item [PUT]
Available includes: []
<!-- include(parameters/id.md) -->
+ Request Rules:
    {

    }
+ Request (application/json)
    <!-- include(request/header.md) -->
    + Body
    {

    }
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Srk successfully updated (string)
        + data: (Srk)

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/422.md) -->
<!-- include(response/500.md) -->
### Get single item [GET]
Available includes: []
<!-- include(parameters/id.md) -->
+ Request (application/json)
    <!-- include(request/header.md) -->
+ Response 200 (application/json)
    + Attributes         
        + success: true (boolean)
        + message: Ok (string)
        + data: (Srk)

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
        + message: Srk successfully deleted (string)
        + data: null

<!-- include(response/401.md) -->
<!-- include(response/404.md) -->
<!-- include(response/500.md) -->



