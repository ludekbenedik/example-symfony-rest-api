REST API
========

Tetst
-----

    curl -i -w "\n" -H "Content-Type: application/json" http://192.168.30.11/app_dev.php/api/v1/posts
    curl -i -w "\n" -H "Content-Type: application/xml" http://192.168.30.11/app_dev.php/api/v1/posts
    curl -i -w "\n" -H "Content-Type: application/json" http://192.168.30.11/app_dev.php/api/v1/posts/1
    curl -i -w "\n" -H "Content-Type: application/json" http://192.168.30.11/app_dev.php/api/v1/posts/1/comments

    | json_pp

    curl -i -w "\n" -H "Content-Type: application/json" -X POST -d '{}' http://192.168.30.11/app_dev.php/api/v1/posts/2/comments
    curl -i -w "\n" -H "Content-Type: application/json" -H "X-Api-Key: abcd" -X POST -d '{}' http://192.168.30.11/app_dev.php/api/v1/posts/2/comments
    curl -i -w "\n" -H "Content-Type: application/json" -H "X-Api-Key: abcd" -H "Accept-Language: cs" -X POST -d '{}' http://192.168.30.11/app_dev.php/api/v1/posts/2/comments
    curl -i -w "\n" -H "Content-Type: application/json" -H "X-Api-Key: abcd" -X POST -d '{"email":"lb@ludekbenedik.com","author":"bene","body":"ahoj"}' http://192.168.30.11/app_dev.php/api/v1/posts/2/comments
